<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{

    public function register(Request $request){

        $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'alamat' => 'required|string|min:3',
            'no_hp' => 'required|string|max:20',
        ], [
            //Custom error message
            'first_name.required' => 'Nama depan harus diisi',
            'last_name.required' => 'Nama belakang harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
        ]);

        $createData = User::create([
            'nama' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'role' => 'user',
            'tanggal_daftar' => now()
        ]);

        if ($createData) {
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silahkan login');
        } else {
            return redirect()->route('signup')->with('error', 'Gagal! silahkan coba lagi');
        }
    }


    public function loginAuth(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $data = $request->only('email', 'password');

   //Auth::attempt(), verifikasi kecocokan email pw atau username-pw
        if(Auth::attempt($data)){
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success','Berhasil login!');
            } elseif (Auth::user()->role == 'staff') {
                return redirect()->route('staff.dashboard')->with('success','Berhasil login!');
            } else {
                return redirect()->route('home')->with('success','Berhasil login!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal! pastikan email dan password sesuai');
        }
    }

    public function logout(){
        //Auth;;logout() : hapus sesi login
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda telah logout! silahkan login kembali untuk akses lengkap');
    }






    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::orderByRaw("FIELD(role, 'admin', 'staff', 'user')")->orderBy('id_user', 'asc')->get();
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::orderBy('nama_lok')->get();
        return view('admin.user.create', compact('locations'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama'      => 'required',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
        'id_lokasi' => 'required|exists:locations,id_lokasi',
        'no_hp'     => 'required'
    ], [
        'nama.required'      => 'Nama wajib diisi',
        'email.required'     => 'Email wajib diisi',
        'password.required'  => 'Password wajib diisi',
        'id_lokasi.required' => 'Lokasi wajib dipilih',
        'id_lokasi.exists'   => 'Lokasi tidak valid',
        'no_hp.required'     => 'No.Handphone wajib diisi'
    ]);

    User::create([
        'nama'       => $request->nama,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'id_lokasi'  => $request->id_lokasi,
        'no_hp'      => $request->no_hp,
        'role'       => 'staff',
        'tanggal_daftar' => now()
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Berhasil tambah data staff!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_user)
    {
        $user = User::find($id_user);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email salah'
        ]);

        $updateData = User::where('id_user', $id_user)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($updateData) {
            return redirect()->route('admin.users.index')->with('success', 'Berhasil mengubah data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_user)
    {
        User::where('id_user', $id_user)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus data!');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('users'));
    }

    public function restore($id_user)
    {
        $users = User::onlyTrashed()->find($id_user);
        $users->restore();
        return redirect()->route('admin.users.trash')->with('success', 'Berhasil mengembalikan data!');
    }

    public function deletePermanent($id_user)
    {
        $users = User::onlyTrashed()->find($id_user);
        $users->forceDelete();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus data secara permanen!');
    }

    public function exportExcel()
    {
        $fileName = 'users.xlsx';
        return Excel::download(new UserExport, $fileName);
    }

}