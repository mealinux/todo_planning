<?php

namespace App\Repositories;

use App\Models\Tasks;

class TaskRepository
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