<style>
.interview-dashboard {
    padding: 30px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-left: 4px solid #667eea;
}

.stat-card h3 {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
}

.stat-card .value {
    font-size: 36px;
    font-weight: 700;
    color: #667eea;
}

.section {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f5f6fa;
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #333;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success { background: #d4edda; color: #155724; }
.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #d1ecf1; color: #0c5460; }
.badge-danger { background: #f8d7da; color: #721c24; }
</style>

<div class="interview-dashboard">
    <h1>📋 Interview Management</h1>
    <p>Manage interview flows and track candidate interviews</p>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Interviews</h3>
            <div class="value"><?= $statistics['total'] ?? 0 ?></div>
        </div>
        <div class="stat-card">
            <h3>Completed</h3>
            <div class="value"><?= $statistics['completed'] ?? 0 ?></div>
        </div>
        <div class="stat-card">
            <h3>Pending</h3>
            <div class="value"><?= $statistics['pending'] ?? 0 ?></div>
        </div>
        <div class="stat-card">
            <h3>In Progress</h3>
            <div class="value"><?= $statistics['in_progress'] ?? 0 ?></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section">
        <div class="section-header">
            <h2>Quick Actions</h2>
        </div>
        <a href="<?= base_url('interview/create_flow') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Interview Flow
        </a>
        <a href="<?= base_url('interview/create_interview') ?>" class="btn btn-primary">
            <i class="fas fa-link"></i> Create Interview Link
        </a>
        <a href="<?= base_url('interview/flows') ?>" class="btn btn-secondary">
            <i class="fas fa-list"></i> View All Flows
        </a>
        <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">
            <i class="fas fa-users"></i> View All Interviews
        </a>
    </div>

    <!-- Active Interview Flows -->
    <div class="section">
        <div class="section-header">
            <h2>Active Interview Flows</h2>
            <a href="<?= base_url('interview/flows') ?>" class="btn btn-secondary">View All</a>
        </div>
        
        <?php if (!empty($flows)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Type</th>
                    <th>Questions</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flows as $flow): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($flow['job_title']) ?></strong></td>
                    <td><?= ucfirst($flow['interview_type']) ?></td>
                    <td><?= is_array($flow['questions']) ? count($flow['questions']) : count(json_decode($flow['questions'], true)) ?> questions</td>
                    <td><?= $flow['duration_minutes'] ?> min</td>
                    <td><span class="badge badge-success"><?= ucfirst($flow['status']) ?></span></td>
                    <td>
                        <a href="<?= base_url('interview/edit_flow/' . $flow['id']) ?>" class="btn btn-sm">Edit</a>
                        <a href="<?= base_url('interview/create_interview?flow_id=' . $flow['id']) ?>" class="btn btn-sm btn-primary">Create Interview</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No interview flows created yet. <a href="<?= base_url('interview/create_flow') ?>">Create one now</a></p>
        <?php endif; ?>
    </div>

    <!-- Recent Interviews -->
    <div class="section">
        <div class="section-header">
            <h2>Recent Interviews</h2>
            <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">View All</a>
        </div>
        
        <?php if (!empty($recent_interviews)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_interviews as $interview): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($interview['candidate_name'] ?: $interview['candidate_email']) ?></strong><br>
                        <small><?= htmlspecialchars($interview['candidate_email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($interview['job_title']) ?></td>
                    <td>
                        <?php
                        $badge_class = 'badge-info';
                        if ($interview['status'] === 'completed') $badge_class = 'badge-success';
                        if ($interview['status'] === 'expired') $badge_class = 'badge-danger';
                        if ($interview['status'] === 'in_progress') $badge_class = 'badge-warning';
                        ?>
                        <span class="badge <?= $badge_class ?>"><?= ucfirst(str_replace('_', ' ', $interview['status'])) ?></span>
                    </td>
                    <td><?= $interview['score'] ? $interview['score'] . '%' : '-' ?></td>
                    <td><?= date('M j, Y', strtotime($interview['created_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('interview/view/' . $interview['id']) ?>" class="btn btn-sm">View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No interviews created yet. <a href="<?= base_url('interview/create_interview') ?>">Create one now</a></p>
        <?php endif; ?>
    </div>
</div>
