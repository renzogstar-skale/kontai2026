<?php
declare(strict_types=1);

namespace kintai\UI\Controller\Web\System;

use kintai\Core\Controller;

class AdminTeamController extends Controller
{
    public function index()
    {
        $demoData = [
            'kpis' => [
                ['label' => 'Total Team Members', 'value' => '142', 'change' => '+3', 'trend' => 'up', 'color' => 'primary', 'tooltip' => 'Total active external workers in your purview'],
                ['label' => 'Scheduled Today', 'value' => '86', 'change' => '+12', 'trend' => 'up', 'color' => 'info', 'tooltip' => 'Workers scheduled for at least one shift today'],
                ['label' => 'Currently Working', 'value' => '42', 'change' => '+5', 'trend' => 'up', 'color' => 'success', 'tooltip' => 'Workers currently clocked in'],
                ['label' => 'Late Arrivals', 'value' => '4', 'change' => '-2', 'trend' => 'down', 'color' => 'warning', 'tooltip' => 'Workers who arrived late for their shift today'],
                ['label' => 'Absent Today', 'value' => '2', 'change' => '+1', 'trend' => 'up', 'color' => 'danger', 'tooltip' => 'Scheduled workers who have not clocked in'],
                ['label' => 'On Break', 'value' => '8', 'change' => '0', 'trend' => 'neutral', 'color' => 'secondary', 'tooltip' => 'Workers currently on an active break'],
                ['label' => 'Available Workers', 'value' => '32', 'change' => '-4', 'trend' => 'down', 'color' => 'primary', 'tooltip' => 'Off-duty workers available for open shifts'],
                ['label' => 'Pending Invitations', 'value' => '5', 'change' => '+2', 'trend' => 'up', 'color' => 'warning', 'tooltip' => 'Workers invited but have not activated their accounts'],
                ['label' => 'Documents Expiring', 'value' => '12', 'change' => '+12', 'trend' => 'up', 'color' => 'danger', 'tooltip' => 'Workers with compliance documents expiring in 30 days'],
                ['label' => 'Training Overdue', 'value' => '7', 'change' => '-3', 'trend' => 'down', 'color' => 'warning', 'tooltip' => 'Workers who have missed required training deadlines'],
            ],
            'attentionQueue' => [
                ['employee' => 'Sarah Connor', 'issue' => 'Missing clock-in', 'severity' => 'Critical', 'location' => 'Store 101', 'time' => '08:00 AM', 'manager' => 'John Smith', 'action' => 'Contact Worker'],
                ['employee' => 'Kyle Reese', 'issue' => 'Overtime risk', 'severity' => 'High', 'location' => 'Warehouse B', 'time' => 'End of week', 'manager' => 'John Smith', 'action' => 'Review Schedule'],
                ['employee' => 'Miles Dyson', 'issue' => 'Expired document', 'severity' => 'Medium', 'location' => 'HQ', 'time' => 'Yesterday', 'manager' => 'Jane Doe', 'action' => 'Request Update'],
                ['employee' => 'T-800', 'issue' => 'Late arrival', 'severity' => 'Medium', 'location' => 'Store 102', 'time' => '09:15 AM', 'manager' => 'John Smith', 'action' => 'Acknowledge'],
            ],
            'employees' => [
                ['id' => 1001, 'name' => 'Sarah Connor', 'preferred' => 'Sarah', 'email' => 'sarah@demo.com', 'title' => 'Stock Clerk', 'role' => 'Worker', 'client' => 'SuperMart', 'location' => 'Store 101', 'supervisor' => 'John Smith', 'shift' => '08:00 - 16:00', 'attendance' => 'Absent', 'task' => 'Inventory Count', 'progress' => 0, 'docs_status' => 'Valid', 'training_status' => 'Up to date', 'last_active' => 'Yesterday', 'status' => 'Scheduled'],
                ['id' => 1002, 'name' => 'Kyle Reese', 'preferred' => 'Kyle', 'email' => 'kyle@demo.com', 'title' => 'Security Guard', 'role' => 'Team Lead', 'client' => 'Logistics Co', 'location' => 'Warehouse B', 'supervisor' => 'John Smith', 'shift' => '07:00 - 15:00', 'attendance' => 'On Time', 'task' => 'Patrol Route A', 'progress' => 75, 'docs_status' => 'Valid', 'training_status' => 'Overdue', 'last_active' => '10 mins ago', 'status' => 'Working'],
                ['id' => 1003, 'name' => 'Miles Dyson', 'preferred' => 'Miles', 'email' => 'miles@demo.com', 'title' => 'IT Support Tech', 'role' => 'Worker', 'client' => 'TechCorp', 'location' => 'HQ', 'supervisor' => 'Jane Doe', 'shift' => 'Off', 'attendance' => 'N/A', 'task' => 'N/A', 'progress' => 0, 'docs_status' => 'Expired', 'training_status' => 'Valid', 'last_active' => '2 days ago', 'status' => 'Available'],
                ['id' => 1004, 'name' => 'John Smith', 'preferred' => 'John', 'email' => 'john@demo.com', 'title' => 'Operations Manager', 'role' => 'Supervisor', 'client' => 'SuperMart', 'location' => 'Store 101', 'supervisor' => 'Unassigned', 'shift' => '09:00 - 17:00', 'attendance' => 'Late', 'task' => 'Team Review', 'progress' => 100, 'docs_status' => 'Valid', 'training_status' => 'Valid', 'last_active' => '5 mins ago', 'status' => 'Working'],
                ['id' => 1005, 'name' => 'Jane Doe', 'preferred' => 'Jane', 'email' => 'jane@demo.com', 'title' => 'HR Administrator', 'role' => 'HR Admin', 'client' => 'Internal', 'location' => 'HQ', 'supervisor' => 'Unassigned', 'shift' => '08:30 - 16:30', 'attendance' => 'On Time', 'task' => 'Payroll', 'progress' => 40, 'docs_status' => 'Valid', 'training_status' => 'Valid', 'last_active' => '1 hour ago', 'status' => 'Working'],
            ]
        ];

        return $this->render('admin/team/index.php', [
            'title' => 'Team',
            'demoData' => $demoData,
            'showAdminMenu' => true,
        ]);
    }

    public function profile(int $id)
    {
        // Extensive demo data representing the 15 tabs required
        $demoData = [
            'profile' => [
                'id' => $id,
                'name' => 'Sarah Connor',
                'preferred' => 'Sarah',
                'email' => 'sarah@demo.com',
                'phone' => '+1 555-0198',
                'title' => 'Stock Clerk',
                'role' => 'Worker',
                'status' => 'Scheduled',
                'location' => 'Store 101',
                'supervisor' => 'John Smith',
                'shift' => '08:00 - 16:00 (Today)',
                'last_active' => 'Yesterday 17:05',
                'hire_date' => '2025-01-15'
            ],
            'overview' => [
                'weekly_hours' => 32.5,
                'attendance_summary' => '94% On Time',
                'task_completion' => '88%',
                'skills' => ['Forklift', 'Inventory Management', 'First Aid'],
                'compliance' => ['Forklift Cert Expiring in 14 days'],
                'recent_activity' => [
                    ['time' => 'Yesterday 17:05', 'event' => 'Clocked out'],
                    ['time' => 'Yesterday 13:00', 'event' => 'Completed Task: Aisle 4 Reset'],
                ]
            ],
            'schedule' => [
                'published' => [
                    ['date' => '2026-09-15', 'time' => '08:00 - 16:00', 'location' => 'Store 101', 'role' => 'Stock Clerk'],
                    ['date' => '2026-09-16', 'time' => '08:00 - 16:00', 'location' => 'Store 101', 'role' => 'Stock Clerk'],
                    ['date' => '2026-09-17', 'time' => '10:00 - 18:00', 'location' => 'Store 102', 'role' => 'Inventory Specialist'],
                ]
            ],
            'attendance' => [
                'history' => [
                    ['date' => '2026-09-14', 'in' => '07:55 AM', 'out' => '17:05 PM', 'status' => 'Valid', 'hours' => '8.0'],
                    ['date' => '2026-09-13', 'in' => '08:15 AM', 'out' => '16:00 PM', 'status' => 'Late', 'hours' => '7.75'],
                ]
            ],
            'tasks' => [
                'active' => [
                    ['id' => 'TSK-940', 'title' => 'Inventory Count Aisle 4', 'priority' => 'High', 'due' => '2026-09-15 12:00', 'status' => 'Pending']
                ],
                'completed' => [
                    ['id' => 'TSK-938', 'title' => 'Restock Beverages', 'priority' => 'Medium', 'due' => '2026-09-14 16:00', 'status' => 'Completed']
                ]
            ],
            'performance' => [
                'metrics' => [
                    ['label' => 'Attendance Rate', 'value' => '94%', 'trend' => 'up'],
                    ['label' => 'On-Time Arrival', 'value' => '88%', 'trend' => 'down'],
                    ['label' => 'Task Completion', 'value' => '96%', 'trend' => 'up'],
                    ['label' => 'Schedule Adherence', 'value' => '98%', 'trend' => 'up'],
                ]
            ],
            'requests' => [
                ['id' => 'REQ-44', 'type' => 'Time Off', 'dates' => 'Oct 1 - Oct 5', 'status' => 'Pending', 'submitted' => '2026-09-10'],
                ['id' => 'REQ-42', 'type' => 'Punch Correction', 'dates' => 'Sep 13', 'status' => 'Approved', 'submitted' => '2026-09-14'],
            ],
            'incidents' => [
                ['id' => 'INC-12', 'category' => 'Safety', 'severity' => 'Low', 'date' => '2026-08-22', 'status' => 'Resolved']
            ],
            'training' => [
                ['course' => 'Safety Protocol 101', 'assigned' => '2026-01-15', 'status' => 'Completed', 'due' => '2026-02-15'],
                ['course' => 'Forklift Recertification', 'assigned' => '2026-09-01', 'status' => 'Overdue', 'due' => '2026-09-14'],
            ],
            'documents' => [
                ['name' => 'W-4 Form', 'type' => 'Employment', 'uploaded' => '2025-01-15', 'status' => 'Verified'],
                ['name' => 'OSHA Certification', 'type' => 'Safety', 'uploaded' => '2025-02-01', 'status' => 'Expiring Soon'],
            ],
            'equipment' => [
                ['asset' => 'Scanner-044', 'assigned' => '2026-05-10', 'condition' => 'Good', 'status' => 'Active']
            ],
            'communications' => [
                ['date' => '2026-09-14 09:00', 'type' => 'Direct Message', 'subject' => 'Schedule Update', 'status' => 'Read'],
                ['date' => '2026-09-15 08:30', 'type' => 'System Alert', 'subject' => 'Late Arrival Warning', 'status' => 'Delivered'],
            ],
            'notes' => [
                ['date' => '2026-06-01', 'author' => 'John Smith', 'category' => 'General', 'content' => 'Great performance during the summer rush. Recommended for Team Lead training.']
            ],
            'access' => [
                'status' => 'Active',
                'roles' => ['Worker'],
                'last_login' => '2026-09-14 17:15',
                'mfa' => 'Enabled',
                'scope' => ['Store 101', 'Store 102']
            ],
            'audit' => [
                ['date' => '2026-09-13 14:22', 'admin' => 'Jane Doe', 'action' => 'Assigned Shift', 'module' => 'Scheduling'],
                ['date' => '2026-09-01 09:00', 'admin' => 'System', 'action' => 'Flagged Training Overdue', 'module' => 'Compliance'],
            ]
        ];

        return $this->render('admin/team/profile.php', [
            'title' => 'Employee Profile Workspace',
            'demoData' => $demoData,
            'showAdminMenu' => true,
        ]);
    }
}

