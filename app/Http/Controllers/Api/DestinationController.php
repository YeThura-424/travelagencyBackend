<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Repository\DestinationRepository;

class DestinationController extends Controller
{
    protected $repo;
    public function __construct(DestinationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $destinations = $this->repo->getAllDestination();
        if(is_null($destinations)){
            return response()->json([
                'status' => 422,
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
}
