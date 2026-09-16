<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminTimeAttendanceController extends Controller
{
    public function index()
    {
        $demoData = [
            'punches' => [
                ['worker' => 'Alice Johnson', 'location' => 'Store 101', 'type' => 'Clock In', 'time' => '07:58 AM', 'status' => 'Valid'],
                ['worker' => 'Bob Smith', 'location' => 'Warehouse A', 'type' => 'Clock In', 'time' => '08:45 AM', 'status' => 'Late'],
                ['worker' => 'Charlie Davis', 'location' => 'Store 102', 'type' => 'Break Start', 'time' => '12:00 PM', 'status' => 'Valid'],
            ]
        ];
        
        return $this->render('admin/time_attendance/index.php', [
            'title' => 'Time & Attendance',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

