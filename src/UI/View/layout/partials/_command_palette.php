<?php if ($showAdminMenu): ?>
<dialog id="cmdPalette" class="modal cmd-palette">
    <div class="modal-content" style="max-width: 600px; margin-top: 10vh; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div class="modal-header" style="border-bottom: 1px solid var(--color-border); padding: 12px 16px;">
            <div style="display: flex; align-items: center; width: 100%;">
                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" style="color: var(--color-text-muted); margin-right: 12px;"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                <input type="text" id="cmdInput" placeholder="Search employees, locations, shifts or actions..." style="flex: 1; border: none; outline: none; font-size: 16px; background: transparent; color: var(--color-text);">
                <button type="button" class="btn btn--ghost btn--xs" onclick="document.getElementById('cmdPalette').close()">ESC</button>
            </div>
        </div>
        <div class="modal-body" style="max-height: 400px; overflow-y: auto; padding: 0;">
            <!-- Demo Quick Actions -->
            <div style="padding: 12px 16px;">
                <div style="font-size: 12px; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px; text-transform: uppercase;">Quick Actions</div>
                <a href="<?= route_url('admin.scheduling') ?>" class="tr--clickable" style="display: flex; align-items: center; padding: 8px; border-radius: 6px; text-decoration: none; color: var(--color-text); margin-bottom: 4px;">
                    <div style="background: var(--color-primary-light); color: var(--color-primary); padding: 6px; border-radius: 4px; margin-right: 12px;">📅</div>
                    Create a Shift
                </a>
                <a href="<?= route_url('admin.tasks') ?>" class="tr--clickable" style="display: flex; align-items: center; padding: 8px; border-radius: 6px; text-decoration: none; color: var(--color-text); margin-bottom: 4px;">
                    <div style="background: var(--color-success-light); color: var(--color-success); padding: 6px; border-radius: 4px; margin-right: 12px;">📝</div>
                    Assign a Task
                </a>
                <a href="<?= route_url('admin.communications') ?>" class="tr--clickable" style="display: flex; align-items: center; padding: 8px; border-radius: 6px; text-decoration: none; color: var(--color-text); margin-bottom: 4px;">
                    <div style="background: var(--color-warning-light); color: var(--color-warning); padding: 6px; border-radius: 4px; margin-right: 12px;">📢</div>
                    Send Announcement
                </a>
                <a href="<?= route_url('admin.incidents') ?>" class="tr--clickable" style="display: flex; align-items: center; padding: 8px; border-radius: 6px; text-decoration: none; color: var(--color-text);">
                    <div style="background: var(--color-danger-light); color: var(--color-danger); padding: 6px; border-radius: 4px; margin-right: 12px;">🚨</div>
                    Escalate Emergency
                </a>
            </div>
            
            <div style="border-top: 1px solid var(--color-border); padding: 12px 16px;">
                <div style="font-size: 12px; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px; text-transform: uppercase;">Recent (Demo)</div>
                <div style="display: flex; align-items: center; padding: 8px; margin-bottom: 4px;">
                    <div style="margin-right: 12px; width: 28px; height: 28px; background: var(--color-bg-alt); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">JD</div>
                    <div style="flex: 1;">
                        <div style="font-weight: 500;">John Doe</div>
                        <div style="font-size: 12px; color: var(--color-text-muted);">Stock Worker • Store 124</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dialog>
<script>
    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const dialog = document.getElementById('cmdPalette');
            if(dialog) {
                if(dialog.open) dialog.close();
                else {
                    dialog.showModal();
                    document.getElementById('cmdInput').focus();
                }
            }
        }
    });
</script>
<?php endif; ?>
