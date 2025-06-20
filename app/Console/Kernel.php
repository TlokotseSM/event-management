<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendEventReminders::class,
        \App\Console\Commands\CleanupPastEvents::class,
    ];

    protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class, 
    \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
    // ... other middleware
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:event-reminders')
                 ->dailyAt('09:00');

        $schedule->command('cleanup:past-events')
                 ->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
