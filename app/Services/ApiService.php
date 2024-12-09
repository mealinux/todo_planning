<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ApiService
{
  public function __construct(
    protected ErrorHandlingService $errorHandlingService
) {}

  public function http(string $endpoint){
    try {
        return Http::get($endpoint);
    } catch (Exception $exception) {
        return $this->errorHandlingService->handleError($exception);
    }
  }
}