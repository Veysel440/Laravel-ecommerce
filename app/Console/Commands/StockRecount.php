<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use Illuminate\Console\Command;

class StockRecount extends Command
{
    protected $signature = 'stock:recount {--threshold=5}';
    protected $description = 'Stokları kontrol et, eşik altı uyarıları tetikle';

    public function handle(): int
    {
        $th = (int)$this->option('threshold');
        $inv = Inventory::with('sku.product')->get();
        $count = 0;
        foreach ($inv as $i) {
            $avail = ($i->qty ?? 0) - ($i->reserved_qty ?? 0);
            if ($avail < $th) {
                event(new \App\Events\StockBelowThreshold($i->sku, $avail, $th));
                $count++;
            }
        }
        $this->info("Alerts emitted: {$count}");
        return self::SUCCESS;
    }
}
