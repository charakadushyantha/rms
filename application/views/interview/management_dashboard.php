<?php
$data['page_title'] = 'Interview Management';
$data['use_datatable'] = false;
$this->load->view('templates/admin_header', $data);
?>

<style>
/* ── IMS page styles ── */
.ims-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}
.ims-stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    border-left: 4px solid transparent;
}
.ims-stat-card.scheduled  { border-color: #667eea; }
.ims-stat-card.completed  { border-color: #22c55e; }
.ims-stat-card.pending    { border-color: #f59e0b; }
.ims-stat-card.cancelled  { border-color: #ef4444; }
.ims-stat-icon {
    width: 52px; height: 52px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
}
.scheduled  .ims-stat-icon { background: rgba(102,126,234,.12); color: #667eea; }
.completed  .ims-stat-icon { background: rgba(34,197,94,.12);   color: #22c55e; }
.pending    .ims-stat-icon { background: rgba(245,158,11,.12);  color: #f59e0b; }
.cancelled  .ims-stat-icon { background: rgba(239,68,68,.12);   color: #ef4444; }
.ims-stat-value { font-size: 30px; font-weight: 700; color: #1a1a1a; line-height: 1; }
.ims-stat-label { font-size: 13px; color: #666; margin-top: 4px; }
.ims-stat-trend { font-size: 12px; margin-top: 6px; }
.ims-stat-trend.positive { color: #22c55e; }
.ims-stat-trend.negative { color: #ef4444; }
.ims-stat-trend.neutral  { color: #999; }

.ims-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; }

/* Filters */
.ims-filters {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 20px;
    border: 1px solid #e9ecef;
}
.ims-filter-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
.ims-filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 140px; }
.ims-filter-group label { font-size: 12px; font-weight: 600; color: #555; }

/* Interview cards */
.ims-interview-card {
    background: #fff;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
    transition: box-shadow .2s;
}
.ims-interview-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.ims-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.ims-candidate-name { font-size: 16px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px; }
.ims-position-badge {
    display: inline-block; padding: 3px 10px;
    background: rgba(102,126,234,.1); color: #667eea;
    border-radius: 20px; font-size: 12px; font-weight: 500;
}
.ims-status-badge {
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;
}
.ims-status-badge.status-pending    { background: #fff3cd; color: #856404; }
.ims-status-badge.status-in_progress{ background: #cfe2ff; color: #084298; }
.ims-status-badge.status-completed  { background: #d1e7dd; color: #0a3622; }
.ims-status-badge.status-cancelled  { background: #f8d7da; color: #842029; }
.ims-card-meta { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 14px; }
.ims-meta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #666; }
.ims-meta-item i { color: #667eea; width: 14px; }
.ims-card-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.ims-expanded { display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid #f0f0f0; }
.ims-expanded-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.ims-info-section h4 { font-size: 13px; font-weight: 700; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: .5px; }
.ims-info-section p { font-size: 13px; color: #333; margin-bottom: 5px; }

/* Sidebar widgets */
.ims-widget {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    margin-bottom: 20px;
    overflow: hidden;
}
.ims-widget-header {
    padding: 14px 18px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    display: flex; justify-content: space-between; align-items: center;
}
.ims-widget-header h3 { margin: 0; font-size: 14px; font-weight: 600; }
.ims-widget-body { padding: 16px 18px; }
.ims-cal-nav { display: flex; align-items: center; gap: 8px; }
.ims-cal-nav button { background: rgba(255,255,255,.2); border: none; color: #fff; border-radius: 6px; width: 26px; height: 26px; cursor: pointer; }
.ims-cal-nav span { font-size: 13px; font-weight: 600; }
.ims-mini-cal { width: 100%; }
.ims-cal-weekdays { display: grid; grid-template-columns: repeat(7,1fr); text-align: center; font-size: 11px; font-weight: 600; color: #999; margin-bottom: 6px; }
.ims-cal-days { display: grid; grid-template-columns: repeat(7,1fr); gap: 2px; }
.ims-cal-day {
    text-align: center; padding: 5px 2px; font-size: 12px; border-radius: 6px; cursor: pointer;
}
.ims-cal-day.today { background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; font-weight: 700; }
.ims-cal-day.has-interview { background: rgba(102,126,234,.15); color: #667eea; font-weight: 600; }
.ims-cal-day.other-month { color: #ccc; }
.ims-cal-day:hover:not(.today) { background: #f0f0f0; }
.ims-today-item { display: flex; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
.ims-today-item:last-child { border-bottom: none; }
.ims-today-time { font-size: 12px; font-weight: 700; color: #667eea; white-space: nowrap; }
.ims-today-info strong { display: block; font-size: 13px; color: #333; }
.ims-today-info span { font-size: 12px; color: #888; }
.ims-quick-btn {
    display: flex; align-items: center; gap: 10px;
    width: 100%; padding: 10px 12px; margin-bottom: 8px;
    background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px;
    font-size: 13px; font-weight: 500; color: #333; cursor: pointer;
    transition: all .2s; text-align: left;
}
.ims-quick-btn:hover { background: rgba(102,126,234,.08); border-color: #667eea; color: #667eea; }
.ims-quick-btn i { width: 18px; color: #667eea; }
.ims-upcoming-item { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
.ims-upcoming-item:last-child { border-bottom: none; }
.ims-upcoming-date { text-align: center; min-width: 36px; }
.ims-upcoming-date .day { font-size: 20px; font-weight: 700; color: #667eea; line-height: 1; }
.ims-upcoming-date .month { font-size: 11px; color: #999; text-transform: uppercase; }
.ims-upcoming-info strong { display: block; font-size: 13px; color: #333; }
.ims-upcoming-info span { font-size: 12px; color: #888; }
.ims-upcoming-info small { font-size: 11px; color: #aaa; }
.ims-pagination { display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 20px; }
.ims-empty { text-align: center; padding: 40px 20px; color: #999; }
.ims-empty i { font-size: 48px; margin-bottom: 12px; display: block; }
.ims-empty h3 { font-size: 16px; color: #555; margin-bottom: 8px; }
.no-interviews { font-size: 13px; color: #999; text-align: center; padding: 12px 0; }

@media (max-width: 992px) {
    .ims-stats-grid { grid-template-columns: repeat(2,1fr); }
    .ims-layout { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
    .ims-stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="ims-page">
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight:700;color:#1a1a1a;">
            <i class="fas fa-calendar-check me-2" style="color:#667eea;"></i>Interview Management
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:13px;">
                <li class="breadcrumb-item"><a href="<?= base_url('A_dashboard') ?>" style="color:#667eea;">Dashboard</a></li>
                <li class="breadcrumb-item active">Interviews</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" onclick="exportReport()">
            <i class="fas fa-download me-1"></i>Export Report
        </button>
        <button class="btn btn-primary btn-sm" onclick="scheduleInterview()" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;">
            <i class="fas fa-plus me-1"></i>Schedule Interview
        </button>
    </div>
</div>

<!-- Statistics -->
<div class="ims-stats-grid">
    <div class="ims-stat-card scheduled">
        <div class="ims-stat-icon"><i class="fas fa-clock"></i></div>
        <div>
            <div class="ims-stat-value"><?= $stats['scheduled'] ?? 0 ?></div>
            <div class="ims-stat-label">Scheduled</div>
            <div class="ims-stat-trend positive"><i class="fas fa-arrow-up"></i> 12% from last week</div>
        </div>
    </div>
    <div class="ims-stat-card completed">
        <div class="ims-stat-icon"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="ims-stat-value"><?= $stats['completed'] ?? 0 ?></div>
            <div class="ims-stat-label">Completed</div>
            <div class="ims-stat-trend positive"><i class="fas fa-arrow-up"></i> 8% from last week</div>
        </div>
    </div>
    <div class="ims-stat-card pending">
        <div class="ims-stat-icon"><i class="fas fa-hourglass-half"></i></div>
        <div>
            <div class="ims-stat-value"><?= $stats['pending'] ?? 0 ?></div>
            <div class="ims-stat-label">Pending</div>
            <div class="ims-stat-trend neutral"><i class="fas fa-minus"></i> No change</div>
        </div>
    </div>
    <div class="ims-stat-card cancelled">
        <div class="ims-stat-icon"><i class="fas fa-times-circle"></i></div>
        <div>
            <div class="ims-stat-value"><?= $stats['cancelled'] ?? 0 ?></div>
            <div class="ims-stat-label">Cancelled</div>
            <div class="ims-stat-trend negative"><i class="fas fa-arrow-down"></i> 3% from last week</div>
        </div>
    </div>
</div>
<!-- Main Layout -->
<div class="ims-layout">
    <!-- Left Column -->
    <div>
        <!-- Filters -->
        <div class="ims-filters">
            <div class="ims-filter-row">
                <div class="ims-filter-group">
                    <label><i class="fas fa-search me-1"></i>Search</label>
                    <input type="text" id="search-input" placeholder="Search by candidate name, position..." class="form-control form-control-sm">
                </div>
                <div class="ims-filter-group">
                    <label><i class="fas fa-filter me-1"></i>Status</label>
                    <select id="status-filter" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="ims-filter-group">
                    <label><i class="fas fa-briefcase me-1"></i>Position</label>
                    <select id="position-filter" class="form-select form-select-sm">
                        <option value="">All Positions</option>
                        <?php foreach ($positions as $position): ?>
                        <option value="<?= $position ?>"><?= htmlspecialchars($position) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="ims-filter-group">
                    <label><i class="fas fa-calendar me-1"></i>From</label>
                    <input type="date" id="date-from" class="form-control form-control-sm">
                </div>
                <div class="ims-filter-group">
                    <label><i class="fas fa-calendar me-1"></i>To</label>
                    <input type="date" id="date-to" class="form-control form-control-sm">
                </div>
                <div class="ims-filter-group" style="justify-content:flex-end;">
                    <label>&nbsp;</label>
                    <button class="btn btn-sm btn-primary" onclick="applyFilters()" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;">
                        <i class="fas fa-search me-1"></i>Apply
                    </button>
                </div>
            </div>
        </div>

        <!-- Interview List -->
        <div id="interview-list">
            <?php if (!empty($interviews)): ?>
                <?php foreach ($interviews as $interview): ?>
                <div class="ims-interview-card" data-id="<?= $interview['id'] ?>">
                    <div class="ims-card-header">
                        <div>
                            <h5 class="ims-candidate-name"><?= htmlspecialchars($interview['candidate_name'] ?? 'Unknown Candidate') ?></h5>
                            <span class="ims-position-badge"><?= htmlspecialchars($interview['job_title'] ?? 'Position Not Set') ?></span>
                        </div>
                        <span class="ims-status-badge status-<?= $interview['status'] ?>">
                            <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?>
                        </span>
                    </div>
                    <div class="ims-card-meta">
                        <div class="ims-meta-item"><i class="fas fa-calendar"></i><?= isset($interview['created_at']) ? date('M d, Y', strtotime($interview['created_at'])) : 'Not Set' ?></div>
                        <div class="ims-meta-item"><i class="fas fa-clock"></i><?= isset($interview['created_at']) ? date('h:i A', strtotime($interview['created_at'])) : 'Not Set' ?></div>
                        <div class="ims-meta-item"><i class="fas fa-envelope"></i><?= htmlspecialchars($interview['candidate_email'] ?? 'No Email') ?></div>
                        <div class="ims-meta-item"><i class="fas fa-link"></i>Token: <?= substr($interview['token'] ?? '', 0, 8) ?>...</div>
                    </div>
                    <div class="ims-card-actions">
                        <button class="btn btn-sm btn-primary" onclick="viewInterview(<?= $interview['id'] ?>)" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;">
                            <i class="fas fa-eye me-1"></i>View
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="rescheduleInterview(<?= $interview['id'] ?>)">
                            <i class="fas fa-calendar-alt me-1"></i>Reschedule
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="sendReminder(<?= $interview['id'] ?>)">
                            <i class="fas fa-envelope me-1"></i>Reminder
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="cancelInterview(<?= $interview['id'] ?>)">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleDetails(<?= $interview['id'] ?>)">
                            <i class="fas fa-chevron-down me-1"></i>More
                        </button>
                    </div>
                    <div class="ims-expanded" id="details-<?= $interview['id'] ?>">
                        <div class="ims-expanded-grid">
                            <div class="ims-info-section">
                                <h4>Candidate Information</h4>
                                <p><strong>Email:</strong> <?= htmlspecialchars($interview['candidate_email'] ?? 'Not provided') ?></p>
                                <p><strong>Phone:</strong> <?= htmlspecialchars($interview['candidate_phone'] ?? 'Not provided') ?></p>
                                <p><strong>Token:</strong> <?= htmlspecialchars($interview['token'] ?? 'N/A') ?></p>
                            </div>
                            <div class="ims-info-section">
                                <h4>Interview Details</h4>
                                <p><strong>Status:</strong> <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?></p>
                                <p><strong>Created:</strong> <?= isset($interview['created_at']) ? date('M d, Y h:i A', strtotime($interview['created_at'])) : 'N/A' ?></p>
                                <p><strong>Expires:</strong> <?= isset($interview['expires_at']) ? date('M d, Y h:i A', strtotime($interview['expires_at'])) : 'N/A' ?></p>
                                <?php if (!empty($interview['started_at'])): ?>
                                <p><strong>Started:</strong> <?= date('M d, Y h:i A', strtotime($interview['started_at'])) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($interview['completed_at'])): ?>
                                <p><strong>Completed:</strong> <?= date('M d, Y h:i A', strtotime($interview['completed_at'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                        <?php endforeach; ?>
            <?php else: ?>
                <div class="ims-empty">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Interviews Found</h3>
                    <p>Schedule your first interview to get started</p>
                    <button class="btn btn-primary" onclick="scheduleInterview()" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;">
                        <i class="fas fa-plus me-1"></i>Schedule Interview
                    </button>
                </div>
            <?php endif; ?>
        </div><!-- /#interview-list -->

        <!-- Pagination -->
        <?php if (!empty($interviews)): ?>
        <div class="ims-pagination">
            <button class="btn btn-sm btn-outline-secondary" <?= $page <= 1 ? 'disabled' : '' ?> onclick="changePage(<?= $page - 1 ?>)">
                <i class="fas fa-chevron-left me-1"></i>Previous
            </button>
            <span class="text-muted" style="font-size:13px;">Page <?= $page ?> of <?= $total_pages ?></span>
            <button class="btn btn-sm btn-outline-secondary" <?= $page >= $total_pages ? 'disabled' : '' ?> onclick="changePage(<?= $page + 1 ?>)">
                Next<i class="fas fa-chevron-right ms-1"></i>
            </button>
        </div>
        <?php endif; ?>
    </div><!-- /left column -->

    <!-- Right Column - Sidebar -->
    <div>
        <!-- Calendar Widget -->
        <div class="ims-widget">
            <div class="ims-widget-header">
                <h3><i class="fas fa-calendar me-2"></i>Calendar</h3>
                <div class="ims-cal-nav">
                    <button onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                    <span id="current-month"></span>
                    <button onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="ims-widget-body">
                <div class="ims-mini-cal">
                    <div class="ims-cal-weekdays">
                        <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                    </div>
                    <div class="ims-cal-days" id="calendar-days"></div>
                </div>
                <div style="margin-top:16px;">
                    <h4 style="font-size:13px;font-weight:700;color:#555;margin-bottom:10px;">Today's Interviews</h4>
                    <?php if (!empty($today_interviews)): ?>
                        <?php foreach ($today_interviews as $ti): ?>
                        <div class="ims-today-item">
                            <div class="ims-today-time"><?= isset($ti['created_at']) ? date('h:i A', strtotime($ti['created_at'])) : 'N/A' ?></div>
                            <div class="ims-today-info">
                                <strong><?= htmlspecialchars($ti['candidate_name'] ?? 'Unknown') ?></strong>
                                <span><?= htmlspecialchars($ti['job_title'] ?? 'Position Not Set') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-interviews">No interviews scheduled for today</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions Widget -->
        <div class="ims-widget">
            <div class="ims-widget-header">
                <h3><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
            </div>
            <div class="ims-widget-body">
                <button class="ims-quick-btn" onclick="openEmailTemplates()"><i class="fas fa-envelope"></i><span>Email Templates</span></button>
                <button class="ims-quick-btn" onclick="manageInterviewers()"><i class="fas fa-users"></i><span>Interviewer Panel</span></button>
                <button class="ims-quick-btn" onclick="viewFeedbackForms()"><i class="fas fa-clipboard-check"></i><span>Feedback Forms</span></button>
                <button class="ims-quick-btn" onclick="viewNotifications()"><i class="fas fa-bell"></i><span>Notifications</span></button>
                <button class="ims-quick-btn" onclick="generateReports()"><i class="fas fa-chart-bar"></i><span>Reports</span></button>
                <button class="ims-quick-btn" onclick="viewSettings()"><i class="fas fa-cog"></i><span>Settings</span></button>
            </div>
        </div>

        <!-- Upcoming This Week Widget -->
        <div class="ims-widget">
            <div class="ims-widget-header">
                <h3><i class="fas fa-clock me-2"></i>Upcoming This Week</h3>
            </div>
            <div class="ims-widget-body">
                <?php if (!empty($upcoming_interviews)): ?>
                    <?php foreach ($upcoming_interviews as $ui): ?>
                    <div class="ims-upcoming-item">
                        <div class="ims-upcoming-date">
                            <div class="day"><?= isset($ui['created_at']) ? date('d', strtotime($ui['created_at'])) : '--' ?></div>
                            <div class="month"><?= isset($ui['created_at']) ? date('M', strtotime($ui['created_at'])) : '' ?></div>
                        </div>
                        <div class="ims-upcoming-info">
                            <strong><?= htmlspecialchars($ui['candidate_name'] ?? 'Unknown') ?></strong>
                            <span><?= htmlspecialchars($ui['job_title'] ?? 'Position Not Set') ?></span>
                            <small><?= isset($ui['created_at']) ? date('h:i A', strtotime($ui['created_at'])) : '' ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-interviews">No upcoming interviews this week</p>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- /right column -->
</div><!-- /.ims-layout -->
</div><!-- /.ims-page -->

<?php
$base_url = base_url();
$custom_script = <<<JAVASCRIPT

var imsCurrentMonth = new Date().getMonth();
var imsCurrentYear  = new Date().getFullYear();

function renderCalendar(month, year) {
    var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('current-month').textContent = months[month] + ' ' + year;
    var firstDay = new Date(year, month, 1).getDay();
    var daysInMonth = new Date(year, month + 1, 0).getDate();
    var today = new Date();
    var html = '';
    for (var i = 0; i < firstDay; i++) html += '<div class="ims-cal-day other-month"></div>';
    for (var d = 1; d <= daysInMonth; d++) {
        var cls = 'ims-cal-day';
        if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) cls += ' today';
        html += '<div class="' + cls + '">' + d + '</div>';
    }
    document.getElementById('calendar-days').innerHTML = html;
}

function previousMonth() {
    imsCurrentMonth--;
    if (imsCurrentMonth < 0) { imsCurrentMonth = 11; imsCurrentYear--; }
    renderCalendar(imsCurrentMonth, imsCurrentYear);
}
function nextMonth() {
    imsCurrentMonth++;
    if (imsCurrentMonth > 11) { imsCurrentMonth = 0; imsCurrentYear++; }
    renderCalendar(imsCurrentMonth, imsCurrentYear);
}

function toggleDetails(id) {
    var el = document.getElementById('details-' + id);
    if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function changePage(page) {
    window.location.href = '{$base_url}interview/management?page=' + page;
}

function applyFilters() {
    var search   = document.getElementById('search-input').value.toLowerCase();
    var status   = document.getElementById('status-filter').value.toLowerCase();
    var position = document.getElementById('position-filter').value.toLowerCase();
    var cards    = document.querySelectorAll('.ims-interview-card');
    cards.forEach(function(card) {
        var text = card.textContent.toLowerCase();
        var show = (!search || text.includes(search))
                && (!status || text.includes(status))
                && (!position || text.includes(position));
        card.style.display = show ? '' : 'none';
    });
}

function exportReport() {
    alert('Export feature coming soon.');
}
function scheduleInterview() {
    window.location.href = '{$base_url}interview/create_interview';
}
function viewInterview(id) {
    window.location.href = '{$base_url}interview/view/' + id;
}
function rescheduleInterview(id) { alert('Reschedule feature coming soon for interview #' + id); }
function sendReminder(id) { alert('Reminder sent for interview #' + id); }
function cancelInterview(id) {
    if (confirm('Cancel this interview?')) {
        alert('Cancel feature coming soon for interview #' + id);
    }
}
function openEmailTemplates() { alert('Email Templates coming soon.'); }
function manageInterviewers()  { window.location.href = '{$base_url}A_dashboard/Ainterviewer_users_view'; }
function viewFeedbackForms()   { alert('Feedback Forms coming soon.'); }
function viewNotifications()   { alert('Notifications coming soon.'); }
function generateReports()     { alert('Reports coming soon.'); }
function viewSettings()        { window.location.href = '{$base_url}A_dashboard/setup'; }

$(document).ready(function() {
    renderCalendar(imsCurrentMonth, imsCurrentYear);
    $('#search-input').on('keyup', applyFilters);
    $('#status-filter, #position-filter').on('change', applyFilters);
});
JAVASCRIPT;

$this->load->view('templates/admin_footer');
?>
