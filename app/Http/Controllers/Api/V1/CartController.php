<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\{AddCartItemRequest,UpdateCartItemRequest};
use App\Services\Cart\{CartResolver,CartService};
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct(private CartResolver $resolver, private CartService $service) {}

    public function show(Request $r)
    {
        $cart = $this->resolver->resolve($r);
        return ApiResponse::ok($this->service->present($cart));
    }

    public function add(AddCartItemRequest $r)
    {
        try {
            $cart = $this->resolver->resolve($r);
            $data = $this->service->add($cart, (int)$r->sku_id, (int)$r->qty);
            return ApiResponse::ok($data);
        } catch (\App\Exceptions\ApiException $e) { throw $e; }
        catch (\Throwable $e) { Log::error('cart.add',['e'=>$e]); return ApiResponse::fail('cart_add_failed',422); }
    }

    public function update(UpdateCartItemRequest $r, int $id)
    {
        try {
            $cart = $this->resolver->resolve($r);
            $data = $this->service->updateQty($cart, $id, (int)$r->qty);
            return ApiResponse::ok($data);
        } catch (\App\Exceptions\ApiException $e) { throw $e; }
        catch (\Throwable $e) { Log::error('cart.update',['e'=>$e]); return ApiResponse::fail('cart_update_failed',422); }
    }

    public function remove(Request $r, int $id)
    {
        $cart = $this->resolver->resolve($r);
        $data = $this->service->remove($cart, $id);
        return ApiResponse::ok($data);
    }
}
