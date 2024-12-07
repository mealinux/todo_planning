<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    protected $fillable = ['todo_sheet', 'name', 'value', 'estimated_duration'];
}
