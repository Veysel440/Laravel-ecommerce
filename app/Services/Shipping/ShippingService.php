<?php

namespace App\Services\Shipping;


class ShippingService
{
    public function options(string $country, int $cartGrandMinor): array
    {
        $cfg = config('shipping');
        $mult = data_get($cfg, "zones.$country.multiplier", 1.5);
        $free = (int) $cfg['free_threshold_minor'];

        return collect($cfg['carriers'])->map(function($c) use($mult,$cartGrandMinor,$free){
            $price = (int) round($c['price_minor'] * $mult);
            if ($cartGrandMinor >= $free) $price = 0;
            return [
                'id'=>$c['id'],
                'name'=>$c['name'],
                'price_minor'=>$price,
                'eta_days'=>$c['eta_days'],
            ];
        })->values()->all();
    }
}
