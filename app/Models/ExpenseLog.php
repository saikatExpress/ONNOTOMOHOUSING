<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cost_head',
        'expense_id',
        'expense_date',
        'cost_amount',
        'remark',
    ];

    protected $casts = [
        'id'           => 'integer',
        'user_id'      => 'integer',
        'cost_head'    => 'integer',
        'expense_id'   => 'integer',
        'expense_date' => 'datetime',
        'cost_amount'  => 'integer',
        'remark'       => 'string',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    //Relation Start
    public function categories()
    {
        return $this->belongsTo(Category::class, 'cost_head', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::class, 'expense_id', 'id');
    }
}
