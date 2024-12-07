<?php

namespace App\Repositories;

use App\Models\TodoList;

class TodoListRepository
{
  public function saveData(array $datas) {
    foreach ($datas as $data) {
      TodoList::updateOrCreate(['name' => $data['name']], $data);
    }
  }
}