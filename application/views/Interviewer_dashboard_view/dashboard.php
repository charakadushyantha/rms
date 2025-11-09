<?php
$data['page_title'] = 'Interviewer Dashboard';
$data['use_calendar'] = false;
$this->load->view('templates/interviewer_header', $data);
?>

<style>
.dashboard-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
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

.stat-icon.purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-icon.orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.stat-icon.blue {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.stat-icon.green {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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

.interview-item {
    padding: 1rem;
    border-left: 4px solid #667eea;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 1rem;
    transition: all 0.2s;
}

.interview-item:hover {
    background: #f3f4f6;
    transform: translateX(4px);
}

.interview-time {
    font-size: 0.875rem;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.interview-candidate {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.interview-position {
    font-size: 0.875rem;
    color: #6b7280;
}

.feedback-item {
    padding: 1rem;
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.feedback-candidate {
    font-weight: 600;
    color: #92400e;
    margin-bottom: 0.25rem;
}

.feedback-date {
    font-size: 0.875rem;
    color: #78350f;
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
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5568d3;
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
        <h1><i class="fas fa-user-tie me-2"></i>Welcome back, <?php echo htmlspecialchars($uname); ?>!</h1>
        <p>Here's your interview schedule and pending tasks for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['total_interviews']; ?></div>
                    <div class="stat-label">Total Interviews</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['pending_feedback']; ?></div>
                    <div class="stat-label">Pending Feedback</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['week_interviews']; ?></div>
                    <div class="stat-label">This Week</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <div class="stat-value"><?php echo $stats['avg_rating']; ?></div>
                    <div class="stat-label">Avg Rating Given</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Today's Interviews -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-calendar-day me-2"></i>Today's Interviews
                </h2>
                <a href="<?php echo base_url('I_dashboard/schedule'); ?>" class="btn-action btn-primary">
                    <i class="fas fa-calendar me-2"></i>View Full Schedule
                </a>
            </div>

            <?php if (!empty($today_interviews)): ?>
                <?php foreach ($today_interviews as $interview): ?>
                    <div class="interview-item">
                        <div class="interview-time">
                            <i class="fas fa-clock me-1"></i>
                            <?php echo date('h:i A', strtotime($interview['assigned_at'])); ?>
                        </div>
                        <div class="interview-candidate">
                            <?php echo htmlspecialchars($interview['Can_name']); ?>
                        </div>
                        <div class="interview-position">
                            <?php echo htmlspecialchars($interview['Can_position']); ?>
                        </div>
                        <div class="mt-2">
                            <button class="btn-action btn-primary btn-sm" onclick="viewCandidate(<?php echo $interview['candidate_id']; ?>)">
                                <i class="fas fa-user me-1"></i>View Details
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <p>No interviews scheduled for today</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pending Feedback -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-clipboard-list me-2"></i>Pending Feedback
                </h2>
            </div>

            <?php if (!empty($pending_feedback)): ?>
                <?php foreach ($pending_feedback as $feedback): ?>
                    <div class="feedback-item">
                        <div class="feedback-candidate">
                            <?php echo htmlspecialchars($feedback['Can_name']); ?>
                        </div>
                        <div class="feedback-date">
                            <?php echo htmlspecialchars($feedback['Can_position']); ?>
                        </div>
                        <div class="mt-2">
                            <a href="<?php echo base_url('I_dashboard/feedback/' . $feedback['interview_id']); ?>" 
                               class="btn-action btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Submit Feedback
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <p>All caught up!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upcoming Interviews -->
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-calendar-alt me-2"></i>Upcoming Interviews
            </h2>
        </div>

        <?php if (!empty($upcoming_interviews)): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Candidate</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcoming_interviews as $interview): ?>
                            <tr>
                                <td><?php echo date('M d, Y h:i A', strtotime($interview['assigned_at'])); ?></td>
                                <td><?php echo htmlspecialchars($interview['Can_name']); ?></td>
                                <td><?php echo htmlspecialchars($interview['Can_position']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $interview['status'] == 'accepted' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($interview['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="viewCandidate(<?php echo $interview['candidate_id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>No upcoming interviews</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function viewCandidate(candidateId) {
    // Implement candidate details modal
    alert('View candidate details: ' + candidateId);
}
</script>

<?php
$this->load->view('templates/interviewer_footer', $data);
?>
