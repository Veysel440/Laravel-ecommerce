<?php

namespace App\Console\Commands;


use App\Services\Admin\ReportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateSalesSnapshot extends Command
{
    protected $signature = 'reports:sales-snapshot';
    protected $description = 'Günlük satış snapshot cache';

    public function handle(ReportService $svc): int
    {
        $from = now()->startOfMonth()->toDateString();
        $to   = now()->endOfDay()->toDateTimeString();
        $data = $svc->sales($from, $to, 'day');
        Cache::put('dash:sales:current_month', $data, now()->addDay());
        $this->info('Snapshot cached');
        return self::SUCCESS;
    }
}
