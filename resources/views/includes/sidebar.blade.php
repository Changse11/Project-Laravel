<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" 
       href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpustakaan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard') || Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- ========================================= -->
    <!-- MENU KHUSUS ADMIN -->
    <!-- ========================================= -->
    @if(Auth::user()->role === 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Management
        </div>

        <!-- Nav Item - Kelola User -->
        <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelola User</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Buku (Dropdown) -->
        <li class="nav-item {{ Request::is('admin/books*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBook"
                aria-expanded="true" aria-controls="collapseBook">
                <i class="fas fa-fw fa-book"></i>
                <span>Buku</span>
            </a>
            <div id="collapseBook" class="collapse {{ Request::is('admin/books*') ? 'show' : '' }}" 
                 aria-labelledby="headingBook" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Book Management:</h6>
                    <a class="collapse-item {{ Request::is('admin/books') && !Request::is('admin/books/create') ? 'active' : '' }}" 
                       href="{{ route('books.index') }}">Daftar Buku</a>
                    <a class="collapse-item {{ Request::is('admin/books/create') ? 'active' : '' }}" 
                       href="{{ route('books.create') }}">Tambah Buku</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Data Peminjaman -->
        <li class="nav-item {{ Request::is('admin/peminjaman*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.peminjaman') }}">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Data Peminjaman</span>
            </a>
        </li>

    @endif

    <!-- ========================================= -->
    <!-- MENU KHUSUS USER -->
    <!-- ========================================= -->
    @if(Auth::user()->role === 'user')
        <!-- Heading -->
        <div class="sidebar-heading">
            User Menu
        </div>

        <!-- Nav Item - Daftar Buku (Catalog) -->
        <li class="nav-item {{ Request::is('catalog*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.catalog.index') }}">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Daftar Buku</span>
            </a>
        </li>

        <!-- Nav Item - Peminjaman Buku (Sedang Dipinjam) -->
        <li class="nav-item {{ Request::is('peminjaman') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('peminjaman.aktif') }}">
                <i class="fas fa-fw fa-bookmark"></i>
                <span>Peminjaman Buku</span>
            </a>
        </li>

        <!-- Nav Item - Riwayat Buku -->
        <li class="nav-item {{ Request::is('riwayat*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('riwayat.peminjaman') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Buku</span>
            </a>
        </li>


    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>