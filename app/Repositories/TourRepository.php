<?php

namespace App\Repositories;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TourResource;
use App\Http\Requests\StoreTourRequest;
use App\Models\TourStatusLog;

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
   * @return ('TR-2024-07-08-000001')
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

  /**
   * store fresh tour package data with status pending
   * add tour detail (pivot with destination)
   * @param  mixed $request
   * @return void
   */
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

        TourStatusLog::recordStatusLog($tour, $request);
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

  /**
   * to approve pending status tour to ongoing
   * will only approve with status pending
   * add status log for making ongoing in log
   * @param  mixed $request
   * @param  mixed $id
   * @return void
   */
  public function approve(Request $request, $id)
  {
    $tour = $this->getModel()->find($id);
    $tour_status = $tour->logs()
      ->where('status', Tour::STATUS_PENDING)
      ->first();
    if ($tour_status) {

      $tour->status = Tour::STATUS_ONGOING;
      $tour->save();

      TourStatusLog::recordStatusLog($tour, $request);
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

  public function reactivate(Request $request, $id)
  {
    // logic for reactivating the tour package

    $expired_tour = Tour::find($id)->where('status', Tour::STATUS_OVER);
    if ($expired_tour) {
      dd('update');
    } else {
      dd('no data for updating');
    }
  }
}
