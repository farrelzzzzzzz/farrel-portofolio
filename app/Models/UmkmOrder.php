<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmOrder extends Model
{
    protected $table = 'umkm_orders';
    protected $fillable = ['invoice_number', 'customer_name', 'customer_phone', 'shipping_address', 'total_amount', 'status', 'notes'];

    public function items()
    {
        return $this->hasMany(UmkmOrderItem::class, 'order_id');
    }
}
