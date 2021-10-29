<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemConvertion extends Model
{
    use HasFactory;
    protected $table = 'item_convertions';
    protected $fillable = [
        'from_item',
        'to_item',
        'from_qty',
        'to_qty',
        'item_relationship',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
