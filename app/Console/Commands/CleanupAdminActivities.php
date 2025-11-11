<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminActivity;
use Carbon\Carbon;

class CleanupAdminActivities extends Command
{
    protected $signature = 'admin-activities:cleanup {--days=365 : Retention days}';
    protected $description = 'Hapus admin activities older than configured retention days';

    public function handle()
    {
        $days = (int) $this->option('days') ?: (int) env('ADMIN_ACTIVITY_RETENTION_DAYS', 365);
        $cutoff = Carbon::now()->subDays($days);

        $count = AdminActivity::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted {$count} admin activity records older than {$days} days.");
        return 0;
    }
}
