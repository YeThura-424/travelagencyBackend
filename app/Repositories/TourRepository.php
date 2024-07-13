<?php

namespace App\Repositories;

use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTourRequest;
use Illuminate\Support\Carbon;

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
    $tourItem = json_decode($request->tourItem);
    DB::beginTransaction();
    try {
      $tour = Tour::create($data);
      if ($tour) {
        $tour->update([
          'status' => Tour::STARUS_PENDING
        ]);
        foreach ($tourItem as $item) {
          $id = $item->id;
          $title = $item->title;
          $description = $item->description;
          $image = $this->uploadFile($item->images);

          $tour->destinations()->attach($id, [
            'title' => $title,
            'description' => $description,
            'image' => $image
          ]);
        }
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
    $payload = [
      'name' => $request->name,
      'description' => $request->description,
      'price' => $request->price,
      'duration' => $request->duration,
      'start_date' => Carbon::parse($request->start_date),
      'end_date' => Carbon::parse($request->end_date),
      'max_people' => $request->max_people
    ];

    return $payload;
  }

  private function uploadFile($files)
  {
    return [];
  }
}
