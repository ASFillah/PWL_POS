<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel as Barang;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return response()->json($barangs, 200);
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'kategori_id' => 'required',
            'barang_kode' => 'required|unique:m_barang',
            'barang_nama' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

        // Buat barang baru
        $barang = Barang::create($request->all());
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang, 200);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // Validasi request
        $request->validate([
            'kategori_id' => 'required',
            'barang_kode' => 'required|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
            'barang_nama' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

        // Perbarui barang
        $barang->update($request->all());
        return response()->json($barang, 200);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        try {
            // Hapus barang
            $barang->delete();
            return response()->json(['message' => 'Barang berhasil dihapus.'], 200);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json(['error' => 'Tidak dapat menghapus barang karena ada data yang terkait.'], 409);
            }
            // Jika error bukan karena constraint foreign key, lempar kembali error
            throw $e;
        }
    }
}


// class BarangController extends Controller
// {
//     public function index()
//     {

//         $breadcrumb = (object) [
//             'title' => 'Daftar Barang',
//             'list' => ['Home', 'Barang']
//         ];

//         $page = (object) [
//             'title' => 'Daftar barang yang terdaftar dalam sistem'
//         ];

//         $activeMenu = 'barang'; //set menu yang sedang aktif

//         $barangs = $requests = Barang::all();

//         return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
//     }

//     public function create()
//     {
//         $activeMenu = 'Tambah Barang';
//         $breadcrumb = (object) [
//             'title' => 'Tambah Data',
//             'list' => ['Home', 'Tambah Barang']
//         ];
//         return view('barang.create', ['activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb]);
//     }

//     public function store(Request $request)
//     {
//         // Validasi request
//         $request->validate([
//             'kategori_id' => 'required',
//             'barang_kode' => 'required|unique:m_barang',
//             'barang_nama' => 'required',
//             'harga_beli' => 'required',
//             'harga_jual' => 'required',
//         ]);

//         // Buat barang baru
//         Barang::create($request->all());

//         return redirect()->route('barang.index')
//             ->with('success', 'Barang berhasil ditambahkan.');
//     }
//     public function edit(string $id)
//     {
//         $barang = Barang::find($id);
//         // Log::info($barang);

//         $activeMenu = 'Edit Barang';
//         $breadcrumb = (object) [
//             'title' => 'Edit Data',
//             'list' => ['Home', 'Edit Barang']
//         ];

//         return view('barang.edit', compact('barang', 'activeMenu', 'breadcrumb'));
//     }



//     public function update(Request $request, Barang $barang)
//     {
//         // Validasi request

//         $request->validate([
//             'kategori_id' => 'required',
//             'barang_kode' => 'required|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
//             'barang_nama' => 'required',
//             'harga_beli' => 'required',
//             'harga_jual' => 'required',
//         ]);

//         // Perbarui barang
//         $barang->update($request->all());

//         return redirect()->route('barang.index')
//             ->with('success', 'Barang berhasil diperbarui.');
//     }


//     public function destroy(Barang $barang)
//     {
//         try {
//             // Hapus barang
//             $barang->delete();

//             return redirect()->route('barang.index')
//                 ->with('success', 'Barang berhasil dihapus.');
//         } catch (QueryException $e) {
//             if ($e->errorInfo[1] == 1451) {
//                 return redirect()->route('barang.index')
//                     ->with('error', 'Tidak dapat memperbarui barang karena ada data yang terkait.');
//             }

//             // Jika error bukan karena constraint foreign key, lempar kembali error
//             throw $e;
//         }
//     }
// }
