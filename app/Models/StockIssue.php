<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIssue extends Model
{
    use HasFactory;
    protected $table = 'stock_issue';
    protected $fillable = [
        'vehicle_number',
        'item',
        'qty',
        'stock_no',
        'is_invoiced',
        'created_at',
        'updated_at',
        'invoice',
    ];
    public $timestamps = true;
}
