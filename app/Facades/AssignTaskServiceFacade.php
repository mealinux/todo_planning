<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AssignTaskServiceFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'assignTaskService';
  }
}