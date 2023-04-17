<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--email= : The email of the admin} {--password= : The password of the admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');

        while (true){
            $email = $this->ask('Email');
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error('Email is not valid');
            }else{
                if (Admin::where('email', $email)->exists()) {
                    $this->error('Admin already exists');
                }else{
                    break;
                }
            }
        }

        while (true){
            $password = $this->secret('Password');
            if (strlen($password) < 6) {
                $this->error('Password must be at least 6 characters');
            }else{
                break;
            }
        }

        $this->info('Creating admin...');

        $admin = new Admin();
        $admin->email = $email;
        $admin->password = Hash::make($password);
        $admin->save();

        $this->info('Admin created!');
    }
}
