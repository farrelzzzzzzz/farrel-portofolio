<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $storeName }} - Website Resmi UMKM Kampung</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        .product-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('umkm.index') }}">
                <i class="fa-solid fa-store me-2"></i>{{ $storeName }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('umkm.index') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#katalog">Katalog Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak & Lokasi</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-warning text-dark fw-bold px-3" href="{{ route('umkm.admin.index') }}" target="_blank">
                            <i class="fa-solid fa-gauge me-1"></i> Panel Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">{{ $storeName }}</h1>
            <p class="lead fs-4 mb-4">{{ $storeTagline }}</p>
            <a href="#katalog" class="btn btn-success btn-lg px-4 fw-bold shadow">
                <i class="fa-solid fa-bag-shopping me-2"></i> Belanja Sekarang
            </a>
        </div>
    </header>

    <!-- Featured Products -->
    @if(count($featured) > 0)
    <div class="container my-5">
        <h3 class="fw-bold mb-4 text-success border-bottom pb-2"><i class="fa-solid fa-star me-2 text-warning"></i> Produk Unggulan</h3>
        <div class="row">
            @foreach($featured as $item)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <img src="{{ $item->image ? asset($item->image) : 'https://via.placeholder.com/400x300?text=Produk+UMKM' }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $item->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $item->name }}</h5>
                        <p class="text-success fw-bold fs-5 mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($item->description, 60) }}</p>
                        <a href="{{ route('umkm.show', $item->id) }}" class="btn btn-outline-success w-100 mt-2">
                            <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Catalog & Filter -->
    <section id="katalog" class="container my-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark"><i class="fa-solid fa-boxes-stacked me-2 text-success"></i> Katalog Semua Produk</h2>
            </div>
            <div class="col-md-6">
                <form action="{{ route('umkm.index') }}" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk kampung..." value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Categories -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="fa-solid fa-filter me-2"></i> Kategori Produk
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('umkm.index') }}" class="list-group-item list-group-item-action {{ request('category') == '' ? 'active bg-success text-white' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('umkm.index', ['category' => $cat->id]) }}" class="list-group-item list-group-item-action {{ request('category') == $cat->id ? 'active bg-success text-white' : '' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-md-9">
                @if(count($products) > 0)
                <div class="row">
                    @foreach($products as $prod)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100">
                            <img src="{{ $prod->image ? asset($prod->image) : 'https://via.placeholder.com/400x300?text=Produk+UMKM' }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $prod->name }}">
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-light text-success border border-success align-self-start mb-2 small">{{ $prod->category->name ?? 'Umum' }}</span>
                                <h5 class="card-title fw-bold text-dark">{{ $prod->name }}</h5>
                                <p class="text-success fw-bold mb-2">Rp {{ number_format($prod->price, 0, ',', '.') }}</p>
                                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($prod->description, 50) }}</p>
                                <a href="{{ route('umkm.show', $prod->id) }}" class="btn btn-success w-100 shadow-sm">
                                    <i class="fa-brands fa-whatsapp me-1"></i> Pesan / Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-warning text-center py-5">
                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-3 text-warning"></i>
                    <h4>Belum ada produk tersedia.</h4>
                    <p class="text-muted">Silakan tambah produk melalui Panel Admin.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Contact & Location Footer -->
    <footer id="kontak" class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-store me-2"></i>{{ $storeName }}</h5>
                    <p class="text-secondary small">Mendukung perekonomian warga kampung dengan menghadirkan produk-produk unggulan lokal asli buatan tangan warga sekitar secara online.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Kontak Resmi</h5>
                    <p class="text-secondary mb-2"><i class="fa-solid fa-phone me-2 text-success"></i> +{{ $storePhone }}</p>
                    <p class="text-secondary mb-2"><i class="fa-solid fa-location-dot me-2 text-success"></i> {{ $storeAddress }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Akses Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('umkm.admin.index') }}" class="text-decoration-none text-secondary" target="_blank"><i class="fa-solid fa-lock me-1"></i> Login Panel Admin UMKM</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-secondary small">
                &copy; 2026 {{ $storeName }}. 100% Siap Hosting Gratis & Mandiri untuk UMKM Kampung.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
