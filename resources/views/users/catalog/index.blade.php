@extends('layouts.admin')
@section('title', 'Daftar Buku')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Katalog Buku</h1>
        </div>

        <!-- Alert Error -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> Gagal!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-check-circle"></i> Berhasil!</strong> {{ session('success') }}
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
                    Katalog buku perpustakaan ini menampilkan seluruh koleksi buku yang tersedia untuk dipinjam. Melalui menu ini, 
                    Anda dapat melihat informasi detail buku termasuk sinopsis, mengecek ketersediaan, serta melakukan peminjaman buku sesuai dengan ketentuan yang berlaku di perpustakaan.
                </p>
            </div>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Katalog Buku</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $index => $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $book->judul }}</strong></td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->tahun_terbit }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $book->kategori }}</span>
                                    </td>
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
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-sm" title="Detail Buku" 
                                                data-toggle="modal" data-target="#detailModal{{ $book->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Tombol Pinjam -->
                                        @if($book->stok > 0)
                                            <button class="btn btn-success btn-sm" title="Pinjam Buku" 
                                                    data-toggle="modal" data-target="#pinjamModal{{ $book->id }}">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled title="Stok Habis">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada buku tersedia saat ini.</p>
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

<!-- Modal Detail Buku -->
@foreach($books as $book)
<div class="modal fade" id="detailModal{{ $book->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-book"></i> Detail Buku
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">Judul Buku</th>
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
                                <th>Tahun Terbit</th>
                                <td>{{ $book->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><span class="badge badge-info">{{ $book->kategori }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">ISBN</th>
                                <td><code>{{ $book->isbn }}</code></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    @if($book->stok > 10)
                                        <span class="badge badge-success">{{ $book->stok }} Unit</span>
                                    @elseif($book->stok > 0)
                                        <span class="badge badge-warning">{{ $book->stok }} Unit</span>
                                    @else
                                        <span class="badge badge-danger">Stok Habis</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($book->sinopsis)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6 class="font-weight-bold mb-2">
                            <i class="fas fa-align-left"></i> Sinopsis
                        </h6>
                        <p class="text-justify" style="line-height: 1.8;">
                            {{ $book->sinopsis }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                @if($book->stok > 0)
                    <button type="button" class="btn btn-success" data-dismiss="modal" 
                            data-toggle="modal" data-target="#pinjamModal{{ $book->id }}">
                        <i class="fas fa-bookmark"></i> Pinjam Buku Ini
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Pinjam Buku -->
@foreach($books as $book)
<div class="modal fade" id="pinjamModal{{ $book->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-bookmark"></i> Pinjam Buku
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong><i class="fas fa-book"></i> Informasi Buku:</strong>
                    </div>
                    
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
                            <th>Stok</th>
                            <td><span class="badge badge-success">{{ $book->stok }} tersedia</span></td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Tanggal Pinjam</label>
                        <input type="date" 
                            name="tanggal_pinjam" 
                            class="form-control" 
                            value="{{ date('Y-m-d') }}" 
                            readonly 
                            style="background-color: #e9ecef;">
                        <small class="text-muted">Tanggal pinjam otomatis hari ini</small>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-calendar-check"></i> Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" 
                            name="tanggal_kembali" 
                            class="form-control" 
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                            max="{{ date('Y-m-d', strtotime('+14 days')) }}" 
                            value="{{ date('Y-m-d', strtotime('+7 days')) }}" 
                            required>
                        <small class="text-muted">Maksimal peminjaman 14 hari dari hari ini</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Konfirmasi Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection