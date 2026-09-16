<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--ghost btn--sm">Export Logs</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Actor</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['logs'] as $log): ?>
                    <tr>
                        <td class="text-sm-muted"><?= htmlspecialchars($log['timestamp']) ?></td>
                        <td><strong><?= htmlspecialchars($log['actor']) ?></strong></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><code><?= htmlspecialchars($log['module']) ?></code></td>
                        <td>
                            <?php if ($log['result'] === 'Success'): ?>
                                <span class="badge badge--success">Success</span>
                            <?php else: ?>
                                <span class="badge badge--danger">Failed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
