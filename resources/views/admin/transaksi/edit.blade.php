<!DOCTYPE html>
<html lang="id">
<head>
    <title>Update Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 col-md-6">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Update Status Transaksi #{{ $transaksi->id }}</h4>
        </div>
        <div class="card-body">
            
            <div class="mb-3">
                <label class="fw-bold">Pembeli:</label>
                <p>{{ $transaksi->user->name ?? 'Unknown' }} ({{ $transaksi->user->email ?? '-' }})</p>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold">Total Belanja:</label>
                <p>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            </div>

            <hr>

            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="form-label fw-bold">Ubah Status Pesanan</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                        <option value="dibayar" {{ $transaksi->status == 'dibayar' ? 'selected' : '' }}>Dibayar (Siap Kirim)</option>
                        <option value="dikirim" {{ $transaksi->status == 'dikirim' ? 'selected' : '' }}>Dikirim (Sedang di Jalan)</option>
                        <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai (Diterima)</option>
                        <option value="batal" {{ $transaksi->status == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>