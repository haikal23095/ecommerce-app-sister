<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Riwayat Pesanan Saya</h3>
    <a href="/" class="btn btn-secondary mb-3">Kembali Belanja</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                    <tr>
                        <td>#{{ $item->id }}</td>
                        <td>{{ $item->created_at ? $item->created_at->format('d M Y') : 'N/A' }}</td>
                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'selesai' ? 'success' : 'primary') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->alamat_pengiriman }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>