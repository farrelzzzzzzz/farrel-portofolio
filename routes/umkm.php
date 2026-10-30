<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmFrontController;
use App\Http\Controllers\UmkmAdminController;

// Web Utama UMKM (Publik)
Route::prefix('umkm')->group(function () {
    Route::get('/', [UmkmFrontController::class, 'index'])->name('umkm.index');
    Route::get('/product/{id}', [UmkmFrontController::class, 'show'])->name('umkm.show');
    Route::post('/order', [UmkmFrontController::class, 'storeOrder'])->name('umkm.order');
});

// Panel Admin UMKM (Terpisah URL-nya)
Route::prefix('admin-umkm')->group(function () {
    Route::get('/', [UmkmAdminController::class, 'index'])->name('umkm.admin.index');
    Route::get('/dashboard', [UmkmAdminController::class, 'index'])->name('umkm.admin.dashboard');
    
    Route::get('/products', [UmkmAdminController::class, 'products'])->name('umkm.admin.products');
    Route::post('/products', [UmkmAdminController::class, 'storeProduct'])->name('umkm.admin.products.store');
    Route::post('/products/{id}/delete', [UmkmAdminController::class, 'destroyProduct'])->name('umkm.admin.products.delete');
    Route::delete('/products/{id}', [UmkmAdminController::class, 'destroyProduct'])->name('umkm.admin.products.destroy');
    
    Route::get('/categories', [UmkmAdminController::class, 'categories'])->name('umkm.admin.categories');
    Route::post('/categories', [UmkmAdminController::class, 'storeCategory'])->name('umkm.admin.categories.store');
    Route::post('/categories/{id}/delete', [UmkmAdminController::class, 'destroyCategory'])->name('umkm.admin.categories.delete');
    Route::delete('/categories/{id}', [UmkmAdminController::class, 'destroyCategory'])->name('umkm.admin.categories.destroy');
    
    Route::get('/orders', [UmkmAdminController::class, 'orders'])->name('umkm.admin.orders');
    Route::post('/orders/{id}/status', [UmkmAdminController::class, 'updateOrderStatus'])->name('umkm.admin.orders.status');
    
    Route::get('/settings', [UmkmAdminController::class, 'settings'])->name('umkm.admin.settings');
    Route::post('/settings', [UmkmAdminController::class, 'storeSettings'])->name('umkm.admin.settings.store');
    Route::post('/settings/update', [UmkmAdminController::class, 'updateSettings'])->name('umkm.admin.settings.update');
});
