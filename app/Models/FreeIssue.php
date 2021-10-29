<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeIssue extends Model
{
    use HasFactory;
    protected $table = 'free_issues';
    protected $fillable = [
        'grn',
        'item',
        'qty',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
