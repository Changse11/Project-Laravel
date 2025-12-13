@extends('layouts.admin')

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

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Selamat Datang!
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Selamat datang di Sistem Perpustakaan. Gunakan menu di samping untuk mengelola buku, kategori, dan data pengguna.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection