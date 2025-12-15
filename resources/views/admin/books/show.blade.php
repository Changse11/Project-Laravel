@extends('layouts.admin')
@section('title', 'Detail Buku')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Buku</h1>
            <div>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Book Detail Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-book"></i> {{ $book->judul }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Judul Buku</th>
                                <td>: <strong>{{ $book->judul }}</strong></td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>: {{ $book->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>: {{ $book->penerbit }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>: {{ $book->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: <span class="badge badge-info">{{ $book->kategori }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">ISBN</th>
                                <td>: <code>{{ $book->isbn }}</code></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>: 
                                    @if($book->stok > 10)
                                        <span class="badge badge-success">{{ $book->stok }} Unit</span>
                                    @elseif($book->stok > 0)
                                        <span class="badge badge-warning">{{ $book->stok }} Unit</span>
                                    @else
                                        <span class="badge badge-danger">Stok Habis</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>: {{ $book->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diubah</th>
                                <td>: {{ $book->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($book->sinopsis)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-weight-bold mb-3">
                            <i class="fas fa-align-left"></i> Sinopsis
                        </h5>
                        <p class="text-justify" style="line-height: 1.8;">
                            {{ $book->sinopsis }}
                        </p>
                    </div>
                </div>
                @endif

                <hr>

                <div class="text-right">
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Buku
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash"></i> Hapus Buku
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus buku <strong>{{ $book->judul }}</strong>?</p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection