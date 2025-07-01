<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Audit;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class AuditTest extends TestCase
{
    public function test_audit_is_instance_of_base_audit()
    {
        $audit = new Audit();
        $this->assertInstanceOf(BaseAudit::class, $audit);
    }
} 