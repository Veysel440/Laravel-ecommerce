<?php

namespace App\Http\Controllers\Webhooks;


use App\Events\OrderCreated;
use App\Events\PaymentSucceeded;
use App\Models\Order;
use App\Models\Payment;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController
{
    public function __invoke(Request $r)
    {
        $type = (string) $r->input('type');
        $data = (array) $r->input('data.object', []);
        try {
            if ($type === 'payment_intent.succeeded') {
                $orderId = (int) data_get($data,'metadata.order_id');
                $order = Order::findOrFail($orderId);
                $ref = (string) ($data['id'] ?? 'pi_unknown');
                Payment::firstOrCreate(['order_id'=>$order->id,'reference'=>$ref], [
                    'provider'=>'stripe','status'=>'captured','amount_minor'=>(int)data_get($data,'amount_received',0),'currency'=>strtoupper((string) data_get($data,'currency','TRY')),'raw_response'=>$data
                ]);
                if (!in_array($order->status,['paid','shipped','completed'])) {
                    $order->update(['status'=>'paid']);
                    event(new OrderCreated($order));
                }
                event(new PaymentSucceeded($order, $ref,'stripe'));
            }
            if (in_array($type, ['charge.refunded','refund.succeeded'])) {
                $orderId = (int) data_get($data,'metadata.order_id');
                $order = Order::findOrFail($orderId);
                $ref = (string) ($data['id'] ?? 're_unknown');

                $order->update(['status'=>'refunded']);
                Payment::where('order_id',$order->id)->latest()->first()?->update(['status'=>'refunded']);
            }
            return response()->json(['received'=>true]);
        } catch (\Throwable $e) {
            Log::error('stripe.webhook.error',['e'=>$e,'payload'=>$r->all()]);
            return ApiResponse::fail('webhook_error', 400);
        }
    }
}
