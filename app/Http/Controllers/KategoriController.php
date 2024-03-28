<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        Log::info('Showing user profile for DataTable: '. get_class($dataTable));
        return $dataTable->render('kategori.index');
    }
    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
       $validated = $request->validate([
        'title' => 'bail|required|unique:posts|max:255',
        'body' => 'required',
       ]);

         return redirect('/kategori');
    }
}

