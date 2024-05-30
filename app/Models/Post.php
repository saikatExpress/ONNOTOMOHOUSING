<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'post_link',
        'image',
        'video',
        'created_by',
        'updated_by',
        'status',
        'flag',
    ];

    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'content'    => 'string',
        'post_link'  => 'string',
        'image'      => 'string',
        'video'      => 'string',
        'created_by' => 'string',
        'updated_by' => 'string',
        'status'     => 'string',
        'flag'       => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //Relation Start
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
