<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $table = 'tasks';

    public $fillable = [
        'key',
        'content',
        'description',
        'email',
        'phone',
        'file',
        'budget_min',
        'budget_max'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(TaskChat::class, 'task_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'task_id');
    }
}
