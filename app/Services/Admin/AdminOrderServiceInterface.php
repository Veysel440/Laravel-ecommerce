<?php

namespace App\Services\Admin;

interface AdminOrderServiceInterface
{
    public function listAllOrders();
    public function getOrderDetail(int $orderId);
    public function updateOrderStatus(int $orderId, string $status);
    public function deleteOrder(int $orderId);

}
