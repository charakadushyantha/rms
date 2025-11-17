<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Management - RMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/interview-management.css') ?>">
</head>
<body>
    <div class="management-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-calendar-check"></i> Interview Management</h1>
                <nav class="breadcrumb">
                    <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                    <span>/</span>
                    <span>Interviews</span>
                </nav>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="exportReport()">
                    <i class="fas fa-download"></i> Export Report
                </button>
                <button class="btn btn-primary" onclick="scheduleInterview()">
                    <i class="fas fa-plus"></i> Schedule Interview
                </button>
            </div>
        </div>

        <!-- Statistics Dashboard -->
        <div class="stats-grid">
            <div class="stat-card stat-scheduled">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['scheduled'] ?? 0 ?></div>
                    <div class="stat-label">Scheduled</div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 12% from last week
                    </div>
                </div>
            </div>

            <div class="stat-card stat-completed">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['completed'] ?? 0 ?></div>
                    <div class="stat-label">Completed</div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 8% from last week
                    </div>
                </div>
            </div>

            <div class="stat-card stat-pending">
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['pending'] ?? 0 ?></div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-trend neutral">
                        <i class="fas fa-minus"></i> No change
                    </div>
                </div>
            </div>

            <div class="stat-card stat-cancelled">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['cancelled'] ?? 0 ?></div>
                    <div class="stat-label">Cancelled</div>
                    <div class="stat-trend negative">
                        <i class="fas fa-arrow-down"></i> 3% from last week
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="content-layout">
            <!-- Left Column - Interview List -->
            <div class="main-content">
                <!-- Advanced Filters -->
                <div class="filters-section">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label><i class="fas fa-search"></i> Search</label>
                            <input type="text" id="search-input" placeholder="Search by candidate name, position..." class="form-control">
                        </div>
                        
                        <div class="filter-group">
                            <label><i class="fas fa-filter"></i> Status</label>
                            <select id="status-filter" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label><i class="fas fa-briefcase"></i> Position</label>
                            <select id="position-filter" class="form-control">
                                <option value="">All Positions</option>
                                <?php foreach ($positions as $position): ?>
                                <option value="<?= $position ?>"><?= htmlspecialchars($position) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label><i class="fas fa-calendar"></i> Date Range</label>
                            <input type="date" id="date-from" class="form-control" placeholder="From">
                        </div>
                        
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <input type="date" id="date-to" class="form-control" placeholder="To">
                        </div>
                        
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" onclick="applyFilters()">
                                <i class="fas fa-search"></i> Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Interview List -->
                <div class="interview-list">
                    <?php if (!empty($interviews)): ?>
                        <?php foreach ($interviews as $interview): ?>
                        <div class="interview-card" data-id="<?= $interview['id'] ?>">
                            <div class="interview-header">
                                <div class="interview-title">
                                    <h3><?= htmlspecialchars($interview['candidate_name'] ?? 'Unknown Candidate') ?></h3>
                                    <span class="position-badge"><?= htmlspecialchars($interview['job_title'] ?? 'Position Not Set') ?></span>
                                </div>
                                <div class="interview-status">
                                    <span class="status-badge status-<?= $interview['status'] ?>">
                                        <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="interview-details">
                                <div class="detail-item">
                                    <i class="fas fa-calendar"></i>
                                    <span><?= isset($interview['created_at']) ? date('M d, Y', strtotime($interview['created_at'])) : 'Not Set' ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <span><?= isset($interview['created_at']) ? date('h:i A', strtotime($interview['created_at'])) : 'Not Set' ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-envelope"></i>
                                    <span><?= htmlspecialchars($interview['candidate_email'] ?? 'No Email') ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-link"></i>
                                    <span>Token: <?= substr($interview['token'] ?? '', 0, 8) ?>...</span>
                                </div>
                            </div>

                            <div class="interview-actions">
                                <button class="btn btn-sm btn-primary" onclick="viewInterview(<?= $interview['id'] ?>)">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-secondary" onclick="rescheduleInterview(<?= $interview['id'] ?>)">
                                    <i class="fas fa-calendar-alt"></i> Reschedule
                                </button>
                                <button class="btn btn-sm btn-info" onclick="sendReminder(<?= $interview['id'] ?>)">
                                    <i class="fas fa-envelope"></i> Reminder
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="cancelInterview(<?= $interview['id'] ?>)">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button class="btn btn-sm btn-link" onclick="toggleDetails(<?= $interview['id'] ?>)">
                                    <i class="fas fa-chevron-down"></i> More
                                </button>
                            </div>

                            <!-- Expandable Details -->
                            <div class="interview-expanded" id="details-<?= $interview['id'] ?>" style="display: none;">
                                <div class="expanded-content">
                                    <div class="info-section">
                                        <h4>Candidate Information</h4>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($interview['candidate_email'] ?? 'Not provided') ?></p>
                                        <p><strong>Phone:</strong> <?= htmlspecialchars($interview['candidate_phone'] ?? 'Not provided') ?></p>
                                        <p><strong>Token:</strong> <?= htmlspecialchars($interview['token'] ?? 'N/A') ?></p>
                                    </div>

                                    <div class="info-section">
                                        <h4>Interview Details</h4>
                                        <p><strong>Status:</strong> <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?></p>
                                        <p><strong>Created:</strong> <?= isset($interview['created_at']) ? date('M d, Y h:i A', strtotime($interview['created_at'])) : 'N/A' ?></p>
                                        <p><strong>Expires:</strong> <?= isset($interview['expires_at']) ? date('M d, Y h:i A', strtotime($interview['expires_at'])) : 'N/A' ?></p>
                                        <?php if (isset($interview['started_at']) && $interview['started_at']): ?>
                                        <p><strong>Started:</strong> <?= date('M d, Y h:i A', strtotime($interview['started_at'])) ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($interview['completed_at']) && $interview['completed_at']): ?>
                                        <p><strong>Completed:</strong> <?= date('M d, Y h:i A', strtotime($interview['completed_at'])) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($interview['status'] === 'completed' && isset($interview['score'])): ?>
                                    <div class="info-section">
                                        <h4>Results</h4>
                                        <p><strong>Score:</strong> <?= $interview['score'] ?>%</p>
                                        <div class="rating">
                                            <?php 
                                            $rating = isset($interview['score']) ? round($interview['score'] / 20) : 0;
                                            for ($i = 1; $i <= 5; $i++): 
                                            ?>
                                                <i class="fas fa-star <?= $i <= $rating ? 'active' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>No Interviews Found</h3>
                            <p>Schedule your first interview to get started</p>
                            <button class="btn btn-primary" onclick="scheduleInterview()">
                                <i class="fas fa-plus"></i> Schedule Interview
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($interviews)): ?>
                <div class="pagination">
                    <button class="btn btn-sm" <?= $page <= 1 ? 'disabled' : '' ?> onclick="changePage(<?= $page - 1 ?>)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span class="page-info">Page <?= $page ?> of <?= $total_pages ?></span>
                    <button class="btn btn-sm" <?= $page >= $total_pages ? 'disabled' : '' ?> onclick="changePage(<?= $page + 1 ?>)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="sidebar">
                <!-- Calendar Widget -->
                <div class="widget calendar-widget">
                    <div class="widget-header">
                        <h3><i class="fas fa-calendar"></i> Calendar</h3>
                        <div class="calendar-nav">
                            <button onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                            <span id="current-month">November 2025</span>
                            <button onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="mini-calendar">
                            <div class="calendar-weekdays">
                                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                            </div>
                            <div class="calendar-days" id="calendar-days">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        
                        <div class="today-interviews">
                            <h4>Today's Interviews</h4>
                            <?php if (!empty($today_interviews)): ?>
                                <?php foreach ($today_interviews as $interview): ?>
                                <div class="today-item">
                                    <div class="time"><?= isset($interview['created_at']) ? date('h:i A', strtotime($interview['created_at'])) : 'N/A' ?></div>
                                    <div class="info">
                                        <strong><?= htmlspecialchars($interview['candidate_name'] ?? 'Unknown') ?></strong>
                                        <span><?= htmlspecialchars($interview['position'] ?? $interview['job_title'] ?? 'Position Not Set') ?></span>
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
                <div class="widget quick-actions-widget">
                    <div class="widget-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="widget-body">
                        <button class="quick-action-btn" onclick="openEmailTemplates()">
                            <i class="fas fa-envelope"></i>
                            <span>Email Templates</span>
                        </button>

                        <button class="quick-action-btn" onclick="manageInterviewers()">
                            <i class="fas fa-users"></i>
                            <span>Interviewer Panel</span>
                        </button>
                        <button class="quick-action-btn" onclick="viewFeedbackForms()">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Feedback Forms</span>
                        </button>
                        <button class="quick-action-btn" onclick="viewNotifications()">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </button>
                        <button class="quick-action-btn" onclick="generateReports()">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </button>
                        <button class="quick-action-btn" onclick="viewSettings()">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </button>
                    </div>
                </div>

                <!-- Upcoming Interviews Widget -->
                <div class="widget upcoming-widget">
                    <div class="widget-header">
                        <h3><i class="fas fa-clock"></i> Upcoming This Week</h3>
                    </div>
                    <div class="widget-body">
                        <?php if (!empty($upcoming_interviews)): ?>
                            <?php foreach ($upcoming_interviews as $interview): ?>
                            <div class="upcoming-item">
                                <div class="upcoming-date">
                                    <div class="day"><?= isset($interview['created_at']) ? date('d', strtotime($interview['created_at'])) : '00' ?></div>
                                    <div class="month"><?= isset($interview['created_at']) ? date('M', strtotime($interview['created_at'])) : 'N/A' ?></div>
                                </div>
                                <div class="upcoming-info">
                                    <strong><?= htmlspecialchars($interview['candidate_name'] ?? 'Unknown') ?></strong>
                                    <span><?= htmlspecialchars($interview['position'] ?? $interview['job_title'] ?? 'Position Not Set') ?></span>
                                    <small><?= isset($interview['created_at']) ? date('h:i A', strtotime($interview['created_at'])) : 'N/A' ?></small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="no-interviews">No upcoming interviews this week</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/interview-management.js') ?>"></script>
</body>
</html>
