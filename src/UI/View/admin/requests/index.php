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
