@extends('umkm.admin.layout')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kelola Produk UMKM</h2>
    <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Produk Baru
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Unggulan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>
                            <img src="{{ $p->image ? asset($p->image) : 'https://via.placeholder.com/50' }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                        </td>
                        <td class="fw-bold">{{ $p->name }}</td>
                        <td><span class="badge bg-secondary">{{ $p->category->name ?? '-' }}</span></td>
                        <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>
                            @if($p->is_featured)
                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-star"></i> Ya</span>
                            @else
                            <span class="badge bg-light text-muted">Tidak</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('umkm.admin.products.delete', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada produk. Silakan tambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('umkm.admin.products.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-plus me-2"></i> Tambah Produk Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Produk</label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Keripik Singkong Balado">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" required placeholder="15000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Stok</label>
                        <input type="number" name="stock" class="form-control" required value="10">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Deskripsi Produk</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan keunggulan produk..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Foto Produk</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="featuredCheck">
                    <label class="form-check-label small fw-bold" for="featuredCheck">Jadikan Produk Unggulan di Beranda</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success fw-bold">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
