<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;
    protected $table = 'cash_transactions';
    protected $fillable = [
        'transaction_type',
        'reference_id',
        'debit_amount',
        'credit_amount',
        'balance_after',
        'balance_before',
        'created_at',
        'updated_at',
        'transaction_date',
    ];
    public $timestamps = true;
}
