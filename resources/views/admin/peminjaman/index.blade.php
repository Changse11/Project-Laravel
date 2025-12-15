@extends('layouts.admin')
@section('title', 'Data Peminjaman')
@section('content')
<div id="content">
    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Peminjaman Buku</h1>
        </div>

        <!-- Alert Success/Error -->
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
                    Halaman ini menampilkan data peminjaman buku oleh anggota perpustakaan. Admin dapat memantau status peminjaman, tanggal pinjam, tanggal kembali, 
                    serta melakukan pengelolaan pengembalian buku melalui tombol aksi yang tersedia.
                </p>
            </div>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Daftar Peminjaman
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <i class="fas fa-user"></i> 
                                        <strong>{{ $p->user->name }}</strong>
                                    </td>
                                    <td>{{ $p->book->judul }}</td>
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
                                    <td>
                                        @if($p->status == 'dipinjam')
                                            <button class="btn btn-success btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#kembalikanModalAdmin{{ $p->id }}"
                                                    title="Kembalikan Buku">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data peminjaman.</p>
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

<!-- MODAL KEMBALIKAN BUKU (ADMIN) -->
@foreach($peminjaman as $p)
    @if($p->status == 'dipinjam')
    <div class="modal fade" id="kembalikanModalAdmin{{ $p->id }}" tabindex="-1" role="dialog">
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
                
                <form action="{{ route('admin.peminjaman.kembalikan', $p->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <strong><i class="fas fa-book"></i> Informasi Peminjaman:</strong>
                        </div>
                        
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="130">Peminjam</th>
                                <td>
                                    <i class="fas fa-user"></i>
                                    <strong>{{ $p->user->name }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Judul Buku</th>
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
                            <p class="mb-0">Apakah Anda yakin ingin menarik kembali buku ini dari peminjam?
                                Stok buku akan bertambah dan status peminjaman akan berubah menjadi “Dikembalikan”.</p>
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
    @endif
@endforeach

@endsection