<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Report Name</th>
                    <th>Category</th>
                    <th>Last Run</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['reports'] as $report): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($report['name']) ?></strong></td>
                        <td><span class="badge badge--primary"><?= htmlspecialchars($report['category']) ?></span></td>
                        <td><span class="text-sm-muted"><?= htmlspecialchars($report['last_run']) ?></span></td>
                        <td>
                            <button class="btn btn--ghost btn--xs">Run Now</button>
                            <button class="btn btn--ghost btn--xs">Schedule</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
