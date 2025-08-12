<?php

namespace App\Listeners;


use App\Models\AuditLog;

class WriteAuditLog
{
    public function handle(object $event): void
    {
        $actor = auth()->id();
        $type  = get_class($event);
        $payload = [];

        if (property_exists($event, 'order')) { $payload['order_id'] = $event->order->id; }
        if (property_exists($event, 'reference')) { $payload['reference'] = $event->reference; }
        if (property_exists($event, 'code')) { $payload['coupon'] = $event->code; }

        AuditLog::create([
            'actor_id' => $actor,
            'action'   => $type,
            'subject_type' => $type,
            'subject_id'   => 0,
            'payload'  => $payload,
        ]);
    }
}
