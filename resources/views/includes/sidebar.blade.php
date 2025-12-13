<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpustakaan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - admin.dashboard -->
    <li class="nav-item {{ Request::is('admin') || Request::is('admin/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - User (CUMA DAFTAR USER) -->
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola User</span>
        </a>
    </li>

    <!-- Nav Item - Book -->
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
                <a class="collapse-item" href="{{ route('books.index') }}">Daftar Buku</a>
                <a class="collapse-item" href="{{ route('books.create') }}">Tambah Buku</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>