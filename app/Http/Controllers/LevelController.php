<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $activeMenu = 'level';
        $breadcrumb = (object) [
            'title' => 'Level Data Pengguna',
            'list' => ['Home', 'Level']
        ];
        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data, 'activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb]);
    }
}
