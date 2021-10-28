<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnDetail extends Model
{
    use HasFactory;
    protected $table = 'sales_return_details';
    protected $fillable = [
        'return_id',
        'item',
        'stock',
        'qty',
        'unit_price',
        'amount',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
