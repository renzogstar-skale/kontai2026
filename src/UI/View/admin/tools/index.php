<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">
    <?php foreach ($demoData['tools'] as $tool): ?>
        <div class="card" style="padding: 16px; display: flex; flex-direction: column; gap: 12px;">
            <div>
                <div style="font-weight: 600; font-size: 16px; color: var(--color-text);"><?= htmlspecialchars($tool['name']) ?></div>
                <div style="color: var(--color-text-muted); font-size: 13px;"><?= htmlspecialchars($tool['description']) ?></div>
            </div>
            <div>
                <span class="badge badge--success"><?= htmlspecialchars($tool['status']) ?></span>
            </div>
            <div style="margin-top: auto; padding-top: 12px;">
                <button class="btn btn--primary btn--sm" style="width: 100%;">Launch Tool</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

