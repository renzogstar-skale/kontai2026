<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <div class="page-header__left">
        <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
        <div class="text-sm-muted" style="margin-top: 4px;">Manage workers, supervisors, roles, assignments, availability, and workforce compliance.</div>
    </div>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm" onclick="document.getElementById('addEmployeeModal').showModal()">Add Worker</button>
        <button class="btn btn--secondary btn--sm" onclick="document.getElementById('inviteEmployeeModal').showModal()">Invite Employee</button>
        <button class="btn btn--ghost btn--sm">Import Employees</button>
        <button class="btn btn--ghost btn--sm">Export</button>
        <div class="dropdown">
            <button class="btn btn--ghost btn--sm">More ▾</button>
        </div>
    </div>
</div>

<!-- KPI Summary Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <?php foreach ($demoData['kpis'] as $kpi): ?>
        <div class="card" style="padding: 16px; position: relative;" title="<?= htmlspecialchars($kpi['tooltip']) ?>">
            <div style="position: absolute; top: 12px; right: 12px;">
                <span class="badge badge--secondary" style="font-size: 10px;">Demo Data</span>
            </div>
            <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px; padding-right: 60px;"><?= htmlspecialchars($kpi['label']) ?></div>
            <div style="display: flex; align-items: baseline; gap: 8px;">
                <div style="font-size: 28px; font-weight: 700; color: var(--color-text);"><?= htmlspecialchars($kpi['value']) ?></div>
                <div style="color: var(--color-<?= $kpi['color'] ?>); display: flex; align-items: center; font-size: 14px; font-weight: 600;">
                    <?= $kpi['trend'] === 'up' ? '▲' : ($kpi['trend'] === 'down' ? '▼' : '—') ?> <?= htmlspecialchars($kpi['change']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Attention Center -->
<div class="card mb-sm">
    <div class="card-header" style="background: var(--color-bg-alt);">
        <h3 style="margin: 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <span style="color: var(--color-danger);">⚠️</span> Needs Attention
        </h3>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Issue</th>
                    <th>Severity</th>
                    <th>Location</th>
                    <th>Time/Due</th>
                    <th>Manager</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['attentionQueue'] as $issue): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($issue['employee']) ?></strong></td>
                        <td><?= htmlspecialchars($issue['issue']) ?></td>
                        <td>
                            <?php 
                            $sevClass = match($issue['severity']) {
                                'Critical' => 'danger',
                                'High' => 'warning',
                                'Medium' => 'primary',
                                'Low' => 'info',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge badge--<?= $sevClass ?>"><?= htmlspecialchars($issue['severity']) ?></span>
                        </td>
                        <td><?= htmlspecialchars($issue['location']) ?></td>
                        <td class="text-sm-muted"><?= htmlspecialchars($issue['time']) ?></td>
                        <td><?= htmlspecialchars($issue['manager']) ?></td>
                        <td>
                            <button class="btn btn--primary btn--xs"><?= htmlspecialchars($issue['action']) ?></button>
                            <button class="btn btn--ghost btn--xs">View</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Directory & Filters -->
<div class="card mb-sm">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 12px; align-items: center; flex: 1;">
            <input type="text" class="form-control form-control-sm" placeholder="Search employees by name, ID, email..." style="max-width: 300px;">
            <button class="btn btn--secondary btn--sm">Filters</button>
            <span class="text-sm-muted">Active: <strong>Role: Worker</strong> ✕</span>
            <button class="btn btn--ghost btn--sm text-sm-muted">Clear all</button>
        </div>
        <div style="display: flex; gap: 8px;">
            <!-- View Toggles -->
            <button class="btn btn--ghost btn--sm" onclick="toggleView('table')" id="btnViewTable" style="background: var(--color-bg-alt);">Table View</button>
            <button class="btn btn--ghost btn--sm" onclick="toggleView('card')" id="btnViewCard">Card View</button>
        </div>
    </div>
    
    <!-- Bulk Actions Toolbar (Hidden by default) -->
    <div id="bulkActionsToolbar" style="display: none; padding: 12px 16px; background: var(--color-primary-light); border-bottom: 1px solid var(--color-border); align-items: center; justify-content: space-between;">
        <div>
            <strong style="color: var(--color-primary);" id="selectedCount">0</strong> <span style="color: var(--color-primary);">employees selected</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn btn--primary btn--sm">Assign Shift</button>
            <button class="btn btn--primary btn--sm">Send Message</button>
            <div class="dropdown">
                <button class="btn btn--secondary btn--sm">Change Status ▾</button>
            </div>
            <button class="btn btn--danger btn--sm">Deactivate</button>
        </div>
    </div>

    <!-- Table View -->
    <div class="table-wrap" id="directoryTableView">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" onchange="toggleAllRows(this)"></th>
                    <th>Employee</th>
                    <th>ID</th>
                    <th>Role & Title</th>
                    <th>Location</th>
                    <th>Supervisor</th>
                    <th>Status</th>
                    <th>Today's Shift</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['employees'] as $emp): ?>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox" onchange="updateBulkToolbar()"></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--color-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                                    <?= substr($emp['name'], 0, 1) ?>
                                </div>
                                <div>
                                    <a href="<?= route_url('admin.team.profile', ['id' => $emp['id']]) ?>" style="font-weight: 600; color: var(--color-text); text-decoration: none;"><?= htmlspecialchars($emp['name']) ?></a>
                                    <div class="text-sm-muted"><?= htmlspecialchars($emp['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-sm-muted">#<?= $emp['id'] ?></td>
                        <td>
                            <div><strong><?= htmlspecialchars($emp['role']) ?></strong></div>
                            <div class="text-sm-muted"><?= htmlspecialchars($emp['title']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($emp['location']) ?></td>
                        <td><?= htmlspecialchars($emp['supervisor']) ?></td>
                        <td>
                            <?php 
                            $statClass = match($emp['status']) {
                                'Working' => 'success',
                                'Scheduled' => 'primary',
                                'Available' => 'info',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge badge--<?= $statClass ?>"><?= htmlspecialchars($emp['status']) ?></span>
                        </td>
                        <td class="text-sm-muted"><?= htmlspecialchars($emp['shift']) ?></td>
                        <td>
                            <a href="<?= route_url('admin.team.profile', ['id' => $emp['id']]) ?>" class="btn btn--ghost btn--xs">Profile</a>
                            <button class="btn btn--ghost btn--xs">Message</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Card View (Hidden by default) -->
    <div id="directoryCardView" style="display: none; padding: 16px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
            <?php foreach ($demoData['employees'] as $emp): ?>
                <div class="card" style="padding: 16px; border: 1px solid var(--color-border); box-shadow: none;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                                <?= substr($emp['name'], 0, 1) ?>
                            </div>
                            <div>
                                <a href="<?= route_url('admin.team.profile', ['id' => $emp['id']]) ?>" style="font-weight: 600; color: var(--color-text); text-decoration: none; font-size: 16px;"><?= htmlspecialchars($emp['name']) ?></a>
                                <div class="text-sm-muted"><?= htmlspecialchars($emp['title']) ?></div>
                            </div>
                        </div>
                        <?php 
                            $statClass = match($emp['status']) {
                                'Working' => 'success',
                                'Scheduled' => 'primary',
                                'Available' => 'info',
                                default => 'secondary'
                            };
                        ?>
                        <span class="badge badge--<?= $statClass ?>"><?= htmlspecialchars($emp['status']) ?></span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 16px; font-size: 13px;">
                        <div>
                            <div class="text-sm-muted">Location</div>
                            <div style="font-weight: 500;"><?= htmlspecialchars($emp['location']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm-muted">Role</div>
                            <div style="font-weight: 500;"><?= htmlspecialchars($emp['role']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm-muted">Supervisor</div>
                            <div style="font-weight: 500;"><?= htmlspecialchars($emp['supervisor']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm-muted">Today's Shift</div>
                            <div style="font-weight: 500;"><?= htmlspecialchars($emp['shift']) ?></div>
                        </div>
                    </div>
                    
                    <div style="border-top: 1px solid var(--color-border); padding-top: 12px; display: flex; gap: 8px;">
                        <a href="<?= route_url('admin.team.profile', ['id' => $emp['id']]) ?>" class="btn btn--secondary btn--sm" style="flex: 1; text-align: center;">View Profile</a>
                        <button class="btn btn--primary btn--sm" style="flex: 1;">Message</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<dialog id="addEmployeeModal" class="modal" style="width: 100%; max-width: 600px; padding: 0; border: none; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
    <div class="modal-header" style="padding: 16px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0;">Add New Employee</h3>
        <button class="btn btn--ghost btn--sm" onclick="document.getElementById('addEmployeeModal').close()">✕</button>
    </div>
    <div class="modal-body" style="padding: 24px;">
        <!-- Multi-step Wizard Simulation -->
        <div style="display: flex; gap: 8px; margin-bottom: 24px;">
            <div style="flex: 1; height: 4px; background: var(--color-primary); border-radius: 2px;"></div>
            <div style="flex: 1; height: 4px; background: var(--color-border); border-radius: 2px;"></div>
            <div style="flex: 1; height: 4px; background: var(--color-border); border-radius: 2px;"></div>
            <div style="flex: 1; height: 4px; background: var(--color-border); border-radius: 2px;"></div>
        </div>
        <h4 style="margin-top: 0;">Step 1: Personal Information</h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div class="form-group">
                <label class="form-label">Legal First Name</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Legal Last Name</label>
                <input type="text" class="form-control">
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
            <label class="form-label">Personal Email</label>
            <input type="email" class="form-control">
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-control">
        </div>
    </div>
    <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px; background: var(--color-bg-alt);">
        <button class="btn btn--ghost" onclick="document.getElementById('addEmployeeModal').close()">Cancel</button>
        <button class="btn btn--primary">Next Step</button>
    </div>
</dialog>

<!-- Invite Employee Modal -->
<dialog id="inviteEmployeeModal" class="modal" style="width: 100%; max-width: 500px; padding: 0; border: none; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
    <div class="modal-header" style="padding: 16px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0;">Invite Employee</h3>
        <button class="btn btn--ghost btn--sm" onclick="document.getElementById('inviteEmployeeModal').close()">✕</button>
    </div>
    <div class="modal-body" style="padding: 24px;">
        <div class="form-group" style="margin-bottom: 16px;">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" placeholder="employee@company.com">
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
            <label class="form-label">Role</label>
            <select class="form-control">
                <option>Worker</option>
                <option>Team Lead</option>
                <option>Supervisor</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 16px;">
            <label class="form-label">Location Assignment</label>
            <select class="form-control">
                <option>Store 101</option>
                <option>Store 102</option>
                <option>Warehouse B</option>
            </select>
        </div>
    </div>
    <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px; background: var(--color-bg-alt);">
        <button class="btn btn--ghost" onclick="document.getElementById('inviteEmployeeModal').close()">Cancel</button>
        <button class="btn btn--primary">Send Invitation</button>
    </div>
</dialog>

<script>
    // View Toggle Logic
    function toggleView(mode) {
        document.getElementById('directoryTableView').style.display = mode === 'table' ? 'block' : 'none';
        document.getElementById('directoryCardView').style.display = mode === 'card' ? 'block' : 'none';
        
        document.getElementById('btnViewTable').style.background = mode === 'table' ? 'var(--color-bg-alt)' : 'transparent';
        document.getElementById('btnViewCard').style.background = mode === 'card' ? 'var(--color-bg-alt)' : 'transparent';
    }

    // Bulk Actions Toolbar Logic
    function toggleAllRows(source) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
        updateBulkToolbar();
    }

    function updateBulkToolbar() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkboxes.length;
        const toolbar = document.getElementById('bulkActionsToolbar');
        const countDisplay = document.getElementById('selectedCount');
        
        countDisplay.textContent = count;
        toolbar.style.display = count > 0 ? 'flex' : 'none';
    }
</script>
