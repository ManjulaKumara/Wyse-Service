<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'item_code',
        'category',
        'item_name',
        'item_description',
        'discount_rate',
        'item_type',
        'remarks',
        'barcode',
        're_order_level',
        'created_at',
        'updated_at',
        'is_active'
    ];
    public $timestamps = true;
}
