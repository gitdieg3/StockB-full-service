<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">BarangKita :)</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">Pages</li>

            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('dashboard.analisis') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard.analisis') }}">
                    <i class="align-middle" data-feather="bar-chart-2"></i>
                    <span class="align-middle">Analytics</span>
                </a>
            </li>


            <li class="sidebar-item {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('barang.index') }}">
                    <i class="align-middle" data-feather="package"></i>
                    <span class="align-middle">Data Barang</span>
                </a>
            </li>


            <li class="sidebar-header">Tools & Components</li>

            <li class="sidebar-item {{ request()->routeIs('barangKeluar.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('barangKeluar.index') }}">
                    <i class="align-middle" data-feather="square"></i>
                    <span class="align-middle">Barang Keluar</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('tambahData') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('tambahData') }}">
                    <i class="align-middle" data-feather="square"></i>
                    <span class="align-middle">Barang Masuk</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="check-square"></i>
                    <span class="align-middle">Barang Pinjaman</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('master.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('master.index') }}">
                    <i class="align-middle" data-feather="grid"></i>
                    <span class="align-middle">Master Barang</span>
                </a>
            </li>

            <li class="sidebar-header">Plugins & Addons</li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="log-in"></i>
                    <span class="align-middle">Sign In</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="user-plus"></i>
                    <span class="align-middle">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>
</nav>