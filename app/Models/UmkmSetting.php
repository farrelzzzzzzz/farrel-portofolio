<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmSetting extends Model
{
    protected $table = 'umkm_settings';
    protected $fillable = ['key', 'value'];

    public static function getVal($key, $default = null)
    {
        $item = self::where('key', $key)->first();
        return $item ? $item->value : $default;
    }

    public static function setVal($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
