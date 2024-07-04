<?php

namespace App\Repository;

use App\Models\Destination;

class DestinationRepository
{
  //model initialization
  public function model()
  {
    return new Destination();
  }

  public function getAllDestination()
  {
    return $this->model()->all();
  }
}