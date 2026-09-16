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
