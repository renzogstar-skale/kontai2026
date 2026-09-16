<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" action="" class="filter-bar">
            <div class="shifts-filters__row">
                <div class="shifts-filters__group">
                    <label class="shifts-filters__label">Status Filter</label>
                    <select class="form-control form-control-sm">
                        <option>All Statuses</option>
                        <option>Clocked In</option>
                        <option>Late</option>
                        <option>On Break</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Worker</th>
                    <th>Role</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['active_workforce'] as $worker): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($worker['name']) ?></strong></td>
                        <td><span class="text-sm-muted"><?= htmlspecialchars($worker['role']) ?></span></td>
                        <td><?= htmlspecialchars($worker['location']) ?></td>
                        <td>
                            <?php if ($worker['status'] === 'clocked_in'): ?>
                                <span class="badge badge--success">Clocked In</span>
                            <?php elseif ($worker['status'] === 'late'): ?>
                                <span class="badge badge--danger">Late</span>
                            <?php elseif ($worker['status'] === 'on_break'): ?>
                                <span class="badge badge--warning">On Break</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($worker['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
