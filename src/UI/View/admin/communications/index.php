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

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Total Messages</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">452</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Unread</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">14</div>
            <div style="color: var(--color-danger); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Active Threads</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">89</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▲</div>
        </div>
    </div>
    <div class="card" style="padding: 16px;">
        <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;">Response Time</div>
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <div style="font-size: 28px; font-weight: 700; color: var(--color-text);">1.2h</div>
            <div style="color: var(--color-success); display: flex; align-items: center;">▼</div>
        </div>
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

