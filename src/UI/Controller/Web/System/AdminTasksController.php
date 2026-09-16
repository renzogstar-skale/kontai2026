<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminTasksController extends Controller
{
    public function index()
    {
        $demoData = [
            'tasks' => [
                ['id' => 'TSK-101', 'title' => 'Stock shelves in Aisle 4', 'worker' => 'Alice Johnson', 'location' => 'Store 101', 'status' => 'In Progress'],
                ['id' => 'TSK-102', 'title' => 'Verify planogram placement', 'worker' => 'Bob Smith', 'location' => 'Warehouse A', 'status' => 'Not Started'],
                ['id' => 'TSK-103', 'title' => 'Clean assigned work areas', 'worker' => 'Charlie Davis', 'location' => 'Store 102', 'status' => 'Completed'],
            ]
        ];
        
        return $this->render('admin/tasks/index.php', [
            'title' => 'Tasks & Field Work',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}

