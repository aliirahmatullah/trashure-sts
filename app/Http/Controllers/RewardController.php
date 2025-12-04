<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RewardExport;


class RewardController extends Controller
{
    public function index()
    {
        $reward = Reward::orderBy('p_dibutuhkan', 'asc')->get();
        return view('admin.reward.index', compact('reward'));
    }

    public function home()
    {
        $reward = Reward::where('stok', '>', 0)->orderBy('created_at', 'desc')->limit(4)->get();
        return view('home', compact('reward'));
    }

    public function homeReward()
    {
        $reward = Reward::where('stok', '>', 0)->orderBy('created_at', 'desc')->get();
        return view('reward', compact('reward'));
    }

    public function create()
    {
        return view('admin.reward.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hadiah' => 'required',
            'desk_hadiah' => 'required|min:10',
            'p_dibutuhkan' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'gambar_hadiah' => 'required|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ], [
            'nama_hadiah.required' => 'Nama hadiah wajib diisi',
            'desk_hadiah.required' => 'Deskripsi hadiah wajib diisi',
            'desk_hadiah.min' => 'Deskripsi minimal 10 karakter',
            'p_dibutuhkan.required' => 'Poin dibutuhkan wajib diisi',
            'stok.required' => 'Stok wajib diisi',
            'gambar_hadiah.required' => 'Gambar hadiah wajib diisi',
            'gambar_hadiah.image' => 'File harus berupa gambar',
            'gambar_hadiah.mimes' => 'Format gambar harus jpg, jpeg, png, svg, atau webp',
        ]);

        $file = $request->file('gambar_hadiah');
        $filename = uniqid() . '-reward.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('reward', $filename, 'public');

        Reward::create([
            'nama_hadiah' => $request->nama_hadiah,
            'desk_hadiah' => $request->desk_hadiah,
            'p_dibutuhkan' => $request->p_dibutuhkan,
            'stok' => $request->stok,
            'gambar_hadiah' => $path,
        ]);

        return redirect()->route('admin.rewards.index')->with('success', 'Berhasil menambah data hadiah!');
    }

    public function edit($id_hadiah)
    {
        $reward = Reward::findOrFail($id_hadiah);
        return view('admin.reward.edit', compact('reward'));
    }

    public function update(Request $request, $id_hadiah)
    {
        $request->validate([
            'nama_hadiah' => 'required',
            'desk_hadiah' => 'required|min:10',
            'p_dibutuhkan' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'gambar_hadiah' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $reward = Reward::findOrFail($id_hadiah);

        if ($request->hasFile('gambar_hadiah')) {
            // Hapus gambar lama
            if ($reward->gambar_hadiah && Storage::disk('public')->exists($reward->gambar_hadiah)) {
                Storage::disk('public')->delete($reward->gambar_hadiah);
            }

            $file = $request->file('gambar_hadiah');
            $filename = uniqid() . '-reward.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('reward', $filename, 'public');
            $reward->gambar_hadiah = $path;
        }

        $reward->update([
            'nama_hadiah' => $request->nama_hadiah,
            'desk_hadiah' => $request->desk_hadiah,
            'p_dibutuhkan' => $request->p_dibutuhkan,
            'stok' => $request->stok,
        ]);

        return redirect()->route('admin.rewards.index')->with('success', 'Berhasil mengubah data hadiah!');
    }

    public function destroy($id_hadiah)
    {
        $reward = Reward::find($id_hadiah);
        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('error', 'Berhasil menghapus data hadiah!');
    }

    public function trash() {
        $reward = Reward::onlyTrashed()->get();
        return view('admin.reward.trash', compact('reward'));
    }

    public function restore($id_hadiah) {
        $reward = Reward::onlyTrashed()->find($id_hadiah);
        $reward->restore();
        return redirect()->route('admin.rewards.index')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id_hadiah) {
        $reward = Reward::onlyTrashed()->find($id_hadiah);
        if ($reward->gambar_hadiah && Storage::disk('public')->exists($reward->gambar_hadiah)) {
            Storage::disk('public')->delete($reward->gambar_hadiah);
        }
        $reward->forceDelete();
        return redirect()->route('admin.rewards.index')->with('success', 'Berhasil menghapus data secara permanen!');
    }


    public function exportExcel()
    {
        $fileName = 'data-hadiah.xlsx';
        return Excel::download(new RewardExport, $fileName);
    }
}