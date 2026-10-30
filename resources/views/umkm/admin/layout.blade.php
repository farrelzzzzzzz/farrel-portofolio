<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - UMKM Kampung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 10px 15px; display: block; border-radius: 5px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: #198754; color: white; }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3 d-none d-md-block">
                <h4 class="fw-bold text-success mb-4 text-center"><i class="fa-solid fa-gauge me-2"></i>Admin UMKM</h4>
                <a href="{{ route('umkm.admin.index') }}" class="{{ request()->routeIs('umkm.admin.index') ? 'active' : '' }}"><i class="fa-solid fa-home me-2"></i> Dashboard</a>
                <a href="{{ route('umkm.admin.products') }}" class="{{ request()->routeIs('umkm.admin.products*') ? 'active' : '' }}"><i class="fa-solid fa-box me-2"></i> Produk</a>
                <a href="{{ route('umkm.admin.categories') }}" class="{{ request()->routeIs('umkm.admin.categories*') ? 'active' : '' }}"><i class="fa-solid fa-tags me-2"></i> Kategori</a>
                <a href="{{ route('umkm.admin.orders') }}" class="{{ request()->routeIs('umkm.admin.orders*') ? 'active' : '' }}"><i class="fa-solid fa-shopping-cart me-2"></i> Pesanan</a>
                <a href="{{ route('umkm.admin.settings') }}" class="{{ request()->routeIs('umkm.admin.settings*') ? 'active' : '' }}"><i class="fa-solid fa-gear me-2"></i> Pengaturan Toko</a>
                <hr class="border-secondary">
                <a href="{{ route('umkm.index') }}" target="_blank" class="text-warning"><i class="fa-solid fa-external-link me-2"></i> Lihat Website Utama</a>
            </div>

            <!-- Content -->
            <div class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
