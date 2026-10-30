<?php

namespace App\Http\Controllers;

use App\Models\UmkmCategory;
use App\Models\UmkmProduct;
use App\Models\UmkmOrder;
use App\Models\UmkmOrderItem;
use App\Models\UmkmSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmFrontController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProduct::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();
        $categories = UmkmCategory::all();
        $featured = UmkmProduct::where('is_featured', true)->take(4)->get();

        $storeName = UmkmSetting::getVal('store_name', 'UMKM Kampung Berkah');
        $storeTagline = UmkmSetting::getVal('store_tagline', 'Produk Lokal Berkualitas, Asli Buatan Kampung Sendiri');
        $storePhone = UmkmSetting::getVal('store_phone', '6281234567890');
        $storeAddress = UmkmSetting::getVal('store_address', 'Jl. Raya Desa Makmur RT 01/02, Kec. Sejahtera');

        return view('umkm.front.index', compact('products', 'categories', 'featured', 'storeName', 'storeTagline', 'storePhone', 'storeAddress'));
    }

    public function show($id)
    {
        $product = UmkmProduct::findOrFail($id);
        $storePhone = UmkmSetting::getVal('store_phone', '6281234567890');
        return view('umkm.front.show', compact('product', 'storePhone'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'product_id' => 'required|exists:umkm_products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = UmkmProduct::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;
        $invoice = 'INV-' . strtoupper(Str::random(6));

        $order = UmkmOrder::create([
            'invoice_number' => $invoice,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $total,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        UmkmOrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);

        $storePhone = UmkmSetting::getVal('store_phone', '6281234567890');
        $waText = "Halo Kak, saya ingin memesan produk dari " . UmkmSetting::getVal('store_name', 'UMKM Kampung Mandiri') . ".%0a%0a*No. Invoice:* {$invoice}%0a*Nama Pembeli:* {$request->customer_name}%0a*Produk:* {$product->name} ({$request->quantity}x)%0a*Total Pembayaran:* Rp " . number_format($total, 0, ',', '.') . "%0a*Alamat Pengiriman:* {$request->shipping_address}%0a%0aMohon konfirmasi ketersediaan dan instruksi pembayarannya. Terima kasih!";
        $waUrl = "https://wa.me/{$storePhone}?text={$waText}";

        return redirect($waUrl);
    }
}
