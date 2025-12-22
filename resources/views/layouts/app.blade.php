<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - BSU Hidayah Geneva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
    .wrapper {
        display: flex;
    }

    .sidebar {
        width: 260px; /* lebar sidebar */
        flex-shrink: 0;
    }

    .main-content {
        margin-left: 260px; /* geser konten */
        width: calc(100% - 260px);
    }
</style>

</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h5>BSU Hidayah Geneva</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/nasabah" class="nav-link {{ request()->is('nasabah*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Nasabah
                </a>
            </li>
            <li class="nav-item">
                <a href="/jenissampah" class="nav-link {{ request()->is('jenisssampah*') ? 'active' : '' }}">
                    <i class="fas fa-recycle"></i> Data Sampah
                </a>
            </li>
            <li class="nav-item">
                <a href="/setoran" class="nav-link {{ request()->is('setoran*') ? 'active' : '' }}">
                    <i class="fas fa-trash-alt"></i> Data Setoran
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
<div class="main-content container-fluid px-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <span class="navbar-text fw-bold">Sistem Bank Sampah Hidayah Geneva</span>
                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none text-dark" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">{{ auth()->user()->name }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout()">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Keluar</button>
                            </form>

                            <script>
                            function confirmLogout() {
                                return confirm('Apakah Anda yakin ingin keluar?');
                            }
                            </script>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>