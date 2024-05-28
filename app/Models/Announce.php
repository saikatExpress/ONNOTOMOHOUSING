<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announce extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'announce_date',
        'created_by',
        'updated_by',
        'status',
        'flag',
    ];

    protected $casts = [
        'id',
        'title',
        'description',
        'announce_date',
        'created_by',
        'updated_by',
        'status',
        'flag',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    //Relation Start
    public function creator()
    {
        return  $this->belongsTo(User::class, 'created_by', 'id');
    }
}
