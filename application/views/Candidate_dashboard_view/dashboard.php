<?php
$data['page_title'] = 'Candidate Dashboard';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.dashboard-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.welcome-section {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(20, 184, 166, 0.3);
}

.welcome-section h1 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.welcome-section p {
    margin: 0;
    opacity: 0.9;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.stat-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.teal {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    color: white;
}

.stat-icon.blue {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.stat-icon.green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.stat-icon.orange {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.application-item {
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid #14b8a6;
    transition: all 0.2s;
}

.application-item:hover {
    background: #f3f4f6;
    transform: translateX(4px);
}

.application-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.application-company {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-applied {
    background: #dbeafe;
    color: #1e40af;
}

.status-screening {
    background: #fef3c7;
    color: #92400e;
}

.status-interview_scheduled {
    background: #d1fae5;
    color: #065f46;
}

.status-interviewed {
    background: #e0e7ff;
    color: #4338ca;
}

.interview-item {
    padding: 1rem;
    background: #ecfdf5;
    border-left: 4px solid #10b981;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.interview-date {
    font-size: 0.875rem;
    color: #059669;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.interview-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.interview-time {
    font-size: 0.875rem;
    color: #6b7280;
}

.btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #14b8a6;
    color: white;
}

.btn-primary:hover {
    background: #0d9488;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #9ca3af;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1><i class="fas fa-user-graduate me-2"></i>Welcome back, <?php echo htmlspecialchars($uname); ?>!</h1>
        <p>Track your applications and manage your interview schedule</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon teal">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
                    <div class="stat-label">Total Applications</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['active_applications']; ?></div>
                    <div class="stat-label">Active Applications</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['total_interviews']; ?></div>
                    <div class="stat-label">Interviews</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['unread_messages']; ?></div>
                    <div class="stat-label">Unread Messages</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Recent Applications -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-briefcase me-2"></i>Recent Applications
                </h2>
                <a href="<?php echo base_url('C_dashboard/applications'); ?>" class="btn-action btn-primary">
                    <i class="fas fa-list me-2"></i>View All
                </a>
            </div>

            <?php if (!empty($applications)): ?>
                <?php foreach (array_slice($applications, 0, 5) as $app): ?>
                    <div class="application-item">
                        <div class="application-title"><?php echo htmlspecialchars($app['job_title']); ?></div>
                        <div class="application-company">Applied on <?php echo date('M d, Y', strtotime($app['applied_at'])); ?></div>
                        <span class="status-badge status-<?php echo $app['status']; ?>">
                            <?php echo ucwords(str_replace('_', ' ', $app['status'])); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-briefcase"></i>
                    <p>No applications yet</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Interviews -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Interviews
                </h2>
            </div>

            <?php if (!empty($upcoming_interviews)): ?>
                <?php foreach ($upcoming_interviews as $interview): ?>
                    <div class="interview-item">
                        <div class="interview-date">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo date('M d, Y', strtotime($interview['assigned_at'])); ?>
                        </div>
                        <div class="interview-title">Interview</div>
                        <div class="interview-time">
                            <i class="fas fa-clock me-1"></i>
                            <?php echo date('h:i A', strtotime($interview['assigned_at'])); ?>
                        </div>
                        <div class="mt-2">
                            <a href="<?php echo base_url('C_dashboard/interviews'); ?>" class="btn-action btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No upcoming interviews</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$this->load->view('templates/candidate_footer', $data);
?>
