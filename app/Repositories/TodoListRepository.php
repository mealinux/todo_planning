<?php

namespace App\Repositories;

use App\Models\TodoList;

class TodoListRepository
{
  public function saveData(array $datas) {
    foreach ($datas as $workSheet => $data) {
      foreach ($data as $item) {
        TodoList::updateOrCreate(
          [
            'todo_sheet' => (int)$workSheet,
            'name' => $item['name']
          ],
          $item
        );
      }
    }
  }
}