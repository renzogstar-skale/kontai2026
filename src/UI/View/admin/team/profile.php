<?php
/** @var string $title */
/** @var array $demoData */
$emp = $demoData['profile'];
?>
<!-- Persistent Profile Header -->
<div class="card mb-sm" style="padding: 24px; border-top: 4px solid var(--color-primary);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div style="display: flex; gap: 24px; align-items: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 32px;">
                <?= substr($emp['preferred'], 0, 1) ?>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 24px; color: var(--color-text);"><?= htmlspecialchars($emp['name']) ?></h2>
                <div style="display: flex; gap: 16px; margin-top: 8px; color: var(--color-text-muted); font-size: 14px;">
                    <span>ID: #<?= $emp['id'] ?></span>
                    <span><?= htmlspecialchars($emp['title']) ?> (<?= htmlspecialchars($emp['role']) ?>)</span>
                    <span><?= htmlspecialchars($emp['location']) ?></span>
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <span class="badge badge--success"><?= htmlspecialchars($emp['status']) ?></span>
            <button class="btn btn--primary btn--sm">Message</button>
            <button class="btn btn--ghost btn--sm">Edit Profile</button>
            <div class="dropdown">
                <button class="btn btn--ghost btn--sm">More Actions ▾</button>
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 32px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--color-border); font-size: 13px;">
        <div>
            <div class="text-sm-muted">Today's Shift</div>
            <div style="font-weight: 500;"><?= htmlspecialchars($emp['shift']) ?></div>
        </div>
        <div>
            <div class="text-sm-muted">Supervisor</div>
            <div style="font-weight: 500;"><?= htmlspecialchars($emp['supervisor']) ?></div>
        </div>
        <div>
            <div class="text-sm-muted">Contact</div>
            <div style="font-weight: 500;"><?= htmlspecialchars($emp['email']) ?> | <?= htmlspecialchars($emp['phone']) ?></div>
        </div>
        <div>
            <div class="text-sm-muted">Last Active</div>
            <div style="font-weight: 500;"><?= htmlspecialchars($emp['last_active']) ?></div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="card mb-sm">
    <div style="display: flex; overflow-x: auto; border-bottom: 1px solid var(--color-border); padding: 0 16px;" id="profile-tabs">
        <?php 
        $tabs = ['Overview', 'Schedule', 'Attendance', 'Tasks', 'Performance', 'Availability', 'Requests', 'Incidents', 'Training', 'Documents', 'Equipment', 'Communications', 'Notes', 'Access', 'Audit History'];
        foreach ($tabs as $index => $tab): ?>
            <button class="btn btn--ghost" style="border-radius: 0; padding: 16px 12px; font-weight: <?= $index === 0 ? '600' : '400' ?>; color: var(--color-<?= $index === 0 ? 'primary' : 'text-muted' ?>); border-bottom: 2px solid <?= $index === 0 ? 'var(--color-primary)' : 'transparent' ?>;" onclick="switchTab(this, 'tab-<?= $index ?>')"><?= $tab ?></button>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tabs Content Area -->
<div id="tab-contents">
    
    <!-- Tab 0: Overview -->
    <div id="tab-0" class="tab-content" style="display: block;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="card" style="padding: 16px;">
                <h3 style="margin-top: 0;">Performance & Compliance</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <div class="text-sm-muted">Attendance Summary</div>
                        <div style="font-size: 20px; font-weight: 600; color: var(--color-success);"><?= $demoData['overview']['attendance_summary'] ?></div>
                    </div>
                    <div>
                        <div class="text-sm-muted">Task Completion</div>
                        <div style="font-size: 20px; font-weight: 600; color: var(--color-primary);"><?= $demoData['overview']['task_completion'] ?></div>
                    </div>
                </div>
                <div class="text-sm-muted mb-xs">Skills</div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <?php foreach ($demoData['overview']['skills'] as $skill): ?>
                        <span class="badge badge--secondary"><?= htmlspecialchars($skill) ?></span>
                    <?php endforeach; ?>
                </div>
                
                <?php if(!empty($demoData['overview']['compliance'])): ?>
                <div style="margin-top: 16px; padding: 12px; background: var(--color-warning-light); border-left: 3px solid var(--color-warning); border-radius: 4px;">
                    <strong>Compliance Warning:</strong> <?= htmlspecialchars($demoData['overview']['compliance'][0]) ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="card" style="padding: 16px;">
                <h3 style="margin-top: 0;">Recent Activity</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php foreach ($demoData['overview']['recent_activity'] as $act): ?>
                        <div style="display: flex; gap: 12px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">
                            <div class="text-sm-muted" style="width: 120px;"><?= htmlspecialchars($act['time']) ?></div>
                            <div><?= htmlspecialchars($act['event']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn--ghost btn--sm mt-sm">View Full History</button>
            </div>
        </div>
    </div>

    <!-- Tab 1: Schedule -->
    <div id="tab-1" class="tab-content card" style="display: none;">
        <div class="card-header" style="display: flex; justify-content: space-between;">
            <h3 style="margin: 0;">Upcoming Shifts</h3>
            <button class="btn btn--primary btn--sm">Add/Edit Shift</button>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Time</th><th>Location</th><th>Role</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['schedule']['published'] as $shift): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($shift['date']) ?></strong></td>
                            <td><?= htmlspecialchars($shift['time']) ?></td>
                            <td><?= htmlspecialchars($shift['location']) ?></td>
                            <td><?= htmlspecialchars($shift['role']) ?></td>
                            <td><button class="btn btn--ghost btn--xs">Find Replacement</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 2: Attendance -->
    <div id="tab-2" class="tab-content card" style="display: none;">
        <div class="card-header" style="display: flex; justify-content: space-between;">
            <h3 style="margin: 0;">Recent Timesheets</h3>
            <button class="btn btn--primary btn--sm">Correct Punch</button>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Clock In</th><th>Clock Out</th><th>Hours</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['attendance']['history'] as $att): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($att['date']) ?></strong></td>
                            <td><?= htmlspecialchars($att['in']) ?></td>
                            <td><?= htmlspecialchars($att['out']) ?></td>
                            <td><?= htmlspecialchars($att['hours']) ?> hrs</td>
                            <td>
                                <?php if ($att['status'] === 'Valid'): ?>
                                    <span class="badge badge--success">Valid</span>
                                <?php else: ?>
                                    <span class="badge badge--warning"><?= htmlspecialchars($att['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><button class="btn btn--ghost btn--xs">Edit</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 3: Tasks -->
    <div id="tab-3" class="tab-content card" style="display: none;">
        <div class="card-header" style="display: flex; justify-content: space-between;">
            <h3 style="margin: 0;">Assigned Tasks</h3>
            <button class="btn btn--primary btn--sm">Assign Task</button>
        </div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Title</th><th>Priority</th><th>Due Date</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['tasks']['active'] as $task): ?>
                        <tr>
                            <td class="text-sm-muted"><?= htmlspecialchars($task['id']) ?></td>
                            <td><strong><?= htmlspecialchars($task['title']) ?></strong></td>
                            <td><span class="badge badge--danger"><?= htmlspecialchars($task['priority']) ?></span></td>
                            <td><?= htmlspecialchars($task['due']) ?></td>
                            <td><span class="badge badge--warning"><?= htmlspecialchars($task['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 4: Performance -->
    <div id="tab-4" class="tab-content card" style="display: none; padding: 16px;">
        <h3 style="margin-top: 0; margin-bottom: 16px;">Key Metrics (Last 30 Days)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <?php foreach ($demoData['performance']['metrics'] as $metric): ?>
                <div style="padding: 16px; border: 1px solid var(--color-border); border-radius: 6px;">
                    <div class="text-sm-muted" style="margin-bottom: 8px;"><?= htmlspecialchars($metric['label']) ?></div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 24px; font-weight: bold;"><?= htmlspecialchars($metric['value']) ?></span>
                        <span style="color: var(--color-<?= $metric['trend'] === 'up' ? 'success' : 'danger' ?>);"><?= $metric['trend'] === 'up' ? '▲' : '▼' ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tab 5: Availability -->
    <div id="tab-5" class="tab-content card" style="display: none; padding: 16px;">
        <h3 style="margin-top: 0; margin-bottom: 16px;">Weekly Availability</h3>
        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;">
            <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day): ?>
                <div style="border: 1px solid var(--color-border); padding: 12px; text-align: center; border-radius: 4px;">
                    <strong style="display: block; margin-bottom: 8px;"><?= $day ?></strong>
                    <?php if (in_array($day, ['Sat', 'Sun'])): ?>
                        <span class="badge badge--secondary">Unavailable</span>
                    <?php else: ?>
                        <span class="badge badge--success">08:00 - 18:00</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tab 6: Requests -->
    <div id="tab-6" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Type</th><th>Dates/Details</th><th>Submitted</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['requests'] as $req): ?>
                        <tr>
                            <td class="text-sm-muted"><?= htmlspecialchars($req['id']) ?></td>
                            <td><strong><?= htmlspecialchars($req['type']) ?></strong></td>
                            <td><?= htmlspecialchars($req['dates']) ?></td>
                            <td><?= htmlspecialchars($req['submitted']) ?></td>
                            <td>
                                <?php if ($req['status'] === 'Pending'): ?>
                                    <span class="badge badge--warning">Pending</span>
                                <?php else: ?>
                                    <span class="badge badge--success">Approved</span>
                                <?php endif; ?>
                            </td>
                            <td><button class="btn btn--ghost btn--xs">View</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 7: Incidents -->
    <div id="tab-7" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Category</th><th>Severity</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['incidents'] as $inc): ?>
                        <tr>
                            <td class="text-sm-muted"><?= htmlspecialchars($inc['id']) ?></td>
                            <td><strong><?= htmlspecialchars($inc['category']) ?></strong></td>
                            <td><span class="badge badge--info"><?= htmlspecialchars($inc['severity']) ?></span></td>
                            <td><?= htmlspecialchars($inc['date']) ?></td>
                            <td><span class="badge badge--success"><?= htmlspecialchars($inc['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 8: Training -->
    <div id="tab-8" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Course</th><th>Assigned Date</th><th>Due Date</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['training'] as $train): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($train['course']) ?></strong></td>
                            <td><?= htmlspecialchars($train['assigned']) ?></td>
                            <td><?= htmlspecialchars($train['due']) ?></td>
                            <td>
                                <?php if ($train['status'] === 'Completed'): ?>
                                    <span class="badge badge--success">Completed</span>
                                <?php else: ?>
                                    <span class="badge badge--danger">Overdue</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 9: Documents -->
    <div id="tab-9" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Document Name</th><th>Type</th><th>Uploaded</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['documents'] as $doc): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($doc['name']) ?></strong></td>
                            <td><?= htmlspecialchars($doc['type']) ?></td>
                            <td><?= htmlspecialchars($doc['uploaded']) ?></td>
                            <td>
                                <?php if ($doc['status'] === 'Verified'): ?>
                                    <span class="badge badge--success">Verified</span>
                                <?php else: ?>
                                    <span class="badge badge--warning">Expiring Soon</span>
                                <?php endif; ?>
                            </td>
                            <td><button class="btn btn--ghost btn--xs">View PDF</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 10: Equipment -->
    <div id="tab-10" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Asset Name</th><th>Assigned Date</th><th>Condition</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['equipment'] as $equip): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($equip['asset']) ?></strong></td>
                            <td><?= htmlspecialchars($equip['assigned']) ?></td>
                            <td><?= htmlspecialchars($equip['condition']) ?></td>
                            <td><span class="badge badge--primary"><?= htmlspecialchars($equip['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 11: Communications -->
    <div id="tab-11" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Type</th><th>Subject</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['communications'] as $comm): ?>
                        <tr>
                            <td><?= htmlspecialchars($comm['date']) ?></td>
                            <td><?= htmlspecialchars($comm['type']) ?></td>
                            <td><strong><?= htmlspecialchars($comm['subject']) ?></strong></td>
                            <td><span class="badge badge--success"><?= htmlspecialchars($comm['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 12: Notes -->
    <div id="tab-12" class="tab-content card" style="display: none;">
        <div class="card-header" style="display: flex; justify-content: space-between;">
            <h3 style="margin: 0;">Manager Notes</h3>
            <button class="btn btn--primary btn--sm">Add Note</button>
        </div>
        <div style="padding: 16px; display: flex; flex-direction: column; gap: 16px;">
            <?php foreach ($demoData['notes'] as $note): ?>
                <div style="border: 1px solid var(--color-border); border-radius: 6px; padding: 12px; background: var(--color-bg-alt);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <div>
                            <strong><?= htmlspecialchars($note['author']) ?></strong> 
                            <span class="badge badge--secondary ml-sm"><?= htmlspecialchars($note['category']) ?></span>
                        </div>
                        <div class="text-sm-muted"><?= htmlspecialchars($note['date']) ?></div>
                    </div>
                    <div style="color: var(--color-text);"><?= htmlspecialchars($note['content']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tab 13: Access -->
    <div id="tab-13" class="tab-content card" style="display: none; padding: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="margin: 0;">Account Access</h3>
            <div style="display: flex; gap: 8px;">
                <button class="btn btn--secondary btn--sm">Reset Password</button>
                <button class="btn btn--danger btn--sm">Suspend Access</button>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <div class="text-sm-muted mb-xs">Login Email</div>
                <strong><?= htmlspecialchars($emp['email']) ?></strong>
            </div>
            <div>
                <div class="text-sm-muted mb-xs">MFA Status</div>
                <span class="badge badge--success"><?= htmlspecialchars($demoData['access']['mfa']) ?></span>
            </div>
            <div>
                <div class="text-sm-muted mb-xs">Roles</div>
                <div style="display: flex; gap: 4px;">
                    <?php foreach ($demoData['access']['roles'] as $role): ?>
                        <span class="badge badge--primary"><?= htmlspecialchars($role) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <div class="text-sm-muted mb-xs">Last Login</div>
                <div><?= htmlspecialchars($demoData['access']['last_login']) ?></div>
            </div>
        </div>
    </div>

    <!-- Tab 14: Audit History -->
    <div id="tab-14" class="tab-content card" style="display: none;">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Administrator</th><th>Action</th><th>Module</th></tr></thead>
                <tbody>
                    <?php foreach ($demoData['audit'] as $aud): ?>
                        <tr>
                            <td class="text-sm-muted"><?= htmlspecialchars($aud['date']) ?></td>
                            <td><strong><?= htmlspecialchars($aud['admin']) ?></strong></td>
                            <td><?= htmlspecialchars($aud['action']) ?></td>
                            <td><span class="badge badge--secondary"><?= htmlspecialchars($aud['module']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function switchTab(btnElement, targetId) {
        // Reset all tabs
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.style.display = 'none');
        
        const tabBtns = document.querySelectorAll('#profile-tabs button');
        tabBtns.forEach(btn => {
            btn.style.fontWeight = '400';
            btn.style.color = 'var(--color-text-muted)';
            btn.style.borderBottomColor = 'transparent';
        });

        // Activate target tab
        document.getElementById(targetId).style.display = 'block';
        btnElement.style.fontWeight = '600';
        btnElement.style.color = 'var(--color-primary)';
        btnElement.style.borderBottomColor = 'var(--color-primary)';
    }
</script>

