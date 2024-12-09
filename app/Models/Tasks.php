<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['task_sheet', 'name', 'value', 'estimated_duration'];

    public function scopeOrderByTotalWorkLoad($query)
    {
        return $query->select('name', 'task_sheet')
                     ->selectRaw('value * estimated_duration as total_work_load')
                     ->orderByDesc('total_work_load');
    }
}
