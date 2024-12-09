<?php

namespace App\Http\Controllers;

use App\Facades\AssignTaskServiceFacade;
use App\Services\AssignTaskService;

class TodoListController extends Controller
{
    const WEEKLY_HOUR = 45;

    public function __invoke()
    {
       $assignedTasks = AssignTaskServiceFacade::showTaskSheet();

       return view('index', compact('assignedTasks'));
    }
}