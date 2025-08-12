<?php

namespace App\Events;

use App\Models\Sku;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockBelowThreshold
{
    use Dispatchable, SerializesModels;
    public function __construct(public Sku $sku, public int $available, public int $threshold) {}
}
