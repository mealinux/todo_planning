<?php

namespace App\Services;

use App\Services\ApiService;
use Illuminate\Support\Facades\Http;

class FetchTaskService
{
  public function __construct(
    protected array $schema,
    protected ApiService $apiService
  ) {}

  public function fetchTaskFromEndPoint(int $workSheet, string $endpoint) : array {
    
    $response = $this->apiService->http($endpoint);

    if($response->ok()){
      return $this->mapData($workSheet, $response->json());
    }

    throw new \Exception("Failed fetch data from $endpoint");
  }

  private function mapData(int $workSheet, array $data) : array {
    
    $mappedData = [];
    
    foreach ($data as $item) {
      $mappedItem = [];

      foreach ($this->schema as $dbColumn => $key) {
        
        $value = $this->findValueFromKey($item, $key);
        if($value){
          $mappedItem[$dbColumn] = $value;
        }
      }

      $mappedData[$workSheet][] = $mappedItem;
    }

    return $mappedData;
  }

  private function findValueFromKey(array $item, array $key) {
    
    foreach ($key as $k) {
      if(array_key_exists($k, $item)){
        return $item[$k];
      }
    }

    return null;
  }
}