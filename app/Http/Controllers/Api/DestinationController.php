<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Repositories\DestinationRepository;
use App\Http\Requests\StoreDestinationRequest;

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

    public function approve(Request $request, $id)
    {
        return $this->repo->approve($request, $id);
    }

    public function reject(Request $request, $id)
    {
        return $this->repo->reject($request, $id);
    }
}
