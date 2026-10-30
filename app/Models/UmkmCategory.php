<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmCategory extends Model
{
    protected $table = 'umkm_categories';
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(UmkmProduct::class, 'category_id');
    }
}
