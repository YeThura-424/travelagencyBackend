<?php

namespace App\Console\Commands;

use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateTourExpiredField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tour-expiry';

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
        $today = Carbon::now();
        $tours = Tour::whereDate('end_date', $today)
            ->where('status', Tour::STATUS_ONGOING)
            ->get();

        if (isset($tours)) {
            foreach ($tours as $tour) {
                $tour->update([
                    'status' => Tour::STATUS_OVER
                ]);

                logger("Tour status with name $tour->name has been updated Successfully");
            }
        } else {
            logger("No tour data found to update the status OVER for $today ");
        }
    }
}
