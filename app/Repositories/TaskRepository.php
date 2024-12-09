<?php

namespace App\Repositories;

use App\Models\Tasks;
use Illuminate\Support\Facades\Facade;

class TaskRepository extends Facade
{
  public function getTasks(){
    return Tasks::orderByTotalWorkLoad()->get();
  }

  public function saveData(array $datas) {
    foreach ($datas as $workSheet => $data) {
      foreach ($data as $item) {
        Tasks::updateOrCreate(
          [
            'task_sheet' => (int)$workSheet,
            'name' => $item['name']
          ],
          $item
        );
      }
    }
  }
}