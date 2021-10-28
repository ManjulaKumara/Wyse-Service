<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCheque extends Model
{
    use HasFactory;
    protected $table = 'customer_cheques';
    protected $fillable = [
        'receipt_id',
        'customer',
        'cheque_number',
        'bank_name',
        'banked_date',
        'cheque_amount',
        'is_returned',
        'cashier',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
