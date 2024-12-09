<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ErrorHandlingServiceFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'errorHandlingService';
  }
}