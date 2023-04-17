<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Area;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesSeeder::class);

        Admin::factory(1)->create();
        User::factory(10)->create();
        Area::factory(10)->create();
        Pharmacy::factory(10)->create();
        Doctor::factory(10)->create();
        Medicine::factory(10)->create();
        UserAddress::factory(10)->create();
        Order::factory(10)->create();
        OrderMedicine::factory(10)->create();



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
