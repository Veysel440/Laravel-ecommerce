<?php

namespace App\Http\Controllers\Api\V1\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefundRequest;
use App\Models\Order;
use App\Services\Payment\RefundService;
use App\Support\ApiResponse;
use App\Support\Money;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    public function __construct(private RefundService $svc) { $this->middleware('permission:orders.manage'); }

    public function store(RefundRequest $r, Order $order)
    {
        try {
            $amount_minor = Money::toMinor($r->amount, $order->currency);
            $refund = $this->svc->refund($order, $amount_minor, provider: $r->input('provider'));
            return ApiResponse::ok($refund, 201);
        } catch (\Throwable $e) {
            Log::error('admin.refund.error',['e'=>$e, 'order'=>$order->id]);
            return ApiResponse::fail('refund_failed', 422);
        }
    }
}
