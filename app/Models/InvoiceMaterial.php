<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceMaterial extends Model
{
    use HasFactory;
    protected $table = 'invoice_materials';
    protected $fillable = [
        'invoice',
        'item',
        'qty',
        'unit_price',
        'amount',
        'created_at',
        'updated_at',
        'billing_type'
    ];
    public $timestamps = true;
}
