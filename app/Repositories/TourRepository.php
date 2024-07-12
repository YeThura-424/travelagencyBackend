<?php

namespace App\Repositories;

use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTourRequest;

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
    $data = $this->createPayload($request);
    DB::beginTransaction();
    try {
      $tour = Tour::create($data);
      if ($tour) {
        $tour->update([
          'status' => Tour::STARUS_PENDING
        ]);
        DB::commit();
      }
      return $tour;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  private function createPayload($request)
  {
    //
  }
}
