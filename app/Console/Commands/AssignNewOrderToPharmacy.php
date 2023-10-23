<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\UserAddress;
use Illuminate\Console\Command;

class AssignNewOrderToPharmacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:assign-new-order-to-pharmacy';

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
        $pharmacies= Pharmacy::all();
        $new_orders = Order::where('status', 'New')->get();
        foreach ($new_orders as $order) {
            $pharmacy = null;
            foreach ($pharmacies as $p) {
                $address = UserAddress::where('id',$order->delivering_address_id)->first();
                if ($p->area_id == $address->area_id) {
                    if ($pharmacy == null || $p->priority > $pharmacy->priority) {
                        $pharmacy = $p;
                    }
                }
            }
            if ($pharmacy != null) {
                Order::where('id', $order->id)->update(['status' => 'Processing', 'pharmacy_id' => $pharmacy->id]);
            }
        }
    }
}
