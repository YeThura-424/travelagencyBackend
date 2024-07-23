<?php

namespace App\Console\Commands;

use App\Models\Township;
use Illuminate\Console\Command;
use App\Services\LocationService;

class Location extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $location = new LocationService();
        // $region = $location->getRegion();
        // $region = $location->getTown();
        // $region = $location->getTownship();

        // $location = Township::latest()->first();
        // $region = $location->region;
        // logger($region);
        // dd('here');
        $data = [
            [
                "title" => "Test Title 1",
                "description" => "Test Description 1",
                "image" => "TestImg1.png"
            ],
            [
                "title" => "Test Title 2",
                "description" => "Test Description 2",
                "image" => "TestImg2.png"
            ],

        ];

        $string_data = json_encode($data);
        logger($string_data);
        dd('here');
    }
}
