<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createAdmin
                            {--email= : The email address of the admin user.}
                            {--password= : The password for the admin user.}
                            {--name= : The name for the admin user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');
        if ($this->validateInput()) {
            $admin = new Admin;
            $admin->email = $email;
            $admin->password = bcrypt($password);
            $admin->name = $name ? $name : 'Admin';
            $admin->save();

            $this->info("Admin created successfully.");
            $this->info("Email: $email");
            $this->info("Name: $admin->name");
//            $this->info("Password: $password");
        }

    }

    // add some validation
    protected function validateInput()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $errors = 0;
        if (empty($email)) {
            $this->error('Email is required.');
            $errors++;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email is invalid.');
            $errors++;
        }
        if (Admin::where('email', $email)->exists()) {
            $this->error('Email already exists.');
            $errors++;
        }
        if (empty($password)) {
            $this->error('Password is required.');
            $errors++;
        }
        if (strlen($password) < 6) {
            $this->error('Password must be at least 6 characters.');
            $errors++;
        }

        return $errors === 0;
    }
}
