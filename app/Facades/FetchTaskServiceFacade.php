<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FetchTaskServiceFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'fetchTaskService';
  }
}