<?php

namespace App\Exceptions;

use Exception;

abstract class ApiException extends Exception
{
    public function __construct(string $message, public int $status=400, public array $meta=[])
    { parent::__construct($message, $this->status); }
}

class InsufficientStockException extends ApiException
{ public function __construct(array $meta=[])

{
    parent::__construct('insufficient_stock', 422, $meta); }
}

class CouponException extends ApiException
{
    public function __construct(string $reason, array $meta=[]) { parent::__construct($reason, 422, $meta); }
}

class PaymentFailedException extends ApiException
{
    public function __construct(string $reason='payment_failed', array $meta=[]) { parent::__construct($reason, 422, $meta); }
}

class DomainStateException extends ApiException
{
    public function __construct(string $reason='invalid_state', array $meta=[]) { parent::__construct($reason, 409, $meta); }
}
