<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierVoucher extends Model
{
    use HasFactory;
    protected $table = 'supplier_vouchers';
    protected $fillable = [
        'voucher_number',
        'cashier',
        'supplier',
        'total_amount',
        'pay_type',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
