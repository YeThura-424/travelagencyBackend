<?php

namespace App\Console\Commands;

use App\Models\Town;
use App\Models\Region;
use App\Models\Township;
use App\Models\TownshipFullInfo;
use Illuminate\Console\Command;
use App\Services\LocationService;

class LocationInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:app-location';

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
        $rawLocation = collect(config('region.data'));

        $this->installRegion($rawLocation);
        $this->installTown($rawLocation);
        $this->installTownship($rawLocation);
        $this->installTownshipFullInfo();
    }

    private function installRegion($locations)
    {

        foreach ($locations as $region) {
            Region::create([
                'name_en' => $region['eng'],
                'name_mm' => $region['mm'],
                'lat' => $region['lat'],
                'lng' => $region['lng']
            ]);
        }
        $this->info('Region Created Successfully');
    }

    private function installTown($locations)
    {
        $region_id = 1;
        foreach ($locations as $region) {
            foreach ($region['districts'] as $town) {
                Town::create([
                    'region_id' => $region_id,
                    'name_en' => $town['eng'],
                    'name_mm' => $town['mm']
                ]);
            }
            $region_id++;
        }

        $this->info('Town Created Successfully');
    }

    private function installTownship($locations)
    {
        $region_id = 1;
        foreach ($locations as $region) {
            foreach ($region['districts'] as $town) {
                $town_data = Town::where('name_en', $town['eng'])->first();
                foreach ($town['townships'] as $township) {
                    Township::create([
                        'region_id' => $region_id,
                        'town_id' => $town_data->id,
                        'name_en' => $township['eng'],
                        'name_mm' => $township['mm'],
                    ]);
                }
            }
            $region_id++;
        }
        $this->info('Township Created Successfully');
    }

    private function installTownshipFullInfo()
    {
        $locations = Township::all();
        foreach ($locations as $location) {
            TownshipFullInfo::create([
                'region' => $location->region,
                'town' => $location->town,
                'name_en' => $location->name_en,
                'name_mm' => $location->name_mm,
            ]);
        }

        $this->info('Township Full Info Created Successfully');
    }
}
