<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRelationship extends Model
{
    use HasFactory;
    protected $table = 'item_relationship';
    protected $fillable = [
        'parent_item',
        'child_item',
        'units_per_parent',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
