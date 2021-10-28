<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReceptDetail extends Model
{
    use HasFactory;
    protected $table = 'customer_recept_details';
    protected $fillable = [
        'invoice',
        'balance_before',
        'pay_amount',
        'balance_after',
        'recept_id',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
