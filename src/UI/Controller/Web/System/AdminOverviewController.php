<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminOverviewController extends Controller
{
    public function index()
    {
        $demoData = [
            'kpis' => [
                ['label' => 'Scheduled Today', 'value' => '142', 'trend' => 'up', 'color' => 'primary'],
                ['label' => 'Clocked In', 'value' => '128', 'trend' => 'up', 'color' => 'success'],
                ['label' => 'Late Arrivals', 'value' => '4', 'trend' => 'down', 'color' => 'warning'],
                ['label' => 'Absent', 'value' => '2', 'trend' => 'up', 'color' => 'danger'],
                ['label' => 'Open Shifts', 'value' => '12', 'trend' => 'down', 'color' => 'primary'],
                ['label' => 'Open Incidents', 'value' => '3', 'trend' => 'up', 'color' => 'danger'],
            ],
            'alerts' => [
                ['type' => 'danger', 'message' => 'Store 12 has 2 uncovered shifts for today.'],
                ['type' => 'warning', 'message' => '3 workers are approaching overtime limits.'],
                ['type' => 'info', 'message' => 'Task completion rate is at 94% across all regions.']
            ]
        ];
        
        return $this->render('admin/overview/index.php', [
            'title' => 'Operational Overview',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
