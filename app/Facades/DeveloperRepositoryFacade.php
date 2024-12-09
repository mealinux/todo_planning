<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DeveloperRepositoryFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'developerRepository';
  }
}