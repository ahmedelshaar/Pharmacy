<?php

namespace App\Console\Commands;

use App\Jobs\SendMail;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyInactiveUsersForMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:users-not-logged-in-for-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to inactive users who haven\'t logged in for the past month.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('last_login','<',Carbon::now()->subMonth())->get();

        foreach ($users as $user) {
            SendMail::dispatch($user,'inactive_user_for_month_notification');
        }
    }
}
