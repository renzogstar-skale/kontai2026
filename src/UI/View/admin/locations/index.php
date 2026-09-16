<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">Add Location</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Location ID</th>
                    <th>Name</th>
                    <th>Client</th>
                    <th>Staffing Status</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['locations'] as $loc): ?>
                    <tr>
                        <td class="text-sm-muted"><?= htmlspecialchars($loc['id']) ?></td>
                        <td><strong><?= htmlspecialchars($loc['name']) ?></strong></td>
                        <td><?= htmlspecialchars($loc['client']) ?></td>
                        <td>
                            <?php if ($loc['staffing'] === 'Optimal'): ?>
                                <span class="badge badge--success">Optimal</span>
                            <?php else: ?>
                                <span class="badge badge--warning">Understaffed</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge--primary">Active</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

