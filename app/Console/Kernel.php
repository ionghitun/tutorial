<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 *
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->daily()->appendOutputTo(storage_path('logs/cron/inspire.log'));

        $schedule->command('horizon:snapshot')->everyFiveMinutes()->appendOutputTo(storage_path('logs/cron/horizon-snapshot.log'));

        $schedule->command('cache:prune-stale-tags')->hourly()->appendOutputTo(storage_path('logs/cron/cache-prune-stale-tags.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
