<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    use HasFactory;
    protected $table = 'item_transactions';
    protected $fillable = [
        'stock_id',
        'item',
        'transaction_type',
        'tran_status',
        'qih_before',
        'qih_after',
        'transfer_qty',
        'reference_id',
        'created_at',
        'updated_at',
        'total_qih_before',
        'total_qih_after'
    ];
    public $timestamps = true;
}
