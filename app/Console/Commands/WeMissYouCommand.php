<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeMissYouNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeMissYouCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:we-miss-you-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Miss You to User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('last_login', '<=', Carbon::now()->subMonth())->get();

        foreach ($users as $user) {
            $user->notify(new WeMissYouNotification($user));
        }

        $this->info('Email sent successfully to All user inactive from one month.');
    }
}
