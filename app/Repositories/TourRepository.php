<?php

namespace App\Repositories;

use App\Http\Requests\StoreTourRequest;
use App\Models\Tour;

class TourRepository
{
  public function getModel()
  {
    return new Tour();
  }

  public function index()
  {
    return $this->getModel()->all();
  }

  public function store(StoreTourRequest $request)
  {
    dd('here');
  }
}
