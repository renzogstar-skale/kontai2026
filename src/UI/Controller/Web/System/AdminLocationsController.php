<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminLocationsController extends Controller
{
    public function index()
    {
        $demoData = [
            'locations' => [
                ['id' => 'LOC-1', 'name' => 'Store 101', 'client' => 'SuperMart Inc', 'staffing' => 'Optimal', 'status' => 'Active'],
                ['id' => 'LOC-2', 'name' => 'Warehouse A', 'client' => 'Logistics Corp', 'staffing' => 'Understaffed', 'status' => 'Active'],
                ['id' => 'LOC-3', 'name' => 'Store 102', 'client' => 'SuperMart Inc', 'staffing' => 'Optimal', 'status' => 'Active'],
            ]
        ];
        
        return $this->render('admin/locations/index.php', [
            'title' => 'Locations',
            'demoData' => $demoData,
            'showAdminMenu' => true
        ]);
    }
}
