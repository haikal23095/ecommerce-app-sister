<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Transaksi</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $trx)
                            <tr>
                                <td>#{{ $trx->id }}</td>
                                <td>{{ $trx->user->name ?? 'User Dihapus' }}</td>
                                <td>{{ $trx->tanggal_transaksi ? $trx->tanggal_transaksi->format('d M Y') : '-' }}</td>
                                <td>Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                                <td>{{ $trx->status ?? 'Pending' }}</td>
                                <td>
                                    <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    <a href="{{ route('transaksi.edit', $trx->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!-- Single consolidated transaksi index view (uses $transaksis from controller) -->