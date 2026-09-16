<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminCommunicationsController extends Controller
{
    public function index()
    {
        $demoData = [
            'messages' => [
                ['id' => 'MSG-01', 'sender' => 'HR Team', 'subject' => 'Policy Update: Overtime', 'date' => '2026-09-15 09:00 AM', 'status' => 'Sent'],
                ['id' => 'MSG-02', 'sender' => 'Alice Johnson', 'subject' => 'Question about schedule', 'date' => '2026-09-15 10:15 AM', 'status' => 'Unread'],
            ]
        ];
        
        return $this->render('admin/communications/index.php', [
            'title' => 'Communications',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
