<?php

namespace App\Console\Commands;

use App\Services\LocationService;
use Illuminate\Console\Command;

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
        $location = new LocationService();
        // $region = $location->getRegion();
        // $region = $location->getTown();
        $region = $location->getTownship();
        logger($region);
        dd('here');
    }
}
