<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrnDetail extends Model
{
    use HasFactory;
    protected $table = 'grn_details';
    protected $fillable = [
        'item',
        'purchase_qty',
        'purchase_price',
        'discount',
        'cost_price',
        'amount',
        'grn_header',
        'free_issues',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
