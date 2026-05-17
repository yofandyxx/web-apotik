<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Toko Obat Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #343a40;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--primary) !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary), #2980b9);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }

        .btn-success {
            background: linear-gradient(45deg, var(--secondary), #27ae60);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }

        .sidebar {
            background: linear-gradient(180deg, #2c3e50, #34495e);
            min-height: 100vh;
            color: white;
        }

        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .stat-card.primary {
            background: linear-gradient(45deg, var(--primary), #2980b9);
        }

        .stat-card.success {
            background: linear-gradient(45deg, var(--secondary), #27ae60);
        }

        .stat-card.warning {
            background: linear-gradient(45deg, var(--warning), #e67e22);
        }

        .stat-card.danger {
            background: linear-gradient(45deg, var(--danger), #c0392b);
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    @auth
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-clinic-medical"></i> Toko Obat
                    </h4>
                    <ul class="nav flex-column">
                        @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                <i class="fas fa-tags"></i> Kategori Obat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}" href="{{ route('obat.index') }}">
                                <i class="fas fa-pills"></i> Data Obat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                                <i class="fas fa-history"></i> Riwayat Transaksi
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kasir.transaksi') ? 'active' : '' }}" href="{{ route('kasir.transaksi') }}">
                                <i class="fas fa-cash-register"></i> Kasir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                                <i class="fas fa-history"></i> Riwayat Transaksi
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 mb-4">
                    <h1 class="h2 text-white">@yield('title')</h1>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @else
    @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @stack('scripts')
</body>

</html>