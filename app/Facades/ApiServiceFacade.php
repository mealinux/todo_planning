<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiServiceFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'apiService';
  }
}