<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed
{
    use Dispatchable, SerializesModels;
    public function __construct(public int $cartId, public string $reference, public string $reason) {}
}
