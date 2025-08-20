<?php

namespace App\Support;

final class FileName
{
    public static function sanitize(string $name): string
    {
        $name = preg_replace('/[^\p{L}\p{N}\._-]+/u', '-', $name) ?: 'file';
        $name = trim($name, '-_.');
        return mb_strimwidth($name, 0, 120, '', 'UTF-8');
    }
}
