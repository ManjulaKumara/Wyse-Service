<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRecept extends Model
{
    use HasFactory;
    protected $table = 'customer_recepts';
    protected $fillable = [
        'recept_no',
        'customer',
        'recept_amount',
        'payment_type',
        'cashier',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}
