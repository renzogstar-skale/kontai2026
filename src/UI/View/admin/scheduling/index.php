<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">Publish Schedule</button>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Published Shifts</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">342</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Open Shifts</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">12</div>
            <div style="color: var(--color-warning); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Call-offs</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">4</div>
            <div style="color: var(--color-danger); display: flex; align-items: center;">▼</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Overtime Risk</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">7</div>
            <div style="color: var(--color-danger); display: flex; align-items: center;">▲</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Worker</th>
                    <th>Location</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['shifts'] as $shift): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($shift['date']) ?></strong></td>
                        <td>
                            <?php if ($shift['worker'] === 'Unassigned'): ?>
                                <span class="text-sm-muted" style="font-style: italic;">Unassigned</span>
                            <?php else: ?>
                                <?= htmlspecialchars($shift['worker']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($shift['location']) ?></td>
                        <td><?= htmlspecialchars($shift['time']) ?></td>
                        <td>
                            <?php if ($shift['status'] === 'Published'): ?>
                                <span class="badge badge--success">Published</span>
                            <?php else: ?>
                                <span class="badge badge--warning">Open</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn--ghost btn--xs">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

