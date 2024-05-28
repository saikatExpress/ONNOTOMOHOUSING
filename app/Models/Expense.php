<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cost_head',
        'cost_amount',
        'cost_date',
        'remark',
        'created_by',
        'updated_by',
        'status',
        'flag',
    ];

    protected $casts = [
        'id'          => 'integer',
        'user_id'     => 'integer',
        'cost_head'   => 'integer',
        'cost_amount' => 'integer',
        'cost_date'   => 'datetime',
        'remark'      => 'string',
        'created_by'  => 'integer',
        'updated_by'  => 'integer',
        'status'      => 'string',
        'flag'        => 'integer',
        'deleted_at'  => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // Relation Start
    public function categories()
    {
        return $this->belongsTo(Category::class, 'cost_head', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
