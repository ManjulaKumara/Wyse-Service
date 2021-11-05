<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssue extends Model
{
    use HasFactory;
    protected $table = 'material_issues';
    protected $fillable = [
        'issue_no',
        'item',
        'quantity',
        'stock_no',
        'created_at',
        'updated_at',
        'return_qty',
    ];
    public $timestamps = true;
}
