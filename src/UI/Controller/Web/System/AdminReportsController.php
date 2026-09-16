<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminReportsController extends Controller
{
    public function index()
    {
        $demoData = [
            'reports' => [
                ['name' => 'Attendance Compliance', 'category' => 'Attendance', 'last_run' => '2026-09-15'],
                ['name' => 'Labor Cost Estimate', 'category' => 'Payroll', 'last_run' => '2026-09-14'],
                ['name' => 'Task Completion by Location', 'category' => 'Operations', 'last_run' => '2026-09-15'],
            ]
        ];
        
        return $this->render('admin/reports/index.php', [
            'title' => 'Reports & Analytics',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
