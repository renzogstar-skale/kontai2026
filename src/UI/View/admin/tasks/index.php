<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">Create Task</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Title</th>
                    <th>Worker</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['tasks'] as $task): ?>
                    <tr>
                        <td class="text-sm-muted"><?= htmlspecialchars($task['id']) ?></td>
                        <td><strong><?= htmlspecialchars($task['title']) ?></strong></td>
                        <td><?= htmlspecialchars($task['worker']) ?></td>
                        <td><?= htmlspecialchars($task['location']) ?></td>
                        <td>
                            <?php if ($task['status'] === 'Completed'): ?>
                                <span class="badge badge--success">Completed</span>
                            <?php elseif ($task['status'] === 'In Progress'): ?>
                                <span class="badge badge--primary">In Progress</span>
                            <?php else: ?>
                                <span class="badge badge--secondary">Not Started</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

