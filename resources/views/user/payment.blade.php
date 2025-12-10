<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .payment-option:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .payment-option input {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Selesaikan Pembayaran</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="text-center mb-4">
                        <p class="text-muted mb-1">Total Tagihan</p>
                        <h2 class="fw-bold text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h2>
                        <span class="badge bg-warning text-dark">Order ID: #{{ $transaksi->id }}</span>
                    </div>

                    <hr>

                    <form action="{{ route('payment.process', $transaksi->id) }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-3">Pilih Metode Pembayaran:</h6>

                        <div class="list-group mb-4">
                            
                            <label class="list-group-item d-flex align-items-center justify-content-between payment-option">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="metode_pembayaran" value="bca" required>
                                    <i class="fas fa-university me-2 text-primary"></i> Transfer Bank BCA
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" height="20" alt="BCA">
                            </label>

                            <label class="list-group-item d-flex align-items-center justify-content-between payment-option">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="metode_pembayaran" value="mandiri">
                                    <i class="fas fa-university me-2 text-warning"></i> Transfer Mandiri
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" height="20" alt="Mandiri">
                            </label>

                            <label class="list-group-item d-flex align-items-center justify-content-between payment-option">
                                <div>
                                    <input class="form-check-input me-2" type="radio" name="metode_pembayaran" value="qris">
                                    <i class="fas fa-qrcode me-2 text-dark"></i> QRIS (Gopay/OVO/Dana)
                                </div>
                                <i class="fas fa-qrcode fa-lg"></i>
                            </label>

                        </div>

                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle"></i> Ini adalah simulasi. Klik tombol bayar di bawah untuk mensimulasikan pembayaran sukses.
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                            <i class="fas fa-lock me-2"></i> Bayar Sekarang
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>