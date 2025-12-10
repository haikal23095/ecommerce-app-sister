<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 col-md-8">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Edit Produk</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Gambar Produk</label>
                    <div class="mb-2">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" width="100" class="img-thumbnail">
                        @endif
                    </div>
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update Produk</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>