<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokModel as Stok;
use App\Models\BarangModel as Barang;
use App\Models\UserModel as User;
use Illuminate\Support\Facades\Log;

class StokController extends Controller
{
    public function index()
    {
        $stoks = Stok::with('barang', 'user')->get();

        Log::info('Stok: ' . $stoks);

        return view('stok.index', compact('stoks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $users = User::all();
        return view('stok.create', compact('barangs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        Stok::create($request->all());

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit(Stok $stok)
    {
        $barangs = Barang::all();
        $users = User::all();
        return view('stok.edit', compact('stok', 'barangs', 'users'));
    }

    public function update(Request $request, Stok $stok)
    {
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        $stok->update($request->all());

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy(Stok $stok)
    {
        $stok->delete();

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil dihapus.');
    }
}
