@extends('adminlte::page')

@section('title', 'Tambah Barang')

@section('content_header')
    <h1>Tambah Barang</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kategori_id">Kategori ID:</label>
                    <input type="text" class="form-control" id="kategori_id" name="kategori_id" value="{{ old('kategori_id') }}">
                </div>
                <div class="form-group">
                    <label for="barang_kode">Barang Kode:</label>
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ old('barang_kode') }}">
                </div>
                <div class="form-group">
                    <label for="barang_nama">Nama Barang:</label>
                    <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ old('barang_nama') }}">
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli:</label>
                    <input type="text" class="form-control" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}">
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual:</label>
                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop
