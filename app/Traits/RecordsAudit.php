<?php

namespace App\Traits;

trait RecordsAudit {
    protected function audit(string $action, $subject, array $payload=[]): void {
        \App\Models\AuditLog::create([
            'actor_id'=>auth()->id(),
            'action'=>$action,
            'subject_type'=>get_class($subject),
            'subject_id'=>$subject->getKey(),
            'payload'=>$payload,
        ]);
    }
}
