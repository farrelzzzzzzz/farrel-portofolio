@extends('umkm.admin.layout')

@section('admin-content')
<h2 class="fw-bold mb-4">Daftar Pesanan Masuk</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No Invoice</th>
                        <th>Pembeli</th>
                        <th>Detail Produk</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <td class="fw-bold text-success">{{ $o->invoice_number }}</td>
                        <td>
                            <strong>{{ $o->customer_name }}</strong><br>
                            <small class="text-muted"><i class="fa-brands fa-whatsapp text-success"></i> {{ $o->customer_phone }}</small><br>
                            <small class="text-secondary">{{ $o->shipping_address }}</small>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @foreach($o->items as $item)
                                <li>{{ $item->product->name ?? 'Produk Dihapus' }} (<strong>{{ $item->quantity }}x</strong>)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($o->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $o->status == 'completed' ? 'success' : ($o->status == 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($o->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('umkm.admin.orders.status', $o->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="pending" {{ $o->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processed" {{ $o->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                                    <option value="completed" {{ $o->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $o->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
