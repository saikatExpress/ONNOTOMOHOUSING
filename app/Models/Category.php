<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'cost_head',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'id'         => 'integer',
        'name'       => 'string',
        'slug'       => 'string',
        'cost_head'  => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'status'     => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
