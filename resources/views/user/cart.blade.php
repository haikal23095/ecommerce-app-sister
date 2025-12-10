<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">TOKO SAYA</a>
            <a href="/" class="btn btn-outline-light btn-sm">Lanjut Belanja</a>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-4"><i class="fas fa-shopping-cart"></i> Keranjang Belanja Anda</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        @if($cartItems->count() > 0)
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th style="width: 15%;">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->produk->gambar)
                                                <img src="{{ asset('storage/' . $item->produk->gambar) }}" width="50" class="rounded me-2">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->produk->nama_produk }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" class="form-control form-control-sm text-center" min="1" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold text-primary">
                                        Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.delete', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm text-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="text-center py-5">
                                <img src="https://via.placeholder.com/100x100?text=Empty" class="mb-3 opacity-50">
                                <p class="text-muted">Keranjang masih kosong.</p>
                                <a href="/" class="btn btn-primary">Mulai Belanja</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">Ringkasan Belanja</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item</span>
                            <span>{{ $cartItems->count() }} Barang</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total Harga</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-success ...">
                            Checkout Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>