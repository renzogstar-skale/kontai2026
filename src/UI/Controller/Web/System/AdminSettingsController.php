<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $demoData = [
            'sections' => [
                'Organization Profile',
                'Clients and Locations',
                'Roles and Permissions',
                'Attendance Rules',
                'Scheduling Rules',
                'Security',
            ]
        ];
        
        return $this->render('admin/settings/index.php', [
            'title' => 'Settings',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

