<?php

namespace App\Services;

use function PHPSTORM_META\map;

class LocationService
{

  protected $rawLocation;
  public function __construct()
  {
    $this->rawLocation = collect(config('region.data'));
  }
  public function getRegion()
  {
    $region = [];
    $id = 1;
    foreach ($this->rawLocation as $location) {

      $region[] = [
        'id' => $id,
        'name_mm' => $location['eng'],
        'name_en' => $location['mm'],
        'lat' => $location['lat'],
        'lng' => $location['lng']
      ];
      $id++;
    }
    return $region;
  }

  public function getTown()
  {
    $town = [];
    $region_id = 1;
    foreach ($this->rawLocation as $location) {
      $id = 1;
      foreach ($location['districts'] as $data) {
        $town[] = [
          'id' => $id,
          'region_id' => $region_id,
          'name_en' => $data['eng'],
          'name_mm' => $data['mm']
        ];
        $id++;
      }
      $region_id++;
    }
    return $town;
  }
}
