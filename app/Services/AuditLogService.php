<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogService
{
    public static function log(
        string $action,
        string $module,
        string $description,
        ?int $referenceId = null,
        ?string $referenceNo = null,
        ?array $details = null
    ): void {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'action'       => $action,
            'module'       => $module,
            'description'  => $description,
            'details'      => $details,
            'reference_id' => $referenceId,
            'reference_no' => $referenceNo,
            'ip_address'   => request()->ip(),
        ]);
    }
}