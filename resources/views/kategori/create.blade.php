{{-- @extends(layouts.app)

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

@section('content_body')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="form-group
                @error('nama')
                    has-error
                @enderror">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Kategori">
                    @error('nama')
                        <span class="help-block
                        text-danger">{{ $message }}</span>
                    @enderror --}}
