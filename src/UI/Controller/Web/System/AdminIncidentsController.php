<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminIncidentsController extends Controller
{
    public function index()
    {
        $demoData = [
            'incidents' => [
                ['id' => 'INC-001', 'category' => 'Safety', 'severity' => 'High', 'location' => 'Store 101', 'status' => 'Open', 'date' => '2026-09-15'],
                ['id' => 'INC-002', 'category' => 'Attendance', 'severity' => 'Low', 'location' => 'Warehouse A', 'status' => 'Resolved', 'date' => '2026-09-14'],
                ['id' => 'INC-003', 'category' => 'Property Damage', 'severity' => 'Medium', 'location' => 'Store 102', 'status' => 'Investigating', 'date' => '2026-09-15'],
            ]
        ];
        
        return $this->render('admin/incidents/index.php', [
            'title' => 'Incidents',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

