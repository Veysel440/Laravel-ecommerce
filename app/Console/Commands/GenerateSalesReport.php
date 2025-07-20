<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class GenerateSalesReport extends Command
{
    protected $signature = 'report:generate-sales';
    protected $description = 'Toplam satış raporunu oluşturur ve log dosyasına kaydeder.';

    public function handle()
    {
        $totalSales = Order::where('status', 'completed')->sum('total_price');

        Log::info('Günlük satış raporu: ' . $totalSales . '₺');

        $this->info('Toplam Satış: ' . $totalSales . '₺');
    }
}
