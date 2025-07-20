<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder(int $userId, float $totalPrice, array $items)
    {
        try {
            return $this->orderRepository->createOrder($userId, $totalPrice, $items);
        } catch (\Throwable $e) {
            Log::error('Sipariş oluşturulurken hata.', [
                'user_id'     => $userId,
                'total_price' => $totalPrice,
                'items'       => $items,
                'error'       => $e->getMessage(),
            ]);
            throw new Exception('Sipariş oluşturulamadı.');
        }
    }

    public function getUserOrders(int $userId)
    {
        try {
            return $this->orderRepository->getUserOrders($userId);
        } catch (\Throwable $e) {
            Log::error('Kullanıcının siparişleri getirilirken hata.', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
            throw new Exception('Sipariş bilgisi alınamadı.');
        }
    }

    public function getOrderById(int $id)
    {
        try {
            return $this->orderRepository->getOrderById($id);
        } catch (\Throwable $e) {
            Log::error('Sipariş detayı getirilirken hata.', [
                'order_id' => $id,
                'error'    => $e->getMessage(),
            ]);
            throw new Exception('Sipariş detayları alınamadı.');
        }
    }
}
