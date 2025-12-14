@extends('layouts.admin')
@section('title', 'Peminjaman User')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Peminjaman Buku Saya</h1>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
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
                    Halaman ini menampilkan <strong>buku yang sedang Anda pinjam</strong>. 
                    Anda dapat mengembalikan buku dengan klik tombol <span class="badge badge-success">Kembalikan</span>.
                </p>
            </div>
        </div>

        <!-- Data Peminjaman Aktif -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-bookmark"></i> Buku yang Sedang Dipinjam
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
                                <th width="150">Aksi</th>
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
                                        
                                        @php
                                            $today = \Carbon\Carbon::now();
                                            $kembali = \Carbon\Carbon::parse($p->tanggal_kembali);
                                            $diffInDays = $today->diffInDays($kembali, false);
                                            $diff = ceil(abs($diffInDays));
                                            $isLate = $diffInDays < 0;
                                        @endphp
                                        
                                        @if($isLate)
                                            <br><span class="badge badge-danger">Terlambat {{ $diff }} hari</span>
                                        @elseif($diff <= 3 && $diff > 0)
                                            <br><span class="badge badge-warning">{{ $diff }} hari lagi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Dipinjam
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#kembalikanModal{{ $p->id }}"
                                                title="Kembalikan Buku">
                                            <i class="fas fa-undo"></i> Kembalikan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Anda belum meminjam buku apapun.</p>
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

<!-- MODAL KEMBALIKAN BUKU (USER) -->
@foreach($peminjaman as $p)
    <div class="modal fade" id="kembalikanModal{{ $p->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-undo"></i> Kembalikan Buku
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <strong><i class="fas fa-book"></i> Informasi Buku:</strong>
                        </div>
                        
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="130">Judul Buku</th>
                                <td><strong>{{ $p->book->judul }}</strong></td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>{{ $p->book->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td>
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Kembali</th>
                                <td>
                                    <i class="fas fa-calendar-check"></i>
                                    {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                                    
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $kembali = \Carbon\Carbon::parse($p->tanggal_kembali);
                                        $diffInDays = $today->diffInDays($kembali, false);
                                        $diff = ceil(abs($diffInDays));
                                        $isLate = $diffInDays < 0;
                                    @endphp
                                    
                                    @if($isLate)
                                        <br><span class="badge badge-danger mt-1">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Terlambat {{ $diff }} hari
                                        </span>
                                    @elseif($diff == 0)
                                        <br><span class="badge badge-warning mt-1">Jatuh tempo hari ini</span>
                                    @else
                                        <br><span class="badge badge-info mt-1">Sisa {{ $diff }} hari</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        
                        <hr>
                        
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i>
                            <strong>Konfirmasi:</strong>
                            <p class="mb-0">Apakah Anda yakin ingin mengembalikan buku ini? Stok buku akan bertambah setelah dikembalikan.</p>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Ya, Kembalikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection