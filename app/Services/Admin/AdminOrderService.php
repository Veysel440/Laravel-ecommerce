<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Order;
class AdminOrderService implements AdminOrderServiceInterface
{
    public function listAllOrders()
    {
        try {
            return Order::with('items.product', 'user')->get();
        } catch (\Throwable $e) {
            Log::error('Tüm siparişler getirilirken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Sipariş listesi alınamadı.');
        }
    }

    public function getOrderDetail(int $orderId)
    {
        try {
            return Order::with('items.product', 'user')->findOrFail($orderId);
        } catch (\Throwable $e) {
            Log::error('Sipariş detayı getirilirken hata.', [
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
            throw new Exception('Sipariş detayı getirilemedi.');
        }
    }

    public function updateOrderStatus(int $orderId, string $status)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->status = $status;
            $order->save();
            return $order;
        } catch (\Throwable $e) {
            Log::error('Sipariş durumu güncellenirken hata.', [
                'order_id' => $orderId,
                'status'   => $status,
                'error'    => $e->getMessage(),
            ]);
            throw new Exception('Sipariş durumu güncellenemedi.');
        }
    }

    public function deleteOrder(int $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error('Sipariş silinirken hata.', [
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
            throw new Exception('Sipariş silinemedi.');
        }
    }
}

