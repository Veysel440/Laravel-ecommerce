<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartItemResource;
use App\Services\Cart\CartServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cartItems = $this->cartService->getUserCart($userId);

        return ApiResponse::success(CartItemResource::collection($cartItems), 'Sepet ürünleri listelendi.');
    }

    public function add(CartAddRequest $request)
    {
        $userId = $request->user()->id;
        $validated = $request->validated();

        $item = $this->cartService->addToCart(
            $userId,
            $validated['product_id'],
            $validated['quantity']
        );

        return ApiResponse::success(new CartItemResource($item), 'Ürün sepete eklendi.');
    }

    public function update(CartUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $this->cartService->updateQuantity($id, $validated['quantity']);

        return ApiResponse::success(null, 'Sepet ürünü miktarı güncellendi.');
    }

    public function remove($id)
    {
        $this->cartService->removeItem($id);

        return ApiResponse::success(null, 'Ürün sepetten silindi.');
    }

    public function clear(Request $request)
    {
        $userId = $request->user()->id;
        $this->cartService->clearCart($userId);

        return ApiResponse::success(null, 'Sepet başarıyla temizlendi.');
    }
}
