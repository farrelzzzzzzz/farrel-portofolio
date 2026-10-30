@extends('umkm.admin.layout')

@section('admin-content')
<h2 class="fw-bold mb-4">Kelola Kategori Produk</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white fw-bold">Tambah Kategori Baru</div>
            <div class="card-body">
                <form action="{{ route('umkm.admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Makanan & Snack">
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold">Tambah Kategori</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Daftar Kategori</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Slug URL</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="fw-bold">{{ $cat->name }}</td>
                            <td class="text-muted small">{{ $cat->slug }}</td>
                            <td class="text-end">
                                <form action="{{ route('umkm.admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">Belum ada kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
