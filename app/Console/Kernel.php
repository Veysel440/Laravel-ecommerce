<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('carts:prune')->hourly();
        $schedule->command('stock:recount')->everyTwoHours();
        $schedule->command('reports:sales-snapshot')->dailyAt('23:55');
        $schedule->command('audits:prune')->weeklyOn(1, '03:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
