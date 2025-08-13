<?php

namespace App\Support;


final class Money {
    public static function decimals(string $ccy): int {
        return match (strtoupper($ccy)) {
            'JPY' => 0, default => 2
        };
    }
    public static function toMinor(float|int|string $amount, string $ccy='TRY'): int {
        $d = self::decimals($ccy);
        return (int) round(((float)$amount) * (10 ** $d));
    }
    public static function fromMinor(int $minor, string $ccy='TRY'): string {
        $d = self::decimals($ccy);
        $v = $minor / (10 ** $d);
        return number_format($v, $d, '.', '');
    }
}
