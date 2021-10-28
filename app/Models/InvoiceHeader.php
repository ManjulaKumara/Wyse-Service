<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeader extends Model
{
    use HasFactory;
    protected $table = 'invoice_header';
    protected $fillable = [
        'invoice_number',
        'customer',
        'vehicle_number',
        'remarks',
        'total_amount',
        'discount_amount',
        'net_amount',
        'invoice_type',
        'balance',
        'paid_amount',
        'return_amount',
        'cashier',
        'payment_type',
        'created_at',
        'is_cancel',
        'updated_at'
    ];
    public $timestamps = true;
}
