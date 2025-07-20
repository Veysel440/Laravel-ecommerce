<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminReportService implements AdminReportServiceInterface
{
    public function totalSales()
    {
        try {
            return Order::where('status', 'completed')->sum('total_price');
        } catch (\Throwable $e) {
            Log::error('Toplam satış hesaplanırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Toplam satış verisi alınamadı.');
        }
    }

    public function totalOrders()
    {
        try {
            return Order::count();
        } catch (\Throwable $e) {
            Log::error('Toplam sipariş sayısı alınırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Toplam sipariş sayısı alınamadı.');
        }
    }

    public function totalUsers()
    {
        try {
            return User::count();
        } catch (\Throwable $e) {
            Log::error('Toplam kullanıcı sayısı alınırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Toplam kullanıcı sayısı alınamadı.');
        }
    }

    public function summary()
    {
        try {
            return [
                'total_sales'  => $this->totalSales(),
                'total_orders' => $this->totalOrders(),
                'total_users'  => $this->totalUsers(),
            ];
        } catch (\Throwable $e) {
            Log::error('Rapor özeti alınırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Rapor özeti alınamadı.');
        }
    }
}
