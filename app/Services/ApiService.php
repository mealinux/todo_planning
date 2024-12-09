<?php

namespace App\Services;

use App\Facades\ErrorHandlingServiceFacade;
use Exception;
use Illuminate\Support\Facades\Http;

class ApiService
{
  public function http(string $endpoint){
    try {
        return Http::get($endpoint);
    } catch (Exception $exception) {
        return ErrorHandlingServiceFacade::handleError($exception);
    }
  }
}