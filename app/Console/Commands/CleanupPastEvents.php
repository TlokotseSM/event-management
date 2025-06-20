<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class CleanupPastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:past-events';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Cleanup past events that are older than specified days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the retention period from config (default to 30 days)
        $retentionDays = config('app.event_retention_days', 30);

        $cutoffDate = now()->subDays($retentionDays);

        $this->info("Cleaning up events older than {$cutoffDate->format('Y-m-d')}");

        try {
            $deletedCount = Event::where('end_date', '<', $cutoffDate)
                ->delete();

            $this->info("Successfully deleted {$deletedCount} past events.");
            Log::info("Deleted {$deletedCount} past events older than {$cutoffDate}");

            return SymfonyCommand::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Error cleaning up past events: " . $e->getMessage());
            Log::error("Failed to clean up past events: " . $e->getMessage());

            return SymfonyCommand::FAILURE;
        }
    }
}
