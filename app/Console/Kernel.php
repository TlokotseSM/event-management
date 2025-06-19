<?php

protected function schedule(Schedule $schedule)
{
    $schedule->command('send:event-reminders')
             ->dailyAt('09:00');

    $schedule->command('cleanup:past-events')
             ->daily();
}
