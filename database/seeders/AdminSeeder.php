<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'root',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->admin = \App\Models\Admin::first();
        // send welcome email
        Mail::raw('This is a simple text', function ($m) {
            $m->to($this->admin->email)->subject('Email Subject');
        });


        // for each admin assign role admin
        $this->command->info('Admin created successfully.');
    }
}
