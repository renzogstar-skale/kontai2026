<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <?php foreach ($demoData['kpis'] as $kpi): ?>
        <div class="card" style="padding: 16px;">
            <div style="color: var(--color-text-muted); font-size: 13px; font-weight: 500; text-transform: uppercase; margin-bottom: 8px;"><?= htmlspecialchars($kpi['label']) ?></div>
            <div style="display: flex; align-items: baseline; gap: 8px;">
                <div style="font-size: 28px; font-weight: 700; color: var(--color-text);"><?= htmlspecialchars($kpi['value']) ?></div>
                <div style="color: var(--color-<?= $kpi['color'] ?>); display: flex; align-items: center;">
                    <?= $kpi['trend'] === 'up' ? '▲' : '▼' ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card">
    <div class="card-header">
        <h3 style="margin: 0; font-size: 16px;">System Alerts</h3>
    </div>
    <div style="padding: 16px; display: flex; flex-direction: column; gap: 12px;">
        <?php foreach ($demoData['alerts'] as $alert): ?>
            <div style="padding: 12px 16px; border-left: 4px solid var(--color-<?= $alert['type'] ?>); background: var(--color-bg-alt); border-radius: 4px;">
                <div style="color: var(--color-text); font-weight: 500;"><?= htmlspecialchars($alert['message']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

