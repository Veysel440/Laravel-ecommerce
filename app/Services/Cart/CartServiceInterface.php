<?php

namespace App\Services\Cart;

interface CartServiceInterface
{
    public function getUserCart(int $userId);
    public function addToCart(int $userId, int $productId, int $quantity);
    public function updateQuantity(int $cartItemId, int $quantity);
    public function removeItem(int $cartItemId);
    public function clearCart(int $userId);

}
