<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Repositories\TourRepository;
use App\Http\Requests\StoreTourRequest;

class TourController extends Controller
{
    protected $repo;

    public function __construct(TourRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $tour = $this->repo->index();
        if ($tour) {
            $data = TourResource::collection($tour);
            $message = "Tour Data Retrived Successfully";
            return json_response('200', $message, $data);
        } else {
            $message = "No Tour Data found!!";
            return json_response('422', $message, []);
        }
    }

    public function store(StoreTourRequest $request)
    {
        dd('here');
        $tour = $this->repo->store($request);
        if ($tour) {
            $data = new TourResource($tour);
            $message = "Tour Created Successfully!";
            return json_response('201', $message, $data);
        } else {
            $message = "Error Creating Tour Package!!";
            return json_response('422', $message, []);
        }
    }
}
