<?php
$onShifts         = str_starts_with($path, '/admin/shifts') && !str_contains($path, 'shift-type');
$onShiftsTimeline = str_starts_with($path, '/admin/shifts/timeline');
$onCalendar       = str_starts_with($path, '/admin/shifts/calendar');
$ico              = fn(string $k): string => '<span class="topbar-nav-group__link-icon">' . $svgIcon($k) . '</span>';
?>
<header class="topbar">
    <a href="<?= route_url('home') ?>" class="topbar-brand"><img src="<?= $BASE_URL ?>/assets/img/mascot/brand-icon.png" alt="" class="topbar-brand__icon">Kintai<?php if (!empty($app_subtitle)): ?><span class="topbar-brand__subtitle"><?= htmlspecialchars($app_subtitle, ENT_QUOTES) ?></span><?php endif; ?></a>

    <button type="button" class="topbar-nav-toggle" id="topbarNavToggle" aria-label="Menu" aria-expanded="false">☰</button>

    <nav class="topbar-nav" id="topbarNav" aria-label="Navigation principale">
        <?php if ($showAdminMenu): ?>
            <a href="<?= route_url('admin.overview') ?>" class="topbar-nav-link<?= str_starts_with($path, '/admin/overview') ? ' topbar-nav-link--active' : '' ?>"><?= $ico('chart') ?>Overview</a>

            <div class="topbar-nav-group<?= (str_starts_with($path, '/admin/live-ops') || str_starts_with($path, '/admin/tasks') || str_starts_with($path, '/admin/incidents')) ? ' topbar-nav-group--active' : '' ?>">
                <button type="button" class="topbar-nav-group__trigger">Operations <span class="topbar-nav-group__caret">▾</span></button>
                <div class="topbar-nav-group__panel">
                    <a href="<?= route_url('admin.live_ops') ?>" class="topbar-nav-group__link"><?= $ico('clock') ?>Live Operations</a>
                    <a href="<?= route_url('admin.tasks') ?>" class="topbar-nav-group__link"><?= $ico('clipboard') ?>Tasks</a>
                    <a href="<?= route_url('admin.incidents') ?>" class="topbar-nav-group__link"><?= $ico('backup') ?>Incidents</a>
                </div>
            </div>

            <div class="topbar-nav-group<?= (str_starts_with($path, '/admin/team') || str_starts_with($path, '/admin/scheduling') || str_starts_with($path, '/admin/time-attendance')) ? ' topbar-nav-group--active' : '' ?>">
                <button type="button" class="topbar-nav-group__trigger">Workforce <span class="topbar-nav-group__caret">▾</span></button>
                <div class="topbar-nav-group__panel">
                    <a href="<?= route_url('admin.team') ?>" class="topbar-nav-group__link"><?= $ico('users') ?>Team</a>
                    <a href="<?= route_url('admin.scheduling') ?>" class="topbar-nav-group__link"><?= $ico('calendar') ?>Scheduling</a>
                    <a href="<?= route_url('admin.time_attendance') ?>" class="topbar-nav-group__link"><?= $ico('history') ?>Time & Attendance</a>
                </div>
            </div>

            <div class="topbar-nav-group<?= (str_starts_with($path, '/admin/locations') || str_starts_with($path, '/admin/requests') || str_starts_with($path, '/admin/communications') || str_starts_with($path, '/admin/reports')) ? ' topbar-nav-group--active' : '' ?>">
                <button type="button" class="topbar-nav-group__trigger">Organization <span class="topbar-nav-group__caret">▾</span></button>
                <div class="topbar-nav-group__panel">
                    <a href="<?= route_url('admin.locations') ?>" class="topbar-nav-group__link"><?= $ico('store') ?>Locations</a>
                    <a href="<?= route_url('admin.requests') ?>" class="topbar-nav-group__link"><?= $ico('arrows') ?>Requests</a>
                    <a href="<?= route_url('admin.communications') ?>" class="topbar-nav-group__link"><?= $ico('message') ?>Communications</a>
                    <a href="<?= route_url('admin.reports') ?>" class="topbar-nav-group__link"><?= $ico('book') ?>Reports & Analytics</a>
                </div>
            </div>

            <div class="topbar-nav-group<?= (str_starts_with($path, '/admin/tools') || str_starts_with($path, '/admin/audit-log') || str_starts_with($path, '/admin/settings') || str_starts_with($path, '/admin/roles')) ? ' topbar-nav-group--active' : '' ?>">
                <button type="button" class="topbar-nav-group__trigger">System <span class="topbar-nav-group__caret">▾</span></button>
                <div class="topbar-nav-group__panel">
                    <a href="<?= route_url('admin.tools') ?>" class="topbar-nav-group__link"><?= $ico('gear') ?>Tools & Operations</a>
                    <a href="<?= route_url('admin.audit_log') ?>" class="topbar-nav-group__link"><?= $ico('history') ?>Audit Log</a>
                    <a href="<?= route_url('admin.settings') ?>" class="topbar-nav-group__link"><?= $ico('gear') ?>Settings</a>
                    <a href="<?= route_url('admin.roles') ?>" class="topbar-nav-group__link"><?= $ico('person') ?>Roles & Permissions</a>
                </div>
            </div>
        <?php elseif (!$showAdminMenu): ?>
            <?php
            $navHide = fn(string $k): bool => in_array($k, (array)($user_nav_hidden ?? []), true);
            $_defSec = ['planning', 'requests', 'account'];
            $_rawOrd = (array)($user_nav_section_order ?? []);
            $_secOrd = array_values(array_unique(array_merge(
                array_intersect($_rawOrd, $_defSec),
                $_defSec
            )));
            ?>
            <a href="<?= route_url('employee.dashboard') ?>" class="topbar-nav-link<?= $path === '/employee' ? ' topbar-nav-link--active' : '' ?>"><?= __('dashboard') ?></a>

            <?php foreach ($_secOrd as $_sec): switch ($_sec):
                    case 'planning': ?>
                        <?php if (($feat('shifts') && !$navHide('my_planning')) || ($feat('timeclock') && !$navHide('timeclock'))): ?>
                            <div class="topbar-nav-group<?= (str_starts_with($path, '/employee/shifts') || str_starts_with($path, '/employee/timeclock')) ? ' topbar-nav-group--active' : '' ?>">
                                <button type="button" class="topbar-nav-group__trigger"><?= __('planning') ?> <span class="topbar-nav-group__caret">▾</span></button>
                                <div class="topbar-nav-group__panel">
                                    <?php if ($feat('shifts') && !$navHide('my_planning')): ?>
                                        <a href="<?= route_url('employee.shifts.day') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/shifts') ? ' topbar-nav-group__link--active' : '' ?>"><?= $ico('calendar') ?><?= __('my_planning') ?></a>
                                    <?php endif; ?>
                                    <?php if ($feat('timeclock') && !$navHide('timeclock')): ?>
                                        <a href="<?= route_url('employee.timeclock') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/timeclock') ? ' topbar-nav-group__link--active' : '' ?>"><?= $ico('clock') ?><?= __('timeclock') ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php break;
                    case 'requests': ?>
                        <?php if (($feat('timeoff') && !$navHide('my_timeoff')) || ($feat('swaps') && !$navHide('swaps')) || ($feat('open_shifts') && !$navHide('open_shifts')) || ($feat('messages') && !$navHide('messages'))): ?>
                            <div class="topbar-nav-group<?= (str_starts_with($path, '/employee/timeoff') || str_starts_with($path, '/employee/swaps') || str_starts_with($path, '/employee/open-shifts') || str_starts_with($path, '/employee/messages')) ? ' topbar-nav-group--active' : '' ?>">
                                <button type="button" class="topbar-nav-group__trigger"><?= __('requests') ?> <span class="topbar-nav-group__caret">▾</span></button>
                                <div class="topbar-nav-group__panel">
                                    <?php if ($feat('timeoff') && !$navHide('my_timeoff')): ?>
                                        <a href="<?= route_url('employee.timeoff') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/timeoff') ? ' topbar-nav-group__link--active' : '' ?>"><?= $ico('leaf') ?><?= __('my_timeoff') ?></a>
                                    <?php endif; ?>
                                    <?php if ($feat('swaps') && !$navHide('swaps')): ?>
                                        <a href="<?= route_url('employee.swaps') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/swaps') ? ' topbar-nav-group__link--active' : '' ?>"><?= $ico('arrows') ?><?= __('swaps') ?></a>
                                    <?php endif; ?>
                                    <?php if ($feat('open_shifts') && !$navHide('open_shifts')): ?>
                                        <a href="<?= route_url('employee.open_shifts') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/open-shifts') ? ' topbar-nav-group__link--active' : '' ?>"><?= $ico('plus') ?><?= __('open_shifts') ?></a>
                                    <?php endif; ?>
                                    <?php if ($feat('messages') && !$navHide('messages')): ?>
                                        <a href="<?= route_url('employee.messages') ?>" class="topbar-nav-group__link<?= str_starts_with($path, '/employee/messages') ? ' topbar-nav-group__link--active' : '' ?>">
                                            <?= $ico('message') ?><?= __('messages') ?>
                                            <?php if (($unread_messages_count ?? 0) > 0): ?><span class="nav-badge"><?= (int) $unread_messages_count ?></span><?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php break;
                    case 'statistics': ?>
                        <?php if ($feat('daily_reports') && !$navHide('daily_reports') && !empty($daily_report_staff_stores)): ?>
                            <div class="topbar-nav-group<?= str_contains($path, '/daily-reports') ? ' topbar-nav-group--active' : '' ?>">
                                <button type="button" class="topbar-nav-group__trigger"><?= __('reports') ?> <span class="topbar-nav-group__caret">▾</span></button>
                                <div class="topbar-nav-group__panel">
                                    <?php foreach ($daily_report_staff_stores as $_drStore): ?>
                                        <?php $_drId = (int) $_drStore['id']; ?>
                                        <a href="<?= route_url('admin.stores') ?>/<?= $_drId ?>/daily-reports"
                                            class="topbar-nav-group__link<?= str_contains($path, '/stores/' . $_drId . '/daily-reports') ? ' topbar-nav-group__link--active' : '' ?>">
                                            <?= $ico('chart') ?><?= __('daily_reports') ?><?= count($daily_report_staff_stores) > 1 ? ' — ' . htmlspecialchars($_drStore['name']) : '' ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php break;
                    case 'account': ?>
                        <?php if (!$navHide('my_profile')): ?>
                            <a href="<?= route_url('profile') ?>" class="topbar-nav-link<?= (str_starts_with($path, '/profile') && ($_GET['tab'] ?? 'info') !== 'nav') ? ' topbar-nav-link--active' : '' ?>"><?= __('my_profile') ?></a>
                        <?php endif; ?>
            <?php break;
                endswitch;
            endforeach; ?>
        <?php endif; ?>
    </nav>

    <?php
    $displayName = htmlspecialchars(
        $auth_user['display_name']
            ?? trim(($auth_user['last_name'] ?? '') . ' ' . ($auth_user['first_name'] ?? ''))
            ?: ($auth_user['email'] ?? __('user'))
    );
    $roleLabel = $isOwner ? __('role_owner') : ($isManager ? __('role_manager') : __('role_employee'));
    $initials  = strtoupper(
        mb_substr($auth_user['first_name'] ?? '', 0, 1) .
            mb_substr($auth_user['last_name']  ?? '', 0, 1)
    );
    if ($initials === '') {
        $initials = strtoupper(mb_substr(strip_tags($displayName), 0, 2));
    }

    $_notifLabels = [
        'message_received'      => __('notif_message_received'),
        'timeoff_approved'      => __('notif_timeoff_approved'),
        'timeoff_refused'       => __('notif_timeoff_refused'),
        'swap_accepted'         => __('notif_swap_accepted'),
        'swap_refused'          => __('notif_swap_refused'),
        'shift_assigned'        => __('notif_shift_assigned'),
        'open_shift_published'  => __('notif_open_shift_published'),
        'shift_claim_submitted' => __('notif_shift_claim_submitted'),
        'shift_claim_approved'  => __('notif_shift_claim_approved'),
        'shift_claim_rejected'  => __('notif_shift_claim_rejected'),
        'shift_claim_withdrawn' => __('notif_shift_claim_withdrawn'),
        'daily_report_submitted' => __('notif_daily_report_submitted'),
        'daily_report_validated' => __('notif_daily_report_validated'),
        'feedback_submitted'    => __('notif_feedback_submitted'),
        'swap_requested'        => __('notif_swap_requested'),
        'swap_peer_accepted'    => __('notif_swap_peer_accepted'),
        'swap_peer_refused'     => __('notif_swap_peer_refused'),
        'swap_cancelled'        => __('notif_swap_cancelled'),
    ];
    $_notifIcons = [
        'message_received'      => '✉',
        'timeoff_approved'      => '✓',
        'timeoff_refused'       => '✗',
        'swap_accepted'         => '⇄',
        'swap_refused'          => '⇄',
        'shift_assigned'        => '📅',
        'open_shift_published'  => '📢',
        'shift_claim_submitted' => '🙋',
        'shift_claim_approved'  => '✓',
        'shift_claim_rejected'  => '✗',
        'shift_claim_withdrawn' => '⊘',
        'daily_report_submitted' => '📝',
        'daily_report_validated' => '✓',
        'feedback_submitted'    => '💬',
        'swap_requested'        => '⇄',
        'swap_peer_accepted'    => '⇄',
        'swap_peer_refused'     => '⇄',
        'swap_cancelled'        => '⇄',
    ];
    $_dropdownItems = $notifications_dropdown ?? [];
    $_unreadCount   = (int) ($unread_notifications_count ?? 0);
    $_recentJson    = json_encode(array_map(fn($n) => [
        'title' => $_notifLabels[$n['type'] ?? ''] ?? ($n['type'] ?? ''),
        'body'  => $n['body'] ?? '',
    ], $recent_notifications ?? []), JSON_UNESCAPED_UNICODE);
    ?>

    <div class="topbar-actions">
        <?php if ($showAdminMenu): ?>
            <!-- Command Palette Trigger -->
            <button type="button" class="btn btn--ghost btn--sm" onclick="document.getElementById('cmdPalette').showModal()" style="margin-right: 12px; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                Search (Cmd+K)
            </button>

            <!-- Sync Status -->
            <div title="System Synced" style="color: var(--color-success); margin-right: 12px; display: flex; align-items: center;">
                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            
            <!-- Contextual Selector -->
            <select class="form-select form-select--sm" style="max-width: 150px; margin-right: 16px;">
                <option value="all">All Locations</option>
                <option value="1">Region A (Demo)</option>
                <option value="2">Region B (Demo)</option>
            </select>
        <?php endif; ?>

        <?php if (!$showAdminMenu && isset($employee_month_stats)): ?>
            <?php $ems = $employee_month_stats;
            $emsCur = $ems['currency'] ?? 'JPY';
            $emsStyle = $ems['currency_symbol_style'] ?? 'kanji'; ?>
            <div class="topbar-nav-group topbar-nav-group--stats">
                <button type="button" class="topbar-nav-group__trigger topbar-nav-group__trigger--stats">
                    <?= $ico('clock') ?><?= number_format($ems['hours_month'], 1) ?> h <span class="topbar-nav-group__caret">▾</span>
                </button>
                <div class="topbar-nav-group__panel topbar-nav-group__panel--stats">
                    <div class="sb-month-nav">
                        <button onclick="sbMonthNav('<?= htmlspecialchars($ems['prev_month']) ?>')" class="sb-month-btn">&larr;</button>
                        <span class="sb-month-label"><?= htmlspecialchars($ems['month_label']) ?></span>
                        <button onclick="sbMonthNav('<?= htmlspecialchars($ems['next_month']) ?>')" class="sb-month-btn" <?= $ems['is_current'] ? 'disabled' : '' ?>>&rarr;</button>
                    </div>
                    <div class="sb-stats-card">
                        <div class="sb-stats-row">
                            <span class="sb-stats-label"><?= __('hours') ?></span>
                            <strong class="sb-stats-value--primary"><?= number_format($ems['hours_month'], 1) ?> <?= __('hours_unit') ?></strong>
                        </div>
                        <div class="sb-stats-row">
                            <span class="sb-stats-label"><?= __('avg_per_week') ?></span>
                            <strong><?= number_format($ems['hours_week'], 1) ?> <?= __('hours_unit') ?></strong>
                        </div>
                        <?php if ($ems['has_rate']): ?>
                            <div class="sb-stats-row sb-stats-row--border">
                                <span class="sb-stats-label"><?= __('estimated_pay') ?></span>
                                <strong class="sb-stats-value--success"><?= format_currency((float) $ems['estimated_pay'], $emsCur, $emsStyle) ?></strong>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($ems['shift_details'])): ?>
                            <button onclick="sbDetailOpen()" class="sb-detail-btn">
                                <?= __('see_details') ?> (<?= count($ems['shift_details']) ?> shift<?= count($ems['shift_details']) > 1 ? 's' : '' ?>) &#9654;
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($ems['shift_details'])): ?>
                <div id="sb-detail-overlay" onclick="sbDetailClose()">
                    <div class="sb-modal" onclick="event.stopPropagation()">
                        <div class="sb-modal-header">
                            <strong><?= __('shift_detail_title', ['month' => htmlspecialchars($ems['month_label'])]) ?></strong>
                            <button onclick="sbDetailClose()" class="sb-modal-close">&times;</button>
                        </div>
                        <div class="sb-modal-body">
                            <table class="sb-modal-table">
                                <thead>
                                    <tr>
                                        <th><?= __('date') ?></th>
                                        <th><?= __('schedule') ?></th>
                                        <th><?= __('type') ?></th>
                                        <th><?= __('net') ?></th>
                                        <?php if ($ems['has_rate']): ?>
                                            <th><?= __('rate_h') ?></th>
                                            <th class="th-right"><?= __('estimated_pay') ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sbTotalNet = 0; ?>
                                    <?php foreach ($ems['shift_details'] as $row): ?>
                                        <?php $sbTotalNet += $row['net_min'] ?? 0; ?>
                                        <tr>
                                            <td class="td-nowrap"><?= htmlspecialchars($row['date_label']) ?></td>
                                            <td class="td-mono"><?= htmlspecialchars($row['start']) ?>&ndash;<?= htmlspecialchars($row['end']) ?></td>
                                            <td><?= htmlspecialchars($row['type_name']) ?></td>
                                            <td class="td-nowrap">
                                                <?= htmlspecialchars($row['net_hours_fmt']) ?>
                                                <?php if (($row['pause_min'] ?? 0) > 0): ?>
                                                    <small class="sb-stats-label">(<?= (int)$row['pause_min'] ?> min)</small>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($ems['has_rate']): ?>
                                                <td class="td-muted"><?= htmlspecialchars($row['rate_fmt']) ?></td>
                                                <td class="td-right <?= $row['has_rate'] ? 'sb-pay-ok' : 'sb-pay-none' ?>">
                                                    <?= htmlspecialchars($row['pay_fmt']) ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="td-muted"><?= __('total') ?></td>
                                        <td class="td-nowrap">
                                            <?php $sbH = intdiv($sbTotalNet, 60);
                                            $sbM = $sbTotalNet % 60; ?>
                                            <?= $sbH ?>h<?= str_pad((string)$sbM, 2, '0', STR_PAD_LEFT) ?>
                                        </td>
                                        <?php if ($ems['has_rate']): ?>
                                            <td></td>
                                            <td class="td-right sb-stats-value--success"><?= format_currency((float) $ems['estimated_pay'], $emsCur, $emsStyle) ?></td>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="sb-modal-footer">
                            <button onclick="sbDetailClose()" class="btn btn--ghost btn--sm"><?= __('close') ?></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <script src="<?= $BASE_URL ?>/assets/js/modules/sidebar-stats.js"></script>
        <?php endif; ?>

        <div class="notif-dropdown" id="notif-dropdown">
            <button id="notif-toggle" class="notif-dropdown__toggle" title="<?= __('notifications') ?>">
                🔔
                <?php if ($_unreadCount > 0): ?>
                    <span class="notif-dropdown__badge"><?= min($_unreadCount, 99) ?></span>
                <?php endif; ?>
            </button>
            <div class="notif-dropdown__panel">
                <div class="notif-dropdown__header">
                    <span><?= __('notifications') ?></span>
                    <?php if ($_unreadCount > 0): ?>
                        <form method="POST" action="<?= route_url('notifications.read_all') ?>" class="notif-mark-read-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn--ghost btn--xs"><?= __('mark_all_read') ?></button>
                        </form>
                    <?php endif; ?>
                </div>
                <?php if (empty($_dropdownItems)): ?>
                    <div class="notif-dropdown__empty"><?= __('no_notifications') ?></div>
                <?php else: ?>
                    <?php foreach ($_dropdownItems as $_n): ?>
                        <?php $_nRead = (int) ($_n['is_read'] ?? 0); ?>
                        <div class="notif-entry<?= $_nRead ? '' : ' notif-entry--unread' ?>">
                            <span class="notif-entry__icon"><?= $_notifIcons[$_n['type'] ?? ''] ?? '•' ?></span>
                            <div class="notif-entry__body">
                                <div class="notif-entry__title"><?= htmlspecialchars($_notifLabels[$_n['type'] ?? ''] ?? '') ?></div>
                                <div class="notif-entry__text"><?= htmlspecialchars($_n['body'] ?? '') ?></div>
                                <div class="notif-entry__time"><?= htmlspecialchars(substr($_n['created_at'] ?? '', 0, 16)) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="notif-dropdown__footer">
                        <a href="<?= route_url('notifications.index') ?>"><?= __('notifications') ?> →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="notif-meta"
            data-recent="<?= htmlspecialchars($_recentJson) ?>"
            data-poll-url="<?= route_url('notifications.poll') ?>"
            data-labels="<?= htmlspecialchars(json_encode($_notifLabels, JSON_UNESCAPED_UNICODE)) ?>"
            hidden></div>

        <div class="user-dropdown" id="user-dropdown">
            <button class="user-dropdown__toggle" id="user-toggle"
                aria-expanded="false" aria-haspopup="true">
                <span class="user-dropdown__avatar"><?= htmlspecialchars($initials) ?></span>
                <span class="user-dropdown__label"><?= $displayName ?></span>
                <span class="user-dropdown__chevron" aria-hidden="true">▾</span>
            </button>

            <div class="user-dropdown__panel" role="menu">
                <div class="user-dropdown__header">
                    <div class="user-dropdown__hname"><?= $displayName ?></div>
                    <div class="user-dropdown__hrole"><?= $roleLabel ?></div>
                </div>

                <a href="<?= route_url('profile') ?>" class="user-dropdown__item" role="menuitem">
                    <span class="user-dropdown__item-icon">👤</span><?= __('my_profile') ?>
                </a>

                <hr class="user-dropdown__divider">

                <button id="themeToggle" class="user-dropdown__item" role="menuitem" type="button"
                        data-label-light="<?= __('theme_light_mode') ?>"
                        data-label-dark="<?= __('theme_dark_mode') ?>"
                        data-title-light="<?= __('switch_to_light_mode') ?>"
                        data-title-dark="<?= __('switch_to_dark_mode') ?>">
                    <span class="user-dropdown__item-icon" id="theme-icon">🌙</span>
                    <span id="theme-label"><?= __('theme_dark_mode') ?></span>
                </button>

                <div class="user-dropdown__item user-dropdown__lang">
                    <span class="user-dropdown__lang-left">
                        <span class="user-dropdown__item-icon">🌐</span><?= __('language') ?>
                    </span>
                    <div class="user-dropdown__lang-btns">
                        <?php foreach (($active_languages ?? []) as $_lang): ?>
                            <a href="<?= $BASE_URL ?>/lang/<?= htmlspecialchars($_lang['code']) ?>"
                                title="<?= htmlspecialchars($_lang['name']) ?>"
                                class="user-dropdown__lang-btn<?= ($locale ?? 'en') === $_lang['code'] ? ' user-dropdown__lang-btn--active' : '' ?>"><?= htmlspecialchars(strtoupper($_lang['code'])) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (($auth_is_manager ?? $isManager) && !$isOwner): ?>
                    <hr class="user-dropdown__divider">
                    <form method="POST" action="<?= route_url('switch.view') ?>" class="form-contents">
                        <?= csrf_field() ?>
                        <button type="submit" class="user-dropdown__item" role="menuitem">
                            <span class="user-dropdown__item-icon">🔄</span>
                            <?= $viewMode === 'admin' ? __('view_employee') : __('view_admin') ?>
                        </button>
                    </form>
                <?php endif; ?>

                <hr class="user-dropdown__divider">

                <a href="<?= $BASE_URL ?>/docs"
                    class="user-dropdown__item<?= str_starts_with($path, '/docs') ? ' topbar-nav-link--active' : '' ?>"
                    role="menuitem">
                    <span class="user-dropdown__item-icon">📖</span><?= __('docs') ?>
                </a>

                <hr class="user-dropdown__divider">

                <form method="POST" action="<?= route_url('auth.logout') ?>" class="form-contents">
                    <?= csrf_field() ?>
                    <button type="submit" class="user-dropdown__item user-dropdown__item--danger" role="menuitem">
                        <span class="user-dropdown__item-icon">⎋</span><?= __('logout') ?>
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>