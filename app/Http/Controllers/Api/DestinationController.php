<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\DestinationRepository;
use App\Http\Resources\DestinationResource;
use App\Http\Requests\StoreDestinationRequest;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $repo;
    public function __construct(DestinationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll(Request $request)
    {
        $destinations = $this->repo->getAll($request);
        if (is_null($destinations)) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Not found for this Request!!',
                'data' => []
            ]);
        } else {
            $result = DestinationResource::collection($destinations);
            return response()->json([
                'status' => 200,
                'message' => "Destinations Retrived Successfully",
                'data' => $result
            ]);
        }
    }

    public function store(StoreDestinationRequest $request)
    {
        $destination = $this->repo->store($request);
        return response()->json([
            'status' => 201,
            'message' => 'Destination Created Successfully',
            'data' => $destination
        ]);
    }

    public function updateStatus($id)
    {
        $data = $this->repo->updateStatus($id);
    }
}
