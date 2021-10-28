<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    use HasFactory;
    protected $table = 'item_stocks';
    protected $fillable = [
        'item',
        'purchase_qty',
        'qty_in_hand',
        'cost_price',
        'grn',
        'sales_price',
        'sales_rate',
        'stock_type',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
