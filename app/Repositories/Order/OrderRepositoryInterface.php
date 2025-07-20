<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function createOrder(int $userId, float $totalPrice, array $items);
    public function getUserOrders(int $userId);
    public function getOrderById(int $id);

}
