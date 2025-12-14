@extends('layouts.admin')
@section('title', 'Nambah Buku')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Buku Baru</h1>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Buku</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="judul">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               value="{{ old('judul') }}" placeholder="Masukkan judul buku">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penulis">Penulis <span class="text-danger">*</span></label>
                                <input type="text" name="penulis" id="penulis" 
                                       class="form-control @error('penulis') is-invalid @enderror" 
                                       value="{{ old('penulis') }}" placeholder="Masukkan nama penulis">
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penerbit">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" name="penerbit" id="penerbit" 
                                       class="form-control @error('penerbit') is-invalid @enderror" 
                                       value="{{ old('penerbit') }}" placeholder="Masukkan nama penerbit">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tahun_terbit">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit" 
                                       class="form-control @error('tahun_terbit') is-invalid @enderror" 
                                       value="{{ old('tahun_terbit') }}" placeholder="2024" min="1900" max="{{ date('Y') }}">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach(['Pendidikan', 'Teknologi', 'Novel', 'Agama', 'Sejarah'] as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="stok">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" id="stok" 
                                       class="form-control @error('stok') is-invalid @enderror" 
                                       value="{{ old('stok', 0) }}" placeholder="0" min="0">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="isbn">ISBN <span class="text-danger">*</span></label>
                        <input type="text" name="isbn" id="isbn" 
                               class="form-control @error('isbn') is-invalid @enderror" 
                               value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxx-x">
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Buku
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection