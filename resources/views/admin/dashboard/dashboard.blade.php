@extends('layouts.admin')
@section('title', 'Dashboard Admin')
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

        
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Selamat Datang, {{ Auth::user()->name }}!
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Dashboard ini adalah pusat kendali Anda untuk memantau aktivitas perpustakaan secara real-time. Di sini, Anda dapat mengelola koleksi buku, data anggota, memantau stok menipis, dan memastikan kelancaran layanan. Mari kita jaga sistem tetap optimal hari ini!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row">

            <!-- Total Buku Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Buku</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBooks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users/Anggota Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total User / Anggota</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Sedang Dipinjam Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Buku Sedang Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $booksBorrowed }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hand-holding fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stok Buku Menipis Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Stok Buku Menipis</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStock }}</div>
                                <small class="text-muted">(Stok ≤ 5)</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Data Tables Row -->
        <div class="row">

            <!-- Aktivitas Peminjaman Terbaru -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-clock"></i> Aktivitas Peminjaman Terbaru
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Peminjam</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBorrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->user->name }}</td>
                                        <td>{{ $borrowing->book->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            @if($borrowing->status == 'dipinjam')
                                                <span class="badge badge-warning">Dipinjam</span>
                                            @else
                                                <span class="badge badge-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data peminjaman</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Paling Banyak Dipinjam -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-fire"></i> Buku Paling Banyak Dipinjam
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">Belum ada data peminjaman</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection