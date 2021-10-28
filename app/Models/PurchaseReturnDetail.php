<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_return_details';
    protected $fillable = [
        'return_id',
        'item',
        'stock_no',
        'cost_price',
        'qty',
        'amount',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
