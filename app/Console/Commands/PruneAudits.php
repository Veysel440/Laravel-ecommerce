<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuditLog;

class PruneAudits extends Command
{
    protected $signature = 'audits:prune {--days=90}';
    protected $description = 'Eski audit loglarını sil';
    public function handle(): int
    {
        $days = (int)$this->option('days');
        $n = AuditLog::where('created_at','<',now()->subDays($days))->delete();
        $this->info("Pruned {$n} audit logs."); return self::SUCCESS;
    }
}
