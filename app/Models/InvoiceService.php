<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceService extends Model
{
    use HasFactory;
    protected $table = 'invoice_service';
    protected $fillable = [
        'invoice',
        'service',
        'qty',
        'unit_price',
        'discount',
        'amount',
        'created_at',
        'updated_at',
        'billing_type'
    ];
    public $timestamps = true;
}
