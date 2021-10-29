<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierVoucherDetail extends Model
{
    use HasFactory;
    protected $table = 'supplier_voucher_details';
    protected $fillable = [
        'voucher_id',
        'grn',
        'balance_before',
        'pay_amount',
        'balance_after',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
