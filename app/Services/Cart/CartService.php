<?php

namespace App\Services\Cart;

use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class CartService implements CartServiceInterface
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getUserCart(int $userId)
    {
        try {
            return $this->cartRepository->getUserCart($userId);
        } catch (\Throwable $e) {
            Log::error('Sepet getirilirken hata.', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
            throw new Exception('Sepet bilgisi alınamadı.');
        }
    }

    public function addToCart(int $userId, int $productId, int $quantity)
    {
        try {
            return $this->cartRepository->addToCart($userId, $productId, $quantity);
        } catch (\Throwable $e) {
            Log::error('Sepete ürün eklenirken hata.', [
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantity,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün sepete eklenemedi.');
        }
    }

    public function updateQuantity(int $cartItemId, int $quantity)
    {
        try {
            return $this->cartRepository->updateQuantity($cartItemId, $quantity);
        } catch (\Throwable $e) {
            Log::error('Sepet ürün miktarı güncellenirken hata.', [
                'cart_item_id' => $cartItemId,
                'quantity'     => $quantity,
                'error'        => $e->getMessage(),
            ]);
            throw new Exception('Sepet ürünü güncellenemedi.');
        }
    }

    public function removeItem(int $cartItemId)
    {
        try {
            return $this->cartRepository->removeItem($cartItemId);
        } catch (\Throwable $e) {
            Log::error('Sepet ürünü silinirken hata.', [
                'cart_item_id' => $cartItemId,
                'error'        => $e->getMessage(),
            ]);
            throw new Exception('Ürün sepetten silinemedi.');
        }
    }

    public function clearCart(int $userId)
    {
        try {
            return $this->cartRepository->clearCart($userId);
        } catch (\Throwable $e) {
            Log::error('Sepet temizlenirken hata.', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
            throw new Exception('Sepet temizlenemedi.');
        }
    }
}
