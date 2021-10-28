<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $table = 'purchase_returns';
    protected $fillable = [
        'supplier',
        'return_no',
        'grn',
        'return_amount',
        'cashier',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
