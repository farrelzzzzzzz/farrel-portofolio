<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmOrderItem extends Model
{
    protected $table = 'umkm_order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(UmkmProduct::class, 'product_id');
    }
}
