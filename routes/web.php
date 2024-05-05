<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);


// Group routes under '/kategori' prefix
Route::prefix('kategori')->group(function () {
    // Define resourceful routes for categories
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/{id}/edit', [KategoriController::class, 'updateForm'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');
});

// Route::get('/user', [UserController::class, 'index']);

// Route::get('/user/tambah', [UserController::class, 'tambah']);

// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::delete('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index'); //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list'])->name('user.list'); //ambil data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create'])->name('user.create'); //menampilkan halaman form tambah
    Route::post('/', [UserController::class, 'store'])->name('user.store'); //menyimpan data user
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show'); //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); //menampilkan halaman form edit
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update'); //mengupdate data user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); //menghapus data user
});


Route::resource('barang', BarangController::class);

Route::resource('stok', StokController::class);

Route::resource('penjualan', PenjualanController::class);

Route::resource('penjualan_detail', PenjualanDetailController::class);

Route::resource('level', LevelController::class);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');


//atur untuk middleware menggunakan group pada routing
//di dalamnya terdapat group untuk cek kondisi login
//jika user login admin diarahkan ke AdminController
//jika user login user diarahkan ke UserController
Route::group(['middleware' => 'auth'], function () {
    Route::get('manager', function () {
        return response()->json(['message' => 'Welcome to Admin Page']);
    });
    // Route::group(['middleware' => ['cek_login:1']], function () {
    //     Route::resource('admin', AdminController::class);
    // });

    // Route::group(['middleware' => ['cek_login:2']], function () {
    //     // Route::resource('manager', ManagerController::class);
    //     Route::get('manager', function () {
    //         return response()->json(['message' => 'Welcome to Manager Page']);
    //     });
    // });
});
