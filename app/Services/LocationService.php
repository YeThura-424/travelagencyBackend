<?php

namespace App\Services;

class LocationService
{
  public function getRegion()
  {
    $rawlocation = collect(config('region.data'));
    info($rawlocation->first());
  }
}
