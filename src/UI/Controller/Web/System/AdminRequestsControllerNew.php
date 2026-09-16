<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminRequestsControllerNew extends Controller
{
    public function index()
    {
        $demoData = [
            'requests' => [
                ['id' => 'REQ-01', 'type' => 'Time Off', 'worker' => 'Alice Johnson', 'date' => '2026-09-20', 'status' => 'Pending'],
                ['id' => 'REQ-02', 'type' => 'Shift Swap', 'worker' => 'Bob Smith', 'date' => '2026-09-18', 'status' => 'Approved'],
                ['id' => 'REQ-03', 'type' => 'Punch Correction', 'worker' => 'Charlie Davis', 'date' => '2026-09-14', 'status' => 'Pending'],
            ]
        ];
        
        return $this->render('admin/requests/index.php', [
            'title' => 'Requests & Approvals',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
