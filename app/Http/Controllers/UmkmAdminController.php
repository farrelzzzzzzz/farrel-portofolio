<?php

namespace App\Http\Controllers;

use App\Models\UmkmCategory;
use App\Models\UmkmProduct;
use App\Models\UmkmOrder;
use App\Models\UmkmSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmAdminController extends Controller
{
    public function index()
    {
        $productCount = UmkmProduct::count();
        $orderCount = UmkmOrder::count();
        $revenue = UmkmOrder::where('status', 'completed')->sum('total_amount');
        $orders = UmkmOrder::latest()->take(5)->get();

        return view('umkm.admin.dashboard', compact('productCount', 'orderCount', 'revenue', 'orders'));
    }

    public function dashboard()
    {
        $productCount = UmkmProduct::count();
        $orderCount = UmkmOrder::count();
        $revenue = UmkmOrder::where('status', 'completed')->sum('total_amount');
        $orders = UmkmOrder::latest()->take(5)->get();

        return view('umkm.admin.dashboard', compact('productCount', 'orderCount', 'revenue', 'orders'));
    }

    public function products()
    {
        $products = UmkmProduct::with('category')->latest()->get();
        $categories = UmkmCategory::all();
        return view('umkm.admin.products', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:umkm_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/umkm'), $filename);
            $imagePath = 'uploads/umkm/' . $filename;
        }

        UmkmProduct::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(4),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function deleteProduct($id)
    {
        $product = UmkmProduct::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    public function categories()
    {
        $categories = UmkmCategory::all();
        return view('umkm.admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:umkm_categories,name']);
        UmkmCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function deleteCategory($id)
    {
        UmkmCategory::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function orders()
    {
        $orders = UmkmOrder::with('items.product')->latest()->get();
        return view('umkm.admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = UmkmOrder::findOrFail($id);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }

    public function settings()
    {
        $settings = UmkmSetting::pluck('value', 'key')->toArray();
        return view('umkm.admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            UmkmSetting::setVal($key, $value);
        }
        return redirect()->back()->with('success', 'Pengaturan toko berhasil disimpan!');
    }
}
