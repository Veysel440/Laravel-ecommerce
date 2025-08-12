<?php

namespace App\Services\Cart;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CartResolver {
    public function resolve(Request $req): Cart {
        $sid = $req->header('X-Cart-Session') ?: $req->cookie('cart_session') ?: (string) Str::uuid();
        /** @var \App\Models\User|null $user */
        $user = $req->user();
        $cart = Cart::firstOrCreate(['session_id'=>$sid], [
            'user_id'=>$user?->id, 'currency'=>'TRY', 'totals'=>null
        ]);
        if ($user && $cart->user_id !== $user->id) { $cart->update(['user_id'=>$user->id]); }

        app()->instance('cart_session', $sid);
        return $cart->load('items.sku.inventory');
    }
    public function sessionId(): string { return app('cart_session'); }
}
