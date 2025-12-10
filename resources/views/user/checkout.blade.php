<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Checkout Pesanan</h2>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">Alamat Pengiriman</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Nama Penerima</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat_pengiriman" class="form-control" rows="3" placeholder="Jl. Contoh No. 123, Kota..." required></textarea>
                            <small class="text-muted">Pastikan alamat lengkap agar pengiriman lancar.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Ringkasan Pesanan</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $item->produk->nama_produk }}</h6>
                                    <small class="text-muted">{{ $item->jumlah }} x Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                </div>
                                <span class="text-muted">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between fw-bold text-success">
                                <span>Total Bayar (IDR)</span>
                                <span>Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </li>
                        </ul>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                            Buat Pesanan Sekarang
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Keranjang</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>