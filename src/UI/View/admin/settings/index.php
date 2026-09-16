<?php
/** @var string $title */
/** @var array $demoData */
?>
<div class="page-header">
    <h2 class="page-header__title"><?= htmlspecialchars($title) ?></h2>
</div>

<div style="display: flex; gap: 24px;">
    <div style="flex: 0 0 250px;">
        <div class="card" style="padding: 12px 0;">
            <?php foreach ($demoData['sections'] as $index => $section): ?>
                <div style="padding: 8px 16px; <?= $index === 0 ? 'background: var(--color-bg-alt); font-weight: 500; border-left: 3px solid var(--color-primary);' : 'color: var(--color-text-muted);' ?> cursor: pointer;">
                    <?= htmlspecialchars($section) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div style="flex: 1;">
        <div class="card">
            <div class="card-header">
                <h3 style="margin: 0; font-size: 16px;">Organization Profile</h3>
            </div>
            <div style="padding: 16px;">
                <div class="form-group">
                    <label class="form-label">Organization Name</label>
                    <input type="text" class="form-control" value="Acme Corp (Demo)">
                </div>
                <div class="form-group" style="margin-top: 16px;">
                    <label class="form-label">Timezone</label>
                    <select class="form-control">
                        <option>America/New_York</option>
                        <option>Europe/London</option>
                    </select>
                </div>
                <div style="margin-top: 24px;">
                    <button class="btn btn--primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
