<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrnHeader extends Model
{
    use HasFactory;
    protected $table = 'grn_header';
    protected $fillable = [
        'date',
        'grn_code',
        'supplier',
        'cashier',
        'amount',
        'balance',
        'return_amount',
        'paid_amount',
        'remarks',
        'created_at',
        'updated_at',
        'receipt_no',
    ];
    public $timestamps = true;
}
