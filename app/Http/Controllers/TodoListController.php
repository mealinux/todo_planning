<?php

namespace App\Http\Controllers;

use App\Services\AssignTaskService;

class TodoListController extends Controller
{
    const WEEKLY_HOUR = 45;

    public function __construct(protected AssignTaskService $taskService)
    {}

    public function __invoke()
    {
       $assignedTasks = $this->taskService->showTaskSheet();

       return view('index', compact('assignedTasks'));
    }
}