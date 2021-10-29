<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = [
        'supplier_name',
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
