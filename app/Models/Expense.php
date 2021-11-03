<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable = [
        'expense_name',
        'expense_remark	',
        'expense_amount',
        'cashier',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
