<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    use HasFactory;
    protected $table = 'user_role_permissions';
    protected $fillable = [
        'role_id',
        'md_code',
        'md_group',
        'is_enable',
        'can_read',
        'can_create',
        'can_update',
        'can_delete',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}
