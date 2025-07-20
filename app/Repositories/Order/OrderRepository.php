<?php

namespace App\Repositories\Order;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(int $userId, float $totalPrice, array $items)
    {
        return DB::transaction(function () use ($userId, $totalPrice, $items) {
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            return $order->load('items');
        });
    }

    public function getUserOrders(int $userId)
    {
        return Order::where('user_id', $userId)->with('items.product')->get();
    }

    public function getOrderById(int $id)
    {
        return Order::with('items.product')->find($id);
    }
}
