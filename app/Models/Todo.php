<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todo';

    protected $fillable = [
        'title',
        'details',
        'assignee_id',
        'creator_id',
        'task_status',
    ];

    public function assignee()
    {
        return $this->hasOne(User::class, 'id', 'assignee_id');
    }
}
