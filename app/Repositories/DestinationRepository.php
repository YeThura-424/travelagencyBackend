<?php

namespace App\Repository;

use App\Http\Requests\StoreDestinationRequest;
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

  public function store(StoreDestinationRequest $request)
  {
    $name = $request->name;
    $location = $request->location;
    $descriptions = $request->description;
    $images = $request->images;
    $status = 'pending';

    $destination = new Destination();
    $destination->name = $name;
    $destination->location = $location;
    $destination->description = $descriptions;
    $destination->images = $images;
    $destination->status = $status;
    $destination->save();

    return $destination;
  }
}