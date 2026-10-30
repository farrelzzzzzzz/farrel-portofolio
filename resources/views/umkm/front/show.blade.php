<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('umkm.index') }}">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Katalog
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row bg-white p-4 rounded shadow-sm align-items-center">
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/500x400?text=Produk' }}" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;" alt="{{ $product->name }}">
            </div>
            <div class="col-md-7">
                <span class="badge bg-success mb-2">{{ $product->category->name ?? 'Umum' }}</span>
                <h1 class="fw-bold text-dark mb-3">{{ $product->name }}</h1>
                <h3 class="text-success fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                <p class="text-muted mb-4">{{ $product->description ?: 'Tidak ada deskripsi tambahan.' }}</p>
                <p class="mb-4"><strong>Stok Tersedia:</strong> <span class="badge bg-secondary">{{ $product->stock }} unit</span></p>

                <form action="{{ route('umkm.checkout') }}" method="POST" class="p-3 bg-light rounded border">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <h5 class="fw-bold mb-3 text-success"><i class="fa-brands fa-whatsapp me-2"></i> Form Pesan via WhatsApp</h5>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap Pembeli</label>
                        <input type="text" name="customer_name" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor WhatsApp / HP</label>
                        <input type="text" name="customer_phone" class="form-control" required placeholder="Contoh: 08123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Pesanan</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ max(1, $product->stock) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Pengiriman / Catatan</label>
                        <textarea name="shipping_address" class="form-control" rows="2" required placeholder="Contoh: RT 02/05 Desa Makmur"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow">
                        <i class="fa-brands fa-whatsapp me-2"></i> Kirim Pesanan ke WhatsApp Penjual
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
