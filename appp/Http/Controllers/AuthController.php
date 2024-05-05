<?php 

namespace App\Http\UserModel;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        // ambil data user lalu simpan pada vae $user
        $user = Auth::user();

        //kondisi jika usernya ada
        if($user){
            //jika usernya memiliki level admin
            if($user-> level_id == '1'){
                return redirect()->intended('admin');
            }
            //jika usernya memiliki level manager
            elseif($user->level_id == '2'){
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request)
    {
        //buat validasi saat tombol login di klik
        //validasi username & password wajib diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        //ambil data request username & password saja
        $credentials = $request->only('username', 'password');
        //cek jika data username dan password valid (sesuai) dengan data
        if(Auth::attempt($credentials)){
            //jika berhasil simpan data user ya di variable $user
            $user = Auth::user();

            //cek lagi jika level user admin maka diarahkan ke halaman admin
            if($user->level_id == '1'){
                //dd($user->level_id);
                return redirect()->intended('admin');
            }

            //cek lagi jika level user manager maka diarahkan ke halaman manager   
            elseif($user->level_id == '2'){
                return redirect()->intended('manager');
            }
            //jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }

    //jika tdk ada data user yg valid maka kembalikan lagi ke halaman login
    //pastikan kirim pesan error jika login gagal
    return redirect('login')
        ->withInput()
        ->withErrors(['login_gagal' => 'Pastikan username dan password benar']);
    }

    public function register(){
        //tampilkan view register
        return view('register');
    }

    //aksi form register
    public function proses_register(Request $request) 
    {
        //validasi proses register
        //semua field wajib diisi
        //username harus unique
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|unique:users',
            'level_id' => 'required'
        ]);

        //jika gagal kembali ke halaman register dan muncul pesan error
        if($validator->fails()){
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        //jika berhasil isi level dan hash pada password agar secure
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request['password']);

        //masukkan semua data pada request ke table users
        UserModel::create($request->all());

        //jika berhasil arahkan ke halaman login
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        //logout harus menghapus semua session
        $request->session()->flush();

        //jalan kan fungsi logout dari auth
        Auth::logout();
        //kembalikan ke halaman login
        return redirect()->route('login');
    }
}