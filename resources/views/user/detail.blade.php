<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - Toko Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">TOKO SAYA</a>
            <div class="ms-auto text-white">
                <a href="/" class="btn btn-outline-light btn-sm">Kembali ke Home</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row">
                    
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="border rounded p-2 text-center bg-white">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid rounded" alt="{{ $produk->nama_produk }}" style="max-height: 400px;">
                            @else
                                <img src="https://via.placeholder.com/400x400?text=No+Image" class="img-fluid rounded" alt="No Image">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-7">
                        <h2 class="fw-bold">{{ $produk->nama_produk }}</h2>
                        <h3 class="text-primary fw-bold my-3">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </h3>

                        <div class="mb-3">
                            @if($produk->stok > 0)
                                <span class="badge bg-success">Stok Tersedia: {{ $produk->stok }}</span>
                            @else
                                <span class="badge bg-danger">Stok Habis</span>
                            @endif
                        </div>

                        <p class="text-muted" style="white-space: pre-line;">
                            {{ $produk->deskripsi }}
                        </p>

                        <hr>

                        <div class="d-flex align-items-end mt-4">
                            @if($produk->stok > 0)
                                <form action="{{ route('cart.add', $produk->id) }}" method="POST" class="d-flex w-100">
                                    @csrf
                                    
                                    <div class="me-3 col-3">
                                        <label class="form-label fw-bold">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $produk->stok }}">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                        <i class="fas fa-cart-plus me-2"></i> Masukkan Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>