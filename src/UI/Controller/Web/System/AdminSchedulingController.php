<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminSchedulingController extends Controller
{
    public function index()
    {
        $demoData = [
            'shifts' => [
                ['date' => '2026-09-15', 'worker' => 'Alice Johnson', 'location' => 'Store 101', 'time' => '08:00-16:00', 'status' => 'Published'],
                ['date' => '2026-09-15', 'worker' => 'Unassigned', 'location' => 'Store 102', 'time' => '09:00-17:00', 'status' => 'Open'],
            ]
        ];
        
        return $this->render('admin/scheduling/index.php', [
            'title' => 'Scheduling',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
