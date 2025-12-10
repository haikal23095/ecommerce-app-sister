<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .product-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">TOKO SAYA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex mx-auto my-2 my-lg-0 col-lg-6" action="/" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-2">
                        @auth
                            <a href="{{ route('cart.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i> Keranjang</a>
                        @endauth
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                                Halo, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->peran == 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('transaksi.index_user') }}">Riwayat Pesanan</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-primary ms-2">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(!request('search'))
    <div class="bg-light py-5 mb-5 text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Toko Kami</h1>
            <p class="lead text-muted">Temukan produk terbaik dengan harga terjangkau.</p>
        </div>
    </div>
    @else
    <div class="container mt-4">
        <h5>Hasil pencarian untuk: "<strong>{{ request('search') }}</strong>"</h5>
    </div>
    @endif

    <div class="container mb-5">
        <div class="row">
            @forelse($produk as $item)
            <div class="col-md-3 col-6 mb-4">
                <div class="card product-card h-100 border-0 shadow-sm">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top product-img" alt="{{ $item->nama_produk }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top product-img" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate">{{ $item->nama_produk }}</h5>
                        <p class="card-text fw-bold text-primary">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        
                        <p class="small text-muted mb-2">Stok: {{ $item->stok }}</p>

                        <div class="mt-auto">
                            <a href="{{ route('produk.detail', $item->id) }}" class="btn btn-outline-dark w-100 mb-2">Lihat Detail</a>
                            
                            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success w-100" {{ $item->stok < 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus"></i> {{ $item->stok < 1 ? 'Habis' : 'Beli' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">Produk tidak ditemukan 😔</h3>
                <a href="/" class="btn btn-primary mt-3">Lihat Semua Produk</a>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $produk->links() }}
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">&copy; {{ date('Y') }} Toko UMKM. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>