@extends('layouts.admin')
@section('title', 'Riwayat Peminjaman')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Riwayat Peminjaman Buku</h1>
        </div>

        <!-- Info Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle"></i> Informasi
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    Halaman ini menampilkan <strong>seluruh riwayat peminjaman buku</strong> Anda, 
                    termasuk buku yang sedang dipinjam dan yang sudah dikembalikan.
                </p>
            </div>
        </div>

        <!-- Data Riwayat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-history"></i> Riwayat Peminjaman
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $p->book->judul }}</strong></td>
                                    <td>{{ $p->book->penulis }}</td>
                                    <td>
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-check"></i>
                                        {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($p->status == 'dipinjam')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Dipinjam
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> Dikembalikan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Anda belum pernah meminjam buku.</p>
                                            <a href="{{ route('users.catalog.index') }}" class="btn btn-primary">
                                                <i class="fas fa-book"></i> Lihat Katalog Buku
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
@endsection