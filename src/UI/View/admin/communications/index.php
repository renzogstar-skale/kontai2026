<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
    <div class="page-header__actions">
        <button class="btn btn--primary btn--sm">New Message</button>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demoData['messages'] as $msg): ?>
                    <tr>
                        <td><span class="text-sm-muted"><?= htmlspecialchars($msg['date']) ?></span></td>
                        <td><strong><?= htmlspecialchars($msg['sender']) ?></strong></td>
                        <td><?= htmlspecialchars($msg['subject']) ?></td>
                        <td>
                            <?php if ($msg['status'] === 'Unread'): ?>
                                <span class="badge badge--primary">Unread</span>
                            <?php else: ?>
                                <span class="badge badge--secondary">Sent</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
