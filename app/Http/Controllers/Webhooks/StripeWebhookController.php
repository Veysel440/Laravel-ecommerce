<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $r)
    {
        $event = $r->input('type');
        if ($event === 'payment_intent.succeeded') {
            // TODO: order no ile eşleştir, PaymentSucceeded event’i tetikle
        }
        return response()->json(['received'=>true]);
    }
}
