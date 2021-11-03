<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $fillable = [
        'md_code',
        'md_name',
        'md_group',
        'url',
        'is_active',
        'can_read',
        'can_create',
        'can_update',
        'can_delete',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
