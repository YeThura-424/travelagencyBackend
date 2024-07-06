<?php

namespace App\Repository;

use App\Models\Destination;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDestinationRequest;

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
    $file = $this->uploadFile($request);
    $data = $this->createPayload($request);

    $data['images'] = json_encode($file);
    DB::beginTransaction();
    try {
      $destination = Destination::create($data);
      if ($destination) {
        $destination->update([
          'status' => Destination::STATUS_PENDING
        ]);
        DB::commit();
      }
      return $destination;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function uploadFile(StoreDestinationRequest $request)
  {
    if ($request->hasfile('images')) {
      $i = 1;
      $data = [];
      foreach ($request->file('images') as $image) {
        $imagename = time() . $i . '.' . $image->extension();
        $image->move(public_path('images/destination'), $imagename);
        $data[] = 'images/destination/' . $imagename;
        $i++;
      }

      return $data;
    } else {
      return;
    }
  }

  public function createPayload(StoreDestinationRequest $request)
  {
    $data = [
      'name' => $request->name,
      'location' => $request->location,
      'description' => $request->description,
    ];

    return $data;
  }
}
