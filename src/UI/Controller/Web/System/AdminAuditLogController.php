<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminAuditLogController extends Controller
{
    public function index()
    {
        $demoData = [
            'logs' => [
                ['timestamp' => '2026-09-15 15:32', 'actor' => 'Admin User', 'action' => 'Updated Shift', 'module' => 'Scheduling', 'result' => 'Success'],
                ['timestamp' => '2026-09-15 14:15', 'actor' => 'System', 'action' => 'Auto-clock out', 'module' => 'Time & Attendance', 'result' => 'Success'],
                ['timestamp' => '2026-09-15 09:00', 'actor' => 'Manager A', 'action' => 'Created Location', 'module' => 'Locations', 'result' => 'Success'],
            ]
        ];
        
        return $this->render('admin/audit_log/index.php', [
            'title' => 'Audit Log',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

