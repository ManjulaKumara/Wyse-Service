<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCancellation extends Model
{
    use HasFactory;
    protected $table = 'invoice_cancellation';
    protected $fillable = [
        'invoice_number',
        'invoice_cancel_number',
        'total_amount',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
