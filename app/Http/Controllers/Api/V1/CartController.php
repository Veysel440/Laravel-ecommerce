<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use Illuminate\Http\Client\Request;

class CartController extends Controller {
    public function __construct(private \App\Services\Cart\CartResolver $resolver,
                                private \App\Services\Cart\CartService $cart) {}

    public function show(Request $req)
    {
        $c = $this->resolver->resolve($req);
        return response()->json(['success'=>true,'data'=>$c->load('items.sku.inventory')]);
    }
    public function add(\App\Http\Requests\Cart\AddCartItemRequest $req) {
        try {
            $cart = $this->resolver->resolve($req);
            $c = $this->cart->add($cart, (int)$req->sku_id, (int)$req->qty);
            return \App\Support\ApiResponse::ok($c);
        } catch (\App\Exceptions\ApiException $e) {
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('cart.add.failed', ['e'=>$e]);
            throw new \App\Exceptions\DomainStateException('cart_add_failed');
        }
    }

    public function update(\App\Http\Requests\Cart\UpdateCartItemRequest $req, int $id) {
        try {
            $cart = $this->resolver->resolve($req);
            $c = $this->cart->updateQty($cart, $id, (int)$req->qty);
            return \App\Support\ApiResponse::ok($c);
        } catch (\App\Exceptions\ApiException $e) { throw $e; }
        catch (\Throwable $e) { \Log::error('cart.update.failed',['e'=>$e]); throw new \App\Exceptions\DomainStateException('cart_update_failed'); }
    }
    public function remove(Request $req, int $id)
    {
        $cart = $this->resolver->resolve($req);
        $c = $this->cart->remove($cart, $id);
        return response()->json(['success'=>true,'data'=>$c]);
    }
}
