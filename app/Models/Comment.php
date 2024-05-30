<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'comment_reply',
    ];

    protected $casts = [
        'id'            => 'integer',
        'post_id'       => 'integer',
        'user_id'       => 'integer',
        'comment'       => 'string',
        'comment_reply' => 'string',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // Relation Start
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
