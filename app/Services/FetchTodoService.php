<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FetchTodoService
{
  public function __construct(
    protected array $schema
  ) {}

  public function fetchTodoFromEndPoint(string $endpoint) : array {
    
    $response = Http::get($endpoint);

    if($response->ok()){
      return $this->mapData($response->json());
    }

    throw new \Exception("Failed fetch data from $endpoint");
  }

  private function mapData(array $data) : array {
    
    $mappedData = [];
    
    foreach ($data as $item) {
      $mappedItem = [];

      foreach ($this->schema as $dbColumn => $key) {
        
        $value = $this->findValueFromKey($item, $key);
        if($value){
          $mappedItem[$dbColumn] = $value;
        }
      }

      $mappedData[] = $mappedItem;
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