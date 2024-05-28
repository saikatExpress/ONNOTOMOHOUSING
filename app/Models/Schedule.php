<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'holder_id',
        'task_name',
        'schedule_date',
        'remark',
        'created_by',
        'updated_by',
        'is_aasigned',
        'status',
        'flag',
    ];

    protected $casts = [
        'id'            => 'integer',
        'holder_id'     => 'integer',
        'task_name'     => 'string',
        'schedule_date' => 'datetime',
        'remark'        => 'string',
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
        'is_aasigned'   => 'integer',
        'status'        => 'string',
        'flag'          => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    //Relation Start
    public function holders()
    {
        return $this->belongsTo(User::class, 'holder_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
