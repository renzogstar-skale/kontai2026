<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">Report Incident</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Severity</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['incidents'] as $inc): ?>
                    <tr>
                        <td class="text-sm-muted"><?= htmlspecialchars($inc['id']) ?></td>
                        <td><?= htmlspecialchars($inc['date']) ?></td>
                        <td><strong><?= htmlspecialchars($inc['category']) ?></strong></td>
                        <td>
                            <?php if ($inc['severity'] === 'High'): ?>
                                <span class="badge badge--danger">High</span>
                            <?php elseif ($inc['severity'] === 'Medium'): ?>
                                <span class="badge badge--warning">Medium</span>
                            <?php else: ?>
                                <span class="badge badge--info">Low</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($inc['location']) ?></td>
                        <td>
                            <?php if ($inc['status'] === 'Resolved'): ?>
                                <span class="badge badge--success">Resolved</span>
                            <?php else: ?>
                                <span class="badge badge--secondary"><?= htmlspecialchars($inc['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
