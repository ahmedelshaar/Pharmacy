<?php

namespace App\Console;

use App\Console\Commands\NotifyInactiveUsersForMonth;
use App\Console\Commands\AssignNewOrderToPharmacy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        NotifyInactiveUsersForMonth::class,
        AssignNewOrderToPharmacy::class
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sanctum:prune-expired --hours=24')->daily(); // remove expired tokens every 24 hours
        $schedule->command('queue:work')->withoutOverlapping()->everyMinute();
        $schedule->command('notify:users-not-logged-in-for-month')->daily();
        $schedule->command("order:assign-new-order-to-pharmacy")->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
