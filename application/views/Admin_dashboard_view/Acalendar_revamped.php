<?php
// Set page-specific variables
$data['page_title'] = 'Interview Calendar';
$data['use_calendar'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
/* Modern Calendar Dashboard Styles */
.calendar-dashboard {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
    margin-bottom: 24px;
}

.calendar-main {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.calendar-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.stat-mini-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
}

.stat-mini-number {
    font-size: 28px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 4px;
}

.stat-mini-label {
    font-size: 12px;
    color: #718096;
}

.upcoming-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.upcoming-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.upcoming-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
}

.upcoming-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 400px;
    overflow-y: auto;
}

.upcoming-item {
    padding: 12px;
    background: #f7fafc;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    transition: all 0.2s;
    cursor: pointer;
}

.upcoming-item:hover {
    background: #edf2f7;
    transform: translateX(4px);
}

.upcoming-item-time {
    font-size: 12px;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 4px;
}

.upcoming-item-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.upcoming-item-details {
    font-size: 12px;
    color: #718096;
}

.interview-filters {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 16px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-btn:hover {
    border-color: #667eea;
    color: #667eea;
}

.filter-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.interview-card {
    background: #f7fafc;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    display: grid;
    grid-template-columns: 80px 1fr auto;
    gap: 16px;
    align-items: center;
    transition: all 0.2s;
}

.interview-card:hover {
    background: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.interview-date-box {
    background: white;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    border: 2px solid #667eea;
}

.interview-date-day {
    font-size: 24px;
    font-weight: 700;
    color: #667eea;
    line-height: 1;
}

.interview-date-month {
    font-size: 12px;
    color: #718096;
    margin-top: 4px;
}

.interview-info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.interview-meta {
    display: flex;
    gap: 16px;
    font-size: 13px;
    color: #718096;
    flex-wrap: wrap;
}

.interview-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.interview-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.action-btn.view {
    background: #e6f7ff;
    color: #0066cc;
}

.action-btn.edit {
    background: #e6fffa;
    color: #234e52;
}

.action-btn.delete {
    background: #fff5f5;
    color: #c53030;
}

.action-btn:hover {
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #a0aec0;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    opacity: 0.3;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

.status-scheduled {
    background: #e6f7ff;
    color: #0066cc;
}

.status-completed {
    background: #c6f6d5;
    color: #22543d;
}

.status-cancelled {
    background: #fed7d7;
    color: #742a2a;
}

@media (max-width: 1200px) {
    .calendar-dashboard {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .interview-card {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .interview-date-box {
        margin: 0 auto;
        width: fit-content;
    }
    
    .interview-actions {
        justify-content: center;
    }
}
</style>

<!-- Calendar Dashboard -->
<div class="calendar-dashboard">
    <!-- Main Calendar Area -->
    <div class="calendar-main">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-calendar-alt me-2"></i>Interview Schedule
                </h3>
                <p class="text-muted mb-0">Manage and track all interview appointments</p>
            </div>
            <a href="<?= base_url('Interview/schedule') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Schedule Interview
            </a>
        </div>

        <!-- Filter Buttons -->
        <div class="interview-filters">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-calendar me-1"></i>All
            </button>
            <button class="filter-btn" data-filter="today">
                <i class="fas fa-calendar-day me-1"></i>Today
            </button>
            <button class="filter-btn" data-filter="week">
                <i class="fas fa-calendar-week me-1"></i>This Week
            </button>
            <button class="filter-btn" data-filter="month">
                <i class="fas fa-calendar-alt me-1"></i>This Month
            </button>
        </div>

        <!-- Interview List -->
        <div id="interviewList">
            <?php if (!empty($interviews)): ?>
                <?php foreach ($interviews as $interview): ?>
                    <?php
                    $start_date = new DateTime($interview->ce_start_date);
                    $day = $start_date->format('d');
                    $month = $start_date->format('M');
                    $time = $start_date->format('g:i A');
                    $end_date = new DateTime($interview->ce_end_date);
                    $end_time = $end_date->format('g:i A');
                    
                    // Get data attributes for filtering
                    $interview_date = $start_date->format('Y-m-d');
                    $today = date('Y-m-d');
                    $week_start = date('Y-m-d', strtotime('monday this week'));
                    $week_end = date('Y-m-d', strtotime('sunday this week'));
                    $month_start = date('Y-m-01');
                    $month_end = date('Y-m-t');
                    
                    $filter_class = '';
                    if ($interview_date == $today) $filter_class .= ' filter-today';
                    if ($interview_date >= $week_start && $interview_date <= $week_end) $filter_class .= ' filter-week';
                    if ($interview_date >= $month_start && $interview_date <= $month_end) $filter_class .= ' filter-month';
                    
                    // Determine if interview is past, today, or future
                    $now = new DateTime();
                    $status_label = 'Scheduled';
                    $status_class = 'status-scheduled';
                    if ($start_date < $now) {
                        $status_label = 'Completed';
                        $status_class = 'status-completed';
                    } elseif ($interview_date == $today) {
                        $status_label = 'Today';
                        $status_class = 'status-scheduled';
                    }
                    ?>
                    <div class="interview-card<?= $filter_class ?>" data-interview-id="<?= $interview->ce_id ?>">
                        <div class="interview-date-box">
                            <div class="interview-date-day"><?= $day ?></div>
                            <div class="interview-date-month"><?= strtoupper($month) ?></div>
                        </div>
                        <div class="interview-info">
                            <h4><?= htmlspecialchars($interview->ce_can_name) ?> - <?= htmlspecialchars($interview->cd_job_title ?? 'N/A') ?></h4>
                            <div class="interview-meta">
                                <span><i class="fas fa-clock"></i> <?= $time ?> - <?= $end_time ?></span>
                                <span><i class="fas fa-user-tie"></i> <?= htmlspecialchars($interview->ce_interviewer ?? 'TBD') ?></span>
                                <span class="status-badge <?= $status_class ?>">
                                    <?= $status_label ?>
                                </span>
                            </div>
                        </div>
                        <div class="interview-actions">
                            <button class="action-btn view" onclick="viewInterview(<?= $interview->ce_id ?>)" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit" onclick="editInterview(<?= $interview->ce_id ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete" onclick="deleteInterview(<?= $interview->ce_id ?>)" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h5>No Interviews Scheduled</h5>
                    <p>Click "Schedule Interview" to add a new interview</p>
                    <a href="<?= base_url('Interview/schedule') ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Schedule Interview
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="calendar-sidebar">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-mini-card">
                <div class="stat-mini-number"><?= $today_count ?></div>
                <div class="stat-mini-label">Today</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number"><?= $week_count ?></div>
                <div class="stat-mini-label">This Week</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number"><?= $month_count ?></div>
                <div class="stat-mini-label">This Month</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number"><?= $pending_count ?></div>
                <div class="stat-mini-label">Pending</div>
            </div>
        </div>

        <!-- Upcoming Interviews -->
        <div class="upcoming-section">
            <div class="upcoming-header">
                <div class="upcoming-title">Upcoming Today</div>
                <span class="badge bg-primary"><?= count($today_interviews) ?></span>
            </div>
            <div class="upcoming-list">
                <?php if (!empty($today_interviews)): ?>
                    <?php foreach ($today_interviews as $interview): ?>
                        <?php
                        $start_date = new DateTime($interview->ce_start_date);
                        $time = $start_date->format('g:i A');
                        ?>
                        <div class="upcoming-item" onclick="viewInterview(<?= $interview->ce_id ?>)">
                            <div class="upcoming-item-time">
                                <i class="fas fa-clock me-1"></i><?= $time ?>
                            </div>
                            <div class="upcoming-item-title"><?= htmlspecialchars($interview->ce_can_name) ?></div>
                            <div class="upcoming-item-details">
                                <?= htmlspecialchars($interview->cd_job_title ?? 'N/A') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i>
                        <p class="mb-0">No interviews scheduled for today</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');
        
        const filter = this.getAttribute('data-filter');
        const cards = document.querySelectorAll('.interview-card');
        
        cards.forEach(card => {
            if (filter === 'all') {
                card.style.display = 'grid';
            } else {
                if (card.classList.contains('filter-' + filter)) {
                    card.style.display = 'grid';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    });
});

function viewInterview(id) {
    window.location.href = '<?= base_url('Interview/view_calendar/') ?>' + id;
}

function editInterview(id) {
    window.location.href = '<?= base_url('Interview/edit/') ?>' + id;
}

function deleteInterview(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the interview permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Interview/delete/') ?>' + id;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this interview?')) {
            window.location.href = '<?= base_url('Interview/delete/') ?>' + id;
        }
    }
}
</script>

<?php
// Load the footer template
$this->load->view('templates/admin_footer');
?>
