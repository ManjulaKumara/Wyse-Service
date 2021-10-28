<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    use HasFactory;
    protected $table = 'service_master';
    protected $fillable = [
        'service_name',
        'service_description',
        'service_rate',
        'discount_rate',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
