<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmkmCategory;
use App\Models\UmkmProduct;
use App\Models\UmkmSetting;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        // Settings Default
        UmkmSetting::setVal('store_name', 'UMKM Kampung Mandiri');
        UmkmSetting::setVal('store_tagline', 'Produk Unggulan Asli Warga Desa & Kampung Kita');
        UmkmSetting::setVal('store_phone', '6281234567890');
        UmkmSetting::setVal('store_address', 'Jl. Desa Sejahtera RT 02 / RW 01, Kec. Makmur');

        // Categories
        $cat1 = UmkmCategory::create(['name' => 'Makanan & Snack', 'slug' => 'makanan-snack']);
        $cat2 = UmkmCategory::create(['name' => 'Kerajinan Tangan', 'slug' => 'kerajinan-tangan']);
        $cat3 = UmkmCategory::create(['name' => 'Hasil Tani & Kebun', 'slug' => 'hasil-tani-kebun']);

        // Products
        UmkmProduct::create([
            'category_id' => $cat1->id,
            'name' => 'Keripik Singkong Balado Kampung',
            'slug' => 'keripik-singkong-balado-kampung',
            'description' => 'Keripik singkong renyah buatan ibu-ibu PKK desa dengan bumbu balado asli cabai segar.',
            'price' => 15000,
            'stock' => 50,
            'is_featured' => true,
        ]);

        UmkmProduct::create([
            'category_id' => $cat2->id,
            'name' => 'Tas Anyaman Bambu Alami',
            'slug' => 'tas-anyaman-bambu-alami',
            'description' => 'Tas kerajinan tangan dari bambu pilihan, kuat, estetik, dan ramah lingkungan.',
            'price' => 65000,
            'stock' => 15,
            'is_featured' => true,
        ]);

        UmkmProduct::create([
            'category_id' => $cat3->id,
            'name' => 'Madu Hutan Asli Murni',
            'slug' => 'madu-hutan-asli-murni',
            'description' => 'Madu murni hasil panen lebah liar dari hutan sekitar kampung, dijamin keasliannya.',
            'price' => 120000,
            'stock' => 20,
            'is_featured' => true,
        ]);
    }
}
