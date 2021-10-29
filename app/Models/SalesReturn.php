<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;
    protected $table = 'sales_returns';
    protected $fillable = [
        'return_number',
        'return_amount',
        'invoice_no',
        'cashier',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
