<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Total Requests</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">156</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Pending Approval</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">32</div>
            <div style="color: var(--color-danger); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Approved Today</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">18</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Denied</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">5</div>
            <div style="color: var(--color-danger); display: flex; align-items: center;">▼</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Worker</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['requests'] as $req): ?>
                    <tr>
                        <td class="text-sm-muted"><?= htmlspecialchars($req['id']) ?></td>
                        <td><?= htmlspecialchars($req['date']) ?></td>
                        <td><strong><?= htmlspecialchars($req['type']) ?></strong></td>
                        <td><?= htmlspecialchars($req['worker']) ?></td>
                        <td>
                            <?php if ($req['status'] === 'Approved'): ?>
                                <span class="badge badge--success">Approved</span>
                            <?php else: ?>
                                <span class="badge badge--warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($req['status'] === 'Pending'): ?>
                                <button class="btn btn--primary btn--xs">Approve</button>
                                <button class="btn btn--danger btn--xs">Deny</button>
                            <?php else: ?>
                                <button class="btn btn--ghost btn--xs">View</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

