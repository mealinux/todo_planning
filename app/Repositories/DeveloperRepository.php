<?php

namespace App\Repositories;

use App\Models\User;

class DeveloperRepository 
{
  public function getDevelopers()
  {
    return User::orderByCanWorkSize()->get();
  }
}