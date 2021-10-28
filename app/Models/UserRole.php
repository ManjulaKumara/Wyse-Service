<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $fillable = [
        'role_code',
        'role_name',
        'is_active',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
