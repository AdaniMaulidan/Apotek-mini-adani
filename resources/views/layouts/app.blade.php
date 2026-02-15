<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - Apotek Adani</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SB Admin 2 CSS (CDN-like but using standard Bootstrap + Custom structure) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #5a5c69;
            --background: #f8f9fc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background);
            overflow-x: hidden;
        }

        #wrapper { display: flex; }
        
        /* Sidebar Styles */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            transition: all 0.3s;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        #sidebar .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.1);
        }

        #sidebar .nav-item { padding: 0.1rem 0; }
        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
        }

        #sidebar .sidebar-heading {
            padding: 1.5rem 1.5rem 0.5rem;
            text-transform: uppercase;
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255,255,255,0.4);
        }

        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            text-decoration: none;
        }

        #sidebar .nav-link i { font-size: 1rem; width: 20px; }

        /* Content Styles */
        #content-wrapper {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fc;
        }

        .topbar {
            height: 4.375rem;
            background: #fff;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
            margin-bottom: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            border-radius: 0.75rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-primary { background-color: var(--primary); border-color: var(--primary); border-radius: 0.5rem; }
        .btn-success { background-color: var(--success); border-color: var(--success); border-radius: 0.5rem; }

        .badge { font-weight: 600; padding: 0.35em 0.65em; border-radius: 0.35rem; }
        
        @media (max-width: 768px) {
            #sidebar { width: 0; display: none; }
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul id="sidebar" class="navbar-nav sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-prescription-bottle-alt"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Apotek Adani</div>
            </a>

            <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(255,255,255,0.15);">

            @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <div class="sidebar-heading px-4 text-white-50 small mt-3">Inventory</div>
                
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'apoteker')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('obat') ? 'active' : '' }}" href="{{ route('obat.index') }}">
                            <i class="fas fa-fw fa-pills"></i>
                            <span>Daftar Obat</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('obat-kadaluarsa') ? 'active' : '' }}" href="{{ route('obat.expired') }}">
                            <i class="fas fa-fw fa-calendar-times"></i>
                            <span>Obat Kadaluarsa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                            <i class="fas fa-fw fa-truck"></i>
                            <span>Supplier</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}" href="{{ route('pembelian.index') }}">
                            <i class="fas fa-fw fa-shopping-cart"></i>
                            <span>Pembelian Stok</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role == 'admin')
                    <div class="sidebar-heading px-4 text-white-50 small mt-3">Admin Panel</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pelanggan*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                            <i class="fas fa-fw fa-users"></i>
                            <span>Data Pelanggan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-fw fa-user-shield"></i>
                            <span>Manajemen Staf</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('laporan/penjualan') ? 'active' : '' }}" href="{{ route('penjualan.report') }}">
                            <i class="fas fa-fw fa-file-invoice-dollar"></i>
                            <span>Laporan Penjualan</span>
                        </a>
                    </li>
                @endif

                <div class="sidebar-heading px-4 text-white-50 small mt-3">Transactions</div>
                @if(auth()->user()->role == 'pelanggan')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('katalog') ? 'active' : '' }}" href="{{ route('pelanggan.katalog') }}">
                            <i class="fas fa-fw fa-store"></i>
                            <span>Katalog Belanja</span>
                        </a>
                    </li>
                @endif
                
                @if(auth()->user()->role == 'apoteker' || auth()->user()->role == 'pelanggan' || auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                            <i class="fas fa-fw fa-cash-register"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <div id="content">
                <!-- Topbar -->
                <nav class="topbar navbar-light bg-white static-top">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="ml-auto d-flex align-items-center">
                        @auth
                            <div class="dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                    <img class="img-profile rounded-circle" style="width: 30px;" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=4e73df&color=fff">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
