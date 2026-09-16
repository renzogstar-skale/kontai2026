<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminLiveOpsController extends Controller
{
    public function index()
    {
        $demoData = [
            'active_workforce' => [
                ['name' => 'Alice Johnson', 'role' => 'Merchandiser', 'location' => 'Store 101', 'status' => 'clocked_in', 'time' => '08:00 AM'],
                ['name' => 'Bob Smith', 'role' => 'Stock Clerk', 'location' => 'Warehouse A', 'status' => 'late', 'time' => 'Expected 08:30 AM'],
                ['name' => 'Charlie Davis', 'role' => 'Supervisor', 'location' => 'Store 102', 'status' => 'on_break', 'time' => '12:00 PM'],
            ]
        ];
        
        return $this->render('admin/live_ops/index.php', [
            'title' => 'Live Operations',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

