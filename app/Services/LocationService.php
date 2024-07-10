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
    foreach ($this->rawLocation as $location) {

      $region[] = [
        'name_en' => $location['eng'],
        'name_mm' => $location['mm'],
        'lat' => $location['lat'],
        'lng' => $location['lng']
      ];
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

  public function getTownship()
  {
    $township = [];
    $region_id = 1;
    foreach ($this->rawLocation as $location) {
      $town_id = 1;
      foreach ($location['districts'] as $towns) {
        $id = 1;
        foreach ($towns['townships'] as $data) {
          $township[] = [
            'id' => $id,
            'region_id' => $region_id,
            'town_id' => $town_id,
            'name_en' => $data['eng'],
            'name_mm' => $data['mm']
          ];
          $id++;
        }
        $town_id++;
      }
      $region_id++;
    }
    return $township;
  }
}
