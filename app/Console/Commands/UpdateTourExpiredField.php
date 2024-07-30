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
     * ဒါက Tour တစ်ခုရဲ့ သက်မှတ်ထားတဲ့ end date ကျော် သွားတဲ့ အခါမှာ status ကို over ပြောင်းဖို့ 
     */
    public function handle()
    {
        $today = Carbon::now();
        $tours = Tour::whereDate('end_date', $today)
            ->where('status', Tour::STATUS_ONGOING)
            ->get();
        if ($tours->isNotEmpty()) {
            foreach ($tours as $tour) {
                $tour->update([
                    'status' => Tour::STATUS_OVER
                ]);

                logger("Tour status with name $tour->name has been updated Successfully");
                $this->info("Tour status with name $tour->name has been updated Successfully");
            }
        } else {
            logger("No tour data found to update the status OVER for $today ");
            $this->info("No tour data found to update the status OVER for $today ");
        }
    }
}
