<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDamage extends Model
{
    use HasFactory;
    protected $table = 'item_damages';
    protected $fillable = [
        'item',
        'stock_no',
        'qty',
        'remarks',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
