<?php

namespace App\Repositories\Cart;

use App\Models\CartItem;
class CartRepository
{
    public function getUserCart(int $userId)
    {
        return CartItem::where('user_id', $userId)->with('product')->get();
    }

    public function addToCart(int $userId, int $productId, int $quantity)
    {
        return CartItem::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $productId],
            ['quantity' => \DB::raw("quantity + {$quantity}")]
        );
    }

    public function updateQuantity(int $cartItemId, int $quantity)
    {
        $item = CartItem::find($cartItemId);

        if (!$item) return false;

        $item->quantity = $quantity;
        return $item->save();
    }

    public function removeItem(int $cartItemId)
    {
        return CartItem::where('id', $cartItemId)->delete();
    }

    public function clearCart(int $userId)
    {
        return CartItem::where('user_id', $userId)->delete();
    }

}
