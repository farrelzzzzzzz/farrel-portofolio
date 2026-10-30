<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmProduct extends Model
{
    protected $table = 'umkm_products';
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_featured'];

    public function category()
    {
        return $this->belongsTo(UmkmCategory::class, 'category_id');
    }
}
