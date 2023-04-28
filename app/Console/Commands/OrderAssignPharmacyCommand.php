<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Console\Command;

class OrderAssignPharmacyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-assign-pharmacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Order Assign Pharmacy Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::withoutGlobalScopes()->whereNull('pharmacy_id')->get();
        $pharmacies = Pharmacy::all();
        foreach ($order as $item) {
            $pharmacy = $pharmacies->where('area_id', $item->address->area_id)->sortBy('priority')->first();
            if($pharmacy){
                $item->pharmacy_id = $pharmacy->id;
                $item->status = 'Processing';
                $item->save();
            }
        }
        $this->info('Order Assign Pharmacy Command');
    }
}
