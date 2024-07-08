<?php

namespace App\Repository;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDestinationRequest;
use App\Models\DestinationStatusLog;
use Carbon\Carbon;

class DestinationRepository
{
  //model initialization
  public function model()
  {
    return new Destination();
  }

  public function getAll($request)
  {
    $query = $this->model();
    if ($name = $request->name) {
      $query = $query->where('name', $name);
    }
    if ($description = $request->description) {
      $query = $query->where('description', 'LIKE', "%.{$description}.%");
    }
    if ($status = $request->status) {
      $query = $query->where('status', $status);
    }
    return $query->paginate(10);
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
        DestinationStatusLog::recordStatusLog($destination, $request);
        DB::commit();
      }
      return $destination;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  //DES-2024-07-08-000001
  public function generateCode()
  {
    $start = 'DES';
    $date = Carbon::now()->format('Y-m-d');
    $rand_num = rand('111111', '999999');
    $code = $start . '-' . $date . '-' . $rand_num;

    return $code;
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
      'code' => $this->generateCode(),
      'name' => $request->name,
      'location' => $request->location,
      'description' => $request->description,
    ];

    return $data;
  }
  /**
   * @param id;
   * to update the destination from pending state
   */
  public function approve(Request $request, $id)
  {
    $destination = $this->model()->find($id);
    $destination_status = $destination->logs()
      ->where('status', Destination::STATUS_PENDING)
      ->first();
    if ($destination_status) {

      $destination->status = Destination::STATUS_APPROVED;
      $destination->save();

      DestinationStatusLog::recordStatusLog($destination, $request);
      return json_response('200', 'Status update successfully', $destination);
    } else {
      return json_response('422', 'Current action can not be done', []);
    }
  }

  public function reject(Request $request, $id)
  {
    $destination = $this->model()->find($id);
    $destination_status = $destination->logs()
      ->where('status', Destination::STATUS_APPROVED)
      ->first();

    if ($destination_status) {
      return json_response('422', 'Approved destination data can not be rejected!!', []);
    } else {
      $destination->status = Destination::STATUS_REJECTED;
      $destination->save();

      DestinationStatusLog::recordStatusLog($destination, $request);
      return json_response('200', 'Status update successfully', $destination);
    }
  }
}
