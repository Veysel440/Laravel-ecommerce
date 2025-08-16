<?php

namespace App\Http\Controllers\Api\V1;



use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\{CheckoutAddressRequest,CheckoutShippingRequest,PaymentIntentRequest,CheckoutConfirmRequest};
use App\Services\Cart\CartResolver;
use App\Services\Cart\TotalsService;
use App\Services\Inventory\InventoryService;
use App\Services\Order\OrderService;
use App\Services\Payment\PaymentGatewayManager;
use App\Support\ApiResponse;
use App\Events\{OrderCreated,PaymentSucceeded};
use App\Exceptions\{ApiException, PaymentFailedException, DomainStateException};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;use App\Http\Requests\Checkout\ShippingOptionsRequest;
use App\Services\Shipping\ShippingService;
use App\Support\TotalsPresenter;


class CheckoutController extends Controller
{


    public function __construct(
        private CartResolver $resolver,
        private InventoryService $inv,
        private OrderService $orders,
        private PaymentGatewayManager $payments
    ) {}

    public function address(CheckoutAddressRequest $req) {
        $cart = $this->resolver->resolve($req);
        $cart->totals = (new TotalsService())->recalculate($cart);
        $cart->save();
        return ApiResponse::ok(['totals'=>$cart->totals]);
    }

    public function shipping(CheckoutShippingRequest $req) {
        $cart = $this->resolver->resolve($req);
        $t = $cart->totals ?? (new TotalsService())->recalculate($cart);
        $t['shipping'] = (float)$req->price;
        $t['grand'] = ($t['subtotal'] ?? 0) + ($t['taxTotal'] ?? 0) + ($t['shipping'] ?? 0) - ($t['discount'] ?? 0);
        $cart->totals = $t; $cart->save();
        return ApiResponse::ok(['totals'=>$t]);
    }

    /**
     * Get shipping options
     * @group Checkout
     * @queryParam country required Example: TR
     */
    public function shippingOptions(ShippingOptionsRequest $req, ShippingService $ship)
    {
        $cart = $this->resolver->resolve($req);
        $t = $cart->totals ?? (new \App\Services\Cart\TotalsService())->recalculate($cart);
        $opts = $ship->options(strtoupper($req->country), (int)($t['grand_minor'] ?? 0));
        return \App\Support\ApiResponse::ok([
            'currency'=>$t['currency'] ?? config('shipping.currency','TRY'),
            'options'=> $opts,
            'totals' => TotalsPresenter::toPublic($t),
        ]);
    }

    public function paymentIntent(PaymentIntentRequest $req) {
        try {
            $cart = $this->resolver->resolve($req);
            $this->inv->reserveFromCart($cart);
            $t = $cart->totals ?? ['grand'=>0,'currency'=>'TRY'];
            $driver = $this->payments->driver($req->input('provider'));
            $pi = $driver->createIntent($t['currency'] ?? 'TRY', (float)($t['grand'] ?? 0), ['cart_id'=>$cart->id]);
            return ApiResponse::ok($pi);
        } catch (ApiException $e) { throw $e; }
        catch (\Throwable $e) { Log::error('payment.intent.error',['e'=>$e]); throw new PaymentFailedException('intent_error'); }
    }

    public function confirm(CheckoutConfirmRequest $req) {
        try {
            $cart = $this->resolver->resolve($req);
            $driver = $this->payments->driver($req->input('provider'));
            $result = $driver->confirm($req->payment_reference);
            if (($result['status'] ?? '') !== 'succeeded') {
                $this->inv->releaseFromCart($cart);
                throw new PaymentFailedException('gateway_failed', ['ref'=>$req->payment_reference]);
            }
            $billing = (array) $req->input('billing', []);
            $shipping = (array) $req->input('shipping', []);
            $order = $this->orders->createFromCart($cart, $billing, $shipping);
            $this->inv->commitFromCart($cart);
            $cart->items()->delete(); $cart->totals=null; $cart->save();
            event(new OrderCreated($order));
            event(new PaymentSucceeded($order, $result['reference'] ?? $req->payment_reference, $result['provider'] ?? ($req->input('provider') ?: 'null')));
            return ApiResponse::ok(['order'=>$order->only(['id','number','status','currency','totals'])], 201);
        } catch (ApiException $e) { throw $e; }
        catch (\Throwable $e) { Log::error('checkout.confirm.error',['e'=>$e]); throw new DomainStateException('checkout_confirm_failed'); }
    }
}
