<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Provinsi;
use Laravolt\Indonesia\Models\City;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LocationExport;


class LocationController extends Controller
{
    public function index()
    {
        $location = Location::with(['province', 'city'])->orderBy('provinsi', 'asc')->orderBy('kota', 'asc')->orderBy('nama_lok', 'asc')->get();
        return view('admin.location.index', compact('location'));
    }

    public function create()
    {
        $provinces = Provinsi::orderBy('name')->pluck('name', 'id');
        return view('admin.location.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lok'   => 'required',
            'alamat_lok' => 'required|min:10',
            'provinsi'   => 'required|string|max:100',
            'kota'       => 'required|string|max:100',
            'kontak_lok' => 'required|numeric',
        ], [
            'nama_lok.required'   => 'Nama lokasi wajib diisi',
            'alamat_lok.required' => 'Alamat lokasi wajib diisi',
            'alamat_lok.min'      => 'Alamat lokasi minimal 10 karakter',
            'provinsi.required'   => 'Provinsi wajib dipilih',
            'kota.required'       => 'Kota wajib dipilih',
            'kontak_lok.required' => 'Kontak lokasi wajib diisi',
            'kontak_lok.numeric'  => 'Kontak lokasi harus berupa angka',
        ]);

        // Ganti ID jadi Nama Sebelum Insert
        $namaProvinsi = Provinsi::where('id', $request->provinsi)->value('name');
        $namaKota     = City::where('id', $request->kota)->value('name');

        $request->merge([
            'provinsi' => $namaProvinsi,
            'kota'     => $namaKota,
        ]);

        Location::create($request->only([
            'nama_lok', 'alamat_lok', 'provinsi', 'kota', 'kontak_lok'
        ]));

        return redirect()->route('admin.locations.index')
                         ->with('success', 'Berhasil menambah data lokasi!');
    }

    public function edit($id_lokasi)
    {
        $location  = Location::findOrFail($id_lokasi);
        $provinces = Provinsi::orderBy('name')->pluck('name', 'id');

        $cities = [];
        if ($location->provinsi) {
            $province = Provinsi::find($location->provinsi);
            $cities   = $province ? $province->cities()->orderBy('name')->pluck('name', 'id') : [];
        }

        return view('admin.location.edit', compact('location', 'provinces', 'cities'));
    }

    public function update(Request $request, $id_lokasi)
    {
        $request->validate([
            'nama_lok'   => 'required',
            'alamat_lok' => 'required|min:10',
            'provinsi'   => 'required|string|max:100',
            'kota'       => 'required|string|max:100',
            'kontak_lok' => 'required|numeric',
        ]);

        // Ganti ID jadi Nama Sebelum Update
        $namaProvinsi = Provinsi::where('id', $request->provinsi)->value('name');
        $namaKota     = City::where('id', $request->kota)->value('name');

        $request->merge([
            'provinsi' => $namaProvinsi,
            'kota'     => $namaKota,
        ]);

        Location::where('id_lokasi', $id_lokasi)
                ->update($request->only([
                    'nama_lok', 'alamat_lok', 'provinsi', 'kota', 'kontak_lok'
                ]));

        return redirect()->route('admin.locations.index')
                         ->with('success', 'Berhasil mengubah data lokasi!');
    }

    public function destroy($id_lokasi)
    {
        Location::where('id_lokasi', $id_lokasi)->delete();
        return redirect()->route('admin.locations.index')
                         ->with('error`', 'Berhasil menghapus lokasi!');
    }

    public function trash()
    {
        $location = Location::onlyTrashed()->get();
        return view('admin.location.trash', compact('location'));
    }

    public function restore($id_lokasi)
    {
        $location = Location::onlyTrashed()->find($id_lokasi);
        $location->restore();
        return redirect()->route('admin.locations.index')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id_lokasi)
    {
        $location = Location::onlyTrashed()->find($id_lokasi);
        $location->forceDelete();
        return redirect()->route('admin.locations.index')->with('success', 'Berhasil menghapus data secara permanen!');
    }


    // AJAX dropdown kota
    public function cities($provinceId)
    {
        $province = Provinsi::findOrFail($provinceId);
        $cities   = $province->cities()->orderBy('name')->get(['id', 'name']);
        return response()->json($cities);
    }

    public function exportExcel()
    {
        $fileName = 'data-location.xlsx';
        return Excel::download(new LocationExport, $fileName);
    }
}