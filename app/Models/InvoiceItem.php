<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = 'invoice_items';
    protected $fillable = [
        'invoice',
        'item',
        'qty',
        'discount',
        'amount',
        'stock_no',
        'unit_price',
        'created_at',
        'updated_at',
        'billing_type'
    ];
    public $timestamps = true;
}
