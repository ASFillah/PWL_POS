<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = UserModel::with('level')->get();
        return response()->json($users, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return response()->json($user, 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = UserModel::with('level')->findOrFail($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'level_id' => $request->level_id
        ]);

        return response()->json($user, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = UserModel::findOrFail($id);

        try {
            $user->delete();
            return response()->json(['message' => 'Data user berhasil dihapus!'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'], 409);
        }
    }
}


// class UserController extends Controller
// {
//     //Menampilkan halaman awal user
//     public function index()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Daftar User',
//             'list' => ['Home', 'User']
//         ];

//         $page = (object) [
//             'title' => 'Daftar user yang terdaftar dalam sistem'
//         ];

//         $activeMenu = 'user'; //set menu yang sedang aktif

//         $level = LevelModel::all(); //ambil data level untuk filter level

//         return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
//     }

//     // Ambil data user dalam bentuk json untuk datatables
//     public function list(Request $request)
//     {
//         $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

//         //Filter data berdasarkan level_id
//         if ($request->level_id) {
//             $users->where('level_id', $request->level_id);
//         }

//         return DataTables::of($users)
//             ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
//             ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
//                 $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
//                 $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
//                 $btn .= '<form class="d-inline-block" method="POST" action="'
//                     . url('/user/' . $user->user_id) . '">' . csrf_field() . method_field('DELETE') .
//                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
//                 return $btn;
//             })
//             ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
//             ->make(true);
//     }

//     //Menampilkan halaman form tambah user
//     public function create()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Tambah User',
//             'list' => ['Home', 'User', 'Tambah']
//         ];

//         $page = (object) [
//             'title' => 'Tambah User'
//         ];

//         $level = LevelModel::all(); //ambil data level untuk ditampilkan di form
//         $activeMenu = 'user'; //set menu yang sedang aktif
//         $level_id = LevelModel::all(); // Mengambil semua isi tabel

//         return view('user.create', ['level_id' => $level_id, 'breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
//     }

//     // Menyimpan data user baru
//     public function store(Request $request)
//     {
//         $request->validate([
//             //Username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
//             'username' => 'required|string|min:3|unique:m_user,username',
//             'nama' => 'required|string|max:100', //nama harus diisi, berupa string, maksimal 100 karakter
//             'password' => 'required|min:5', //password harus diisi, minimal 5 karakter
//             'level_id' => 'required|integer' //level_id harus diisi, berupa angka
//         ]);

//         UserModel::create([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => bcrypt($request->password), //password dienkripsi sebelum disimpan
//             'level_id' => $request->level_id
//         ]);

//         return redirect('/user')->with('status', 'Data user berhasil ditambahkan!');
//     }

//     //Menampilkan detail user
//     public function show(string $id)
//     {
//         $user = UserModel::with('level')->find($id); //ambil data user berdasarkan id

//         $breadcrumb = (object) [
//             'title' => 'Detail User',
//             'list' => ['Home', 'User', 'Detail']
//         ];

//         $page = (object) [
//             'title' => 'Detail User'
//         ];

//         $activeMenu = 'user'; //set menu yang sedang aktif

//         return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'useri' => $user, 'activeMenu' => $activeMenu]);
//     }

//     //Menampilkan halaman form edit user
//     public function edit(string $id)
//     {
//         $user = UserModel::find($id); //ambil data user berdasarkan id
//         $level = LevelModel::all(); //ambil data level untuk ditampilkan di form

//         $breadcrumb = (object) [
//             'title' => 'Edit User',
//             'list' => ['Home', 'User', 'Edit']
//         ];

//         $page = (object) [
//             'title' => 'Edit User'
//         ];

//         $activeMenu = 'user'; //set menu yang sedang aktif

//         return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
//     }

//     //Menyimpan perubahan data user
//     public function update(Request $request, string $id)
//     {
//         Log::info($request);
//         $request->validate([
//             //Username harus diisi, berupa string, minimal 3 karakter
//             //dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
//             'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
//             'nama' => 'required|string|max:100', //nama harus diisi, berupa string, maksimal 100 karakter
//             'password' => 'nullable|min:5', //password bisa diisi atau tidak, minimal 5 karakter
//             'level_id' => 'required|integer' //level_id harus diisi, berupa angka
//         ]);

//         UserModel::find($id)->update([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password, //password dienkripsi jika diisi
//             'level_id' => $request->level_id
//         ]);

//         return redirect('/user')->with('status', 'Data user berhasil diubah!');
//     }

//     //Menghapus data user
//     public function destroy(string $id)
//     {
//         $check = UserModel::find($id); //ambil data user berdasarkan id
//         if (!$check) { //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
//             return redirect('/user')->with('error', 'Data user tidak ditemukan!');
//         }

//         try {
//             UserModel::destroy($id); //hapus data level

//             return redirect('/user')->with('success', 'Data user berhasil dihapus!');
//         } catch (\Illuminate\Database\QueryException $e) {
//             //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
//             return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'); //jika terjadi error
//         }
//     }
// }
