<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $location;
    public function __construct()
    {
        $this->location = new LocationService;
    }
    public function getTownship()
    {
        return $this->location->getTownship();
    }
}
