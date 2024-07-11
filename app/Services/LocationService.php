<?php

namespace App\Services;

use App\Models\Town;
use App\Models\Region;
use App\Models\Township;
use App\Models\TownshipFullInfo;

class LocationService
{
  public function getRegion()
  {
    return Region::all();
  }

  public function getTown()
  {
    return Town::all();
  }

  public function getTownship()
  {
    return Township::all();
  }
  public function getTownshipFullInfo()
  {
    return TownshipFullInfo::all();
  }
}
