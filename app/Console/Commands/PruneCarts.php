<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;

class PruneCarts extends Command
{
    protected $signature = 'carts:prune {--days=30}';
    protected $description = 'İçi boş ve eski sepetleri sil';

    public function handle(): int
    {
        $days = (int)$this->option('days');
        $count = Cart::whereDoesntHave('items')
            ->where('updated_at','<',now()->subDays($days))
            ->delete();
        $this->info("Pruned: {$count}");
        return self::SUCCESS;
    }
}
