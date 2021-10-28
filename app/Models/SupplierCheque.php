<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCheque extends Model
{
    use HasFactory;
    protected $table = 'supplier_cheques';
    protected $fillable = [
        'supplier',
        'cheque_no',
        'account',
        'bank',
        'cheque_date',
        'amount',
        'voucher_id',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
