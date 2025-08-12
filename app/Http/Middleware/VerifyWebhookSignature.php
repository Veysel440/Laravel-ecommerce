<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    public function handle(Request $request, Closure $next, string $provider)
    {
        $raw = $request->getContent();
        if ($provider === 'stripe') {
            $sig = $request->header('Stripe-Signature');
            $secret = config('services.stripe.webhook_secret');
            if (!self::verifyStripe($raw, $sig, $secret)) throw new AccessDeniedHttpException('invalid_signature');
        } elseif ($provider === 'iyzico') {
            $sig = $request->header('X-IYZ-SIGNATURE');
            $secret = config('services.iyzico.webhook_secret');
            if (!hash_equals(hash_hmac('sha256', $raw, $secret), $sig)) throw new AccessDeniedHttpException('invalid_signature');
        }
        return $next($request);
    }
    private static function verifyStripe(string $payload, ?string $header, ?string $secret): bool
    {
        if (!$header || !$secret) return false;

        $parts = collect(explode(',', $header))->mapWithKeys(function($p){
            [$k,$v] = array_pad(explode('=',$p,2),2,null); return [trim($k)=>trim($v)];
        });
        $signed = "t={$parts['t']},{$payload}";
        $calc = hash_hmac('sha256', $signed, $secret);
        return hash_equals($calc, $parts['v1'] ?? '');
    }
}
