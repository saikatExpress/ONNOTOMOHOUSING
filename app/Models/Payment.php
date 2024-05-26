<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'bank_slip',
        'status',
        'is_pending',
        'is_cancel',
        'is_approve',
        'flag',
        'approve_by',
        'cancel_by',
    ];

    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'amount'     => 'integer',
        'bank_slip'  => 'string',
        'status'     => 'string',
        'is_pending' => 'integer',
        'is_cancel'  => 'integer',
        'is_approve' => 'integer',
        'flag'       => 'integer',
        'approve_by' => 'integer',
        'cancel_by'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relation Start
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
