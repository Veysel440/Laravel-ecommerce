<?php

namespace App\Support;

final class TotalsPresenter {
    public static function toPublic(array $t): array {
        $ccy = $t['currency'] ?? 'TRY';
        $map = fn($k)=> isset($t[$k]) ? Money::fromMinor((int)$t[$k], $ccy) : null;
        return [
            'currency'=>$ccy,
            'subtotal'=>$map('subtotal_minor'),
            'tax'=>$map('tax_minor'),
            'discount'=>$map('discount_minor'),
            'shipping'=>$map('shipping_minor'),
            'grand'=>$map('grand_minor'),
        ];
    }
}
