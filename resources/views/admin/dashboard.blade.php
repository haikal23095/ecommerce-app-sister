<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; border-bottom: 1px solid #343a40; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: white; }
        .card-stat { border: none; border-radius: 10px; color: white; }
        .bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
        .bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
        .bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
        .bg-gradient-danger { background: linear-gradient(45deg, #e74a3b, #be2617); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <h4 class="text-center py-4 border-bottom border-secondary">Admin Panel</h4>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="{{ route('produk.index') }}" class="{{ request()->routeIs('produk.*') ? 'active' : '' }}"><i class="fas fa-box me-2"></i> Produk</a>
            <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart me-2"></i> Transaksi</a>
            
            <div class="mt-5 px-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger w-100">Logout</button>
                </form>
            </div>
        </div>

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Dashboard Overview</h3>
                <span>Halo, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card card-stat bg-gradient-primary h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-uppercase mb-1">Pelanggan</h6><h2>{{ $totalUser }}</h2></div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stat bg-gradient-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-uppercase mb-1">Produk</h6><h2>{{ $totalProduk }}</h2></div>
                            <i class="fas fa-box fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stat bg-gradient-warning h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-uppercase mb-1">Transaksi</h6><h2>{{ $totalTransaksi }}</h2></div>
                            <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stat bg-gradient-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6 class="text-uppercase mb-1">Pendapatan</h6><h3>Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3></div>
                            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerbaru as $trx)
                                <tr>
                                    <td>#{{ $trx->id }}</td>
                                    <td>{{ $trx->user->name ?? 'User Dihapus' }}</td>
                                    <td>{{ $trx->tanggal_transaksi ? $trx->tanggal_transaksi->format('d M Y') : '-' }}</td>
                                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                    <td><span class="badge bg-info">{{ $trx->status ?? 'Pending' }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
