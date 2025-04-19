<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block">{{ Auth::user()->username }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Auth::user()->role == \App\Enums\RoleEnum::admin)
            <li class="nav-item menu-open">
                <a href="#" class="nav-link {{ in_array($activeMenu, ['user', 'mobil', 'kategori']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Data Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: block;">
                    <li class="nav-item">
                        <a href="/user" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/mobil" class="nav-link {{ $activeMenu == 'mobil' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Mobil</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/kategori" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>kategori</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ url('/transaksi') }}" class="nav-link {{ $activeMenu == 'transaksi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-handshake"></i>
                    <p>Transaksi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/laporan') }}" class="nav-link {{ $activeMenu == 'laporan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file"></i>
                    <p>Laporan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="nav-icon fas fa-clock"></i>
                    <p>Log Activity</p>
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-3 mt-2">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>