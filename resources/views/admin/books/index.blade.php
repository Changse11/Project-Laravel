@extends('layouts.admin')
@section('title', 'Kelola Buku')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Buku</h1>
            <a href="{{ route('books.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Buku</span>
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Info Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle"></i> Informasi 
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    Menu ini digunakan untuk mengelola seluruh koleksi buku perpustakaan, termasuk menambah buku baru, memperbarui data buku, menghapus data yang tidak diperlukan, serta memantau ketersediaan buku. 
                    Setiap buku memiliki informasi seperti judul, penulis, penerbit, tahun terbit, kategori, ISBN, dan stok.
                </p>
            </div>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Buku</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>ISBN</th>
                                <th>Stok</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $index => $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $book->judul }}</strong></td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->penerbit }}</td>
                                    <td>{{ $book->tahun_terbit }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $book->kategori }}</span>
                                    </td>
                                    <td><code>{{ $book->isbn }}</code></td>
                                    <td>
                                        @if($book->stok > 10)
                                            <span class="badge badge-success">{{ $book->stok }}</span>
                                        @elseif($book->stok > 0)
                                            <span class="badge badge-warning">{{ $book->stok }}</span>
                                        @else
                                            <span class="badge badge-danger">Habis</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $book->id }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data buku.</p>
                                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Buku Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Hapus Buku -->
@foreach($books as $book)
<div class="modal fade" id="deleteModal{{ $book->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- HEADER MERAH UNTUK HAPUS -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus Buku
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong><i class="fas fa-info-circle"></i> Peringatan!</strong>
                    <p class="mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                
                <p class="mb-3">Apakah Anda yakin ingin menghapus buku berikut?</p>
                
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="100">Judul</th>
                        <td><strong>{{ $book->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $book->penulis }}</td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $book->penerbit }}</td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td><code>{{ $book->isbn }}</code></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>
                            @if($book->stok > 10)
                                <span class="badge badge-success">{{ $book->stok }}</span>
                            @elseif($book->stok > 0)
                                <span class="badge badge-warning">{{ $book->stok }}</span>
                            @else
                                <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection