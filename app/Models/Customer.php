<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'customer_name',
        'address',
        'telephone',
        'email',
        'mobile',
        'credit_limit',
        'open_balance',
        'current_balance',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
