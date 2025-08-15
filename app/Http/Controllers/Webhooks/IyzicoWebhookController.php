<?php

namespace App\Http\Controllers\Webhooks;


use App\Events\OrderCreated;
use App\Events\PaymentSucceeded;
use App\Models\Order;
use App\Models\Payment;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IyzicoWebhookController
{
    public function __invoke(Request $r)
    {
        $event = (string) $r->input('event');
        $payload = $r->all();
        try {
            if ($event === 'payment_succeeded') {
                $orderId = (int) data_get($payload,'order_id');
                $order = Order::findOrFail($orderId);
                $ref = (string) data_get($payload,'payment_id','iyz_unknown');
                Payment::firstOrCreate(['order_id'=>$order->id,'reference'=>$ref], [
                    'provider'=>'iyzico','status'=>'captured','amount_minor'=>(int) data_get($payload,'amount_minor',0),'currency'=>strtoupper((string) data_get($payload,'currency','TRY')),'raw_response'=>$payload
                ]);
                if (!in_array($order->status,['paid','shipped','completed'])) {
                    $order->update(['status'=>'paid']); event(new OrderCreated($order));
                }
                event(new PaymentSucceeded($order, $ref,'iyzico'));
            }
            if ($event === 'refund_succeeded') {
                $orderId = (int) data_get($payload,'order_id');
                $order = Order::findOrFail($orderId);
                $order->update(['status'=>'refunded']);
                Payment::where('order_id',$order->id)->latest()->first()?->update(['status'=>'refunded']);
            }
            return response()->json(['received'=>true]);
        } catch (\Throwable $e) {
            Log::error('iyzico.webhook.error',['e'=>$e,'payload'=>$payload]);
            return ApiResponse::fail('webhook_error', 400);
        }
    }
}
