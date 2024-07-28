<?php

namespace App\Repositories;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TourResource;
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

  /**
   * return (TR-2024-07-08-000001)
   * code generator
   */
  public function generateCode()
  {
    $start = 'TR';
    $date = Carbon::now()->format('Y-m-d');
    $rand_num = rand('111111', '999999');
    $code = $start . '-' . $date . '-' . $rand_num;

    return $code;
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
          'status' => Tour::STATUS_PENDING
        ]);
        foreach ($tourItem as $item) {
          $id = $item->id;
          $title = $item->title;
          $description = $item->description;
          $image = $this->uploadFile($item->image);

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
      'code' => $this->generateCode(),
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
    // $imagename = time() . '.' . $files->extension();
    // $files->move(public_path('images/tour'), $imagename);
    // $image = 'images/destination/' . $imagename;

    return $files;
  }

  public function approve(Request $request, $id)
  {
    $tour = $this->getModel()->find($id);
    $destination_status = $tour->logs()
      ->where('status', Tour::STATUS_PENDING)
      ->first();
    if ($destination_status) {

      $tour->status = Tour::STATUS_ONGOING;
      $tour->save();

      // DestinationStatusLog::recordStatusLog($tour, $request);
      return json_response('200', 'Status update successfully', $tour);
    } else {
      return json_response('422', 'Current action can not be done', []);
    }
  }

  public function detail($id)
  {
    $tour = Tour::find($id);
    if ($tour) {
      $message = "Tour Retrived Successfully";
      $data = new TourResource($tour);

      return json_response('200', $message, $data);
    } else {
      $message = "Tour Data not Found";
      return json_response('404', $message, []);
    }
  }
}
