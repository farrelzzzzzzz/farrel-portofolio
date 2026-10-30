@extends('umkm.admin.layout')

@section('admin-content')
<h2 class="fw-bold mb-4">Dashboard Pengelola UMKM</h2>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white shadow-sm border-0">
            <div class="card-body">
                <h5>Total Produk</h5>
                <h2 class="fw-bold">{{ $productCount }}</h2>
                <a href="{{ route('umkm.admin.products') }}" class="text-white small text-decoration-none">Kelola Produk &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body">
                <h5>Total Pesanan Masuk</h5>
                <h2 class="fw-bold">{{ $orderCount }}</h2>
                <a href="{{ route('umkm.admin.orders') }}" class="text-white small text-decoration-none">Lihat Pesanan &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-dark text-white shadow-sm border-0">
            <div class="card-body">
                <h5>Estimasi Omset Selesai</h5>
                <h2 class="fw-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</h2>
                <span class="small text-secondary">Dari pesanan berstatus selesai</span>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i> 5 Pesanan Terbaru</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>No WA</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $ord)
                    <tr>
                        <td class="fw-bold text-success">{{ $ord->invoice_number }}</td>
                        <td>{{ $ord->customer_name }}</td>
                        <td>{{ $ord->customer_phone }}</td>
                        <td>Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $ord->status == 'completed' ? 'success' : ($ord->status == 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($ord->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
