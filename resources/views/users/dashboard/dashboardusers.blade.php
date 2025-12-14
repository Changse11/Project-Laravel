@extends('layouts.admin')
@section('title', 'Dashboard User')
@section('content')
<div id="content">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="text-muted">
                <i class="fas fa-calendar"></i> {{ date('d F Y') }}
            </div>
        </div>

        
        <!-- Welcome Card -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Selamat Datang, {{ Auth::user()->name }}!
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Selamat datang di Sistem Informasi Perpustakaan. Melalui dashboard ini, Anda dapat melihat dan mengelola aktivitas peminjaman buku dengan mudah dan cepat. Gunakan menu di samping untuk mencari koleksi buku, melihat daftar buku yang sedang Anda pinjam, serta memantau status peminjaman dan tanggal jatuh tempo.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row">

            <!-- Total Buku Tersedia -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Buku Tersedia</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBooks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Sedang Dipinjam -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Buku Sedang Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $myBorrowedBooks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book-reader fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sisa Hari Peminjaman -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Jatuh Tempo Terdekat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $closestDueDate ? $closestDueDate . ' hari' : '-' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Riwayat Peminjaman -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Riwayat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalHistory }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-history fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Data Tables Row -->
        <div class="row">

            <!-- Buku yang Sedang Dipinjam -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-book-open"></i> Buku yang Sedang Dipinjam
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($myActiveBorrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->book->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            @if($borrowing->tanggal_kembali)
                                                {{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}
                                                @php
                                                    $dueDate = \Carbon\Carbon::parse($borrowing->tanggal_kembali)->startOfDay();
                                                    $today = \Carbon\Carbon::now()->startOfDay();
                                                    $daysLeft = $today->diffInDays($dueDate, false);
                                                @endphp
                                                @if($daysLeft > 0)
                                                    <br><small class="text-success">({{ $daysLeft }} hari lagi)</small>
                                                @elseif($daysLeft == 0)
                                                    <br><small class="text-warning">(Hari ini)</small>
                                                @else
                                                    <br><small class="text-danger">(Terlambat {{ abs($daysLeft) }} hari)</small>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Dipinjam</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Anda belum meminjam buku</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Paling Populer -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fire"></i> Buku Paling Populer
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($popularBooks as $index => $book)
                        <div class="mb-3 pb-3 {{ $loop->last ? '' : 'border-bottom' }}">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <h4 class="text-primary font-weight-bold mb-0">{{ $index + 1 }}</h4>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold text-gray-800 mb-1">{{ $book->judul }}</h6>
                                    <small class="text-muted d-block">{{ $book->penulis }}</small>
                                    <div class="mt-2">
                                        <span class="badge badge-info">
                                            <i class="fas fa-book-reader"></i> {{ $book->peminjaman_count }} peminjaman
                                        </span>
                                        @if($book->stok > 0)
                                            <span class="badge badge-success">Tersedia</span>
                                        @else
                                            <span class="badge badge-secondary">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">Belum ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection