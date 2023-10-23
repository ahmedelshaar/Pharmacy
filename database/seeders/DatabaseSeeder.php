<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* Permission::all()->each->delete();
         Role::all()->each->delete();
         $this->command->info('Creating roles.');
         Role::all()->each->delete();
         $admin = Role::create(['name' => 'admin']);
         $owner = Role::create(['name' => 'owner']);
         $doctor = Role::create(['name' => 'doctor']);

        */
        /*
                $this->command->info('Creating permissions.');

                // Doctor Permissions
                Permission::create(['name' => 'medicines']);
                Permission::create(['name' => 'orders']);

                // Owner Permissions
                // this + Doctor Permissions
                Permission::create(['name' => 'doctors']);

                // Admin Permissions
                // this + Owner Permissions + Doctor Permissions
                Permission::create(['name' => 'areas']);
                Permission::create(['name' => 'pharmacies']);
                Permission::create(['name' => 'owners']);
                Permission::create(['name' => 'users']);
                Permission::create(['name' => 'addresses']);


                $this->command->info('Creating roles.');
                Role::all()->each->delete();
                $admin = Role::create(['name' => 'admin']);
                $owner = Role::create(['name' => 'owner']);
                $doctor = Role::create(['name' => 'doctor']);

                $this->command->info('Assigning permissions to roles.');
                // permissions for admin
                $admin->givePermissionTo(Permission::all());
                // permissions for doctor
                $doctor->givePermissionTo('medicines');
                $doctor->givePermissionTo('orders');
                // perrimissions for owner
                $owner->givePermissionTo(Permission::all()->except(['areas', 'pharmacies', 'owners', 'users']));
                */

        DB::table("medicines_types")->count() > 0
            ?
            $this->command->warn('Medicines types table is not empty, therefore NOT seeding!')
            :
            $this->call(MedicinesTypesSeeder::class);
        DB::table("medicines")->count() > 0
            ?
            $this->command->warn('Medicines table is not empty, therefore NOT seeding!')
            :
            $this->call(MedicinesSeeder::class);

        DB::table("admins")->count() > 0
            ?
            $this->command->warn('Admins table is not empty, therefore NOT seeding!')
            :
            $this->call(AdminSeeder::class);

        DB::table(\Config::get('countries.table_name'))->count() > 0
            ?
            $this->command->warn('Countries table is not empty, therefore NOT seeding!')
            :
            $this->call(CountriesSeeder::class);

        DB::table("areas")->count() > 0
            ?
            $this->command->warn('Areas table is not empty, therefore NOT seeding!')
            :
//            AreaFactory::new()->count(50)->create();
            $this->call(AreaSeeder::class);
        DB::table("user_addresses")->count() > 0
            ?
            $this->command->warn('Addresses table is not empty, therefore NOT seeding!')
            :
//            AreaFactory::new()->count(50)->create();
            $this->call(UserAddressesSeeder::class);
    }
}
