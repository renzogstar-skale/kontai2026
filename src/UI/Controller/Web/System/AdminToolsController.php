<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminToolsController extends Controller
{
    public function index()
    {
        $demoData = [
            'tools' => [
                ['name' => 'Bulk Employee Import', 'description' => 'Import employees via CSV', 'status' => 'Ready'],
                ['name' => 'Data Export', 'description' => 'Export full system backup', 'status' => 'Ready'],
                ['name' => 'Diagnostics', 'description' => 'System health and connections', 'status' => 'Ready'],
            ]
        ];
        
        return $this->render('admin/tools/index.php', [
            'title' => 'Tools & Operations',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
