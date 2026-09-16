<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">Export Timesheets</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Worker</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['punches'] as $punch): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($punch['time']) ?></strong></td>
                        <td><?= htmlspecialchars($punch['worker']) ?></td>
                        <td><?= htmlspecialchars($punch['location']) ?></td>
                        <td><?= htmlspecialchars($punch['type']) ?></td>
                        <td>
                            <?php if ($punch['status'] === 'Valid'): ?>
                                <span class="badge badge--success">Valid</span>
                            <?php else: ?>
                                <span class="badge badge--danger">Late</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

