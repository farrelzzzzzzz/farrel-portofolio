@extends('umkm.admin.layout')

@section('admin-content')
<h2 class="fw-bold mb-4">Pengaturan Profil UMKM Kampung</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white fw-bold">Informasi Toko / UMKM</div>
            <div class="card-body">
                <form action="{{ route('umkm.admin.settings.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama UMKM / Toko</label>
                        <input type="text" name="store_name" class="form-control" value="{{ $settings['store_name'] ?? 'UMKM Kampung Berkah' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Slogan Singkat</label>
                        <input type="text" name="store_tagline" class="form-control" value="{{ $settings['store_tagline'] ?? 'Produk Lokal Berkualitas, Asli Buatan Kampung Sendiri' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nomor WhatsApp Resmi (Format: 628xxxx tanpa + atau 0)</label>
                        <input type="text" name="store_phone" class="form-control" value="{{ $settings['store_phone'] ?? '6281234567890' }}" required>
                        <div class="form-text">Contoh: 6281234567890 (pesanan dari pembeli akan otomatis dikirim ke nomor WhatsApp ini).</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat Lengkap / Lokasi Kampung</label>
                        <textarea name="store_address" class="form-control" rows="3" required>{{ $settings['store_address'] ?? 'Jl. Raya Desa Makmur RT 01/02, Kec. Sejahtera' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold px-4">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
