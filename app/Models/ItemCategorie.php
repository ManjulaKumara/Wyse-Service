<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategorie extends Model
{
    use HasFactory;
    protected $table = 'item_categories';
    protected $fillable = [
        'category_name',
        'category_code',
        'remarks',
        'is_active',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
