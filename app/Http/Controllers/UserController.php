<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //tambah data user dengan Eloquent Model
        /* $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345'),
        ];
        UserModel::create($data); */ //tambahkan data ke tabel <m_user></m_user>


        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];

        //akses model UserModel
        // $user = UserModel::find(1);
        $user = UserModel::where('level_id', 1)->first();
        return view('user', ['data' => $user]);
    }
}
