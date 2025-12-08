<?php

namespace App\Http\Controllers;

use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WasteTypeExport;
use Illuminate\Support\Facades\Hash;

class WasteTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wasteType = WasteType::orderByRaw("FIELD(kategori,'Kertas', 'Kaca', 'Logam', 'Plastik')")->orderBy('id_jenis', 'asc')->get();
        return view('admin.waste-type.index', compact('wasteType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.waste-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'poin_per_kg' => 'required|numeric|min:1',
            'kategori' => 'required',
            'deskripsi_jenis' => 'required|min:10',
        ], [
            'nama_jenis.required' => 'Nama jenis sampah wajib diisi',
            'poin_per_kg.required' => 'Poin per kg jenis sampah wajib diisi',
            'kategori.required' => 'Kategori jenis sampah wajib diisi',
            'deskripsi_jenis.required' => 'Deskripsi jenis sampah wajib diisi',
            'deskripsi_jenis.min' => 'Deskripsi jenis sampah minimal 10 karakter',
        ]);

        $createData = WasteType::create([
            'nama_jenis' => $request->nama_jenis,
            'poin_per_kg' => $request->poin_per_kg,
            'kategori' => $request->kategori,
            'deskripsi_jenis' => $request->deskripsi_jenis,
        ]);

        if ($createData) {
            return redirect()->route('admin.waste-types.index')->with('success', 'Berhasil menambah jenis sampah!');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_jenis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_jenis)
    {
        $wasteType = WasteType::find($id_jenis);
        return view('admin.waste-type.edit', compact('wasteType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_jenis)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'poin_per_kg' => 'sometimes|numeric|min:1',
            'kategori' => 'required',
            'deskripsi_jenis' => 'sometimes|min:10',
        ], [
            'nama_jenis.required' => 'Nama jenis sampah wajib diisi',
            'poin_per_kg.required' => 'Poin per kg jenis sampah wajib diisi',
            'poin_per_kg.numeric' => 'Poin per kg jenis sampah harus berupa angka',
            'poin_per_kg.min' => 'Poin per kg jenis sampah minimal 1kg',
            'kategori.required' => 'Kategori jenis sampah wajib diisi',
            'deskripsi_jenis.required' => 'Deskripsi jenis sampah wajib diisi',
            'deskripsi_jenis.min' => 'Deskripsi jenis sampah minimal 10 karakter',
        ]);

        $updateData = WasteType::where('id_jenis', $id_jenis)->update([
            'nama_jenis' => $request->nama_jenis,
            'poin_per_kg' => $request->poin_per_kg,
            'kategori' => $request->kategori,
            'deskripsi_jenis' => $request->deskripsi_jenis,
        ]);

        if ($updateData) {
            return redirect()->route('admin.waste-types.index')->with('success', 'Berhasil mengubah jenis sampah!');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_jenis)
    {
        $wasteType = WasteType::where('id_jenis', $id_jenis)->delete();
        return redirect()->route('admin.waste-types.index')->with('error', 'Berhasil menghapus jenis sampah!');
    }

    public function trash()
    {
        $wasteType = WasteType::onlyTrashed()->get();
        return view('admin.waste-type.trash', compact('wasteType'));
    }

    public function restore($id_jenis)
    {
        $wasteType = WasteType::onlyTrashed()->find($id_jenis);
        $wasteType->restore();
        return redirect()->route('admin.waste-types.trash')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id_jenis)
    {
        $wasteType = WasteType::onlyTrashed()->find($id_jenis);
        $wasteType->forceDelete();
        return redirect()->route('admin.waste-types.index')->with('success', 'Berhasil menghapus data secara permanen!');
    }

    public function exportExcel()
    {
        $fileName = 'jenis-sampah.xlsx';
        return Excel::download(new WasteTypeExport, 'jenis-sampah.xlsx');
    }
}
