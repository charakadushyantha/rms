<style>
.flows-container {
    padding: 30px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.btn {
    padding: 12px 24px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 12px;
}

.flows-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.flow-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.flow-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.flow-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
}

.flow-header h3 {
    margin: 0 0 10px 0;
    font-size: 18px;
}

.flow-meta {
    font-size: 14px;
    opacity: 0.9;
}

.flow-body {
    padding: 20px;
}

.flow-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.stat-item {
    text-align: center;
    padding: 10px;
    background: #f5f6fa;
    border-radius: 5px;
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: #667eea;
}

.stat-label {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.flow-description {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 20px;
}

.flow-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success { background: #d4edda; color: #155724; }
.badge-warning { background: #fff3cd; color: #856404; }
.badge-danger { background: #f8d7da; color: #721c24; }

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state i {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<div class="flows-container">
    <div class="page-header">
        <div>
            <h1>📋 Interview Flows</h1>
            <p>Manage your interview templates and questions</p>
        </div>
        <a href="<?= base_url('interview/create_flow') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Flow
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($flows)): ?>
    <div class="flows-grid">
        <?php foreach ($flows as $flow): ?>
        <div class="flow-card">
            <div class="flow-header">
                <h3><?= htmlspecialchars($flow['job_title']) ?></h3>
                <div class="flow-meta">
                    <i class="fas fa-video"></i> <?= ucfirst($flow['interview_type']) ?> Interview
                    <?php if ($flow['enable_video_capture']): ?>
                    <i class="fas fa-record-vinyl" title="Video Recording Enabled"></i>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="flow-body">
                <div class="flow-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?= is_array($flow['questions']) ? count($flow['questions']) : count(json_decode($flow['questions'], true)) ?></div>
                        <div class="stat-label">Questions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= $flow['duration_minutes'] ?></div>
                        <div class="stat-label">Minutes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= $flow['passing_score'] ?>%</div>
                        <div class="stat-label">Pass Score</div>
                    </div>
                </div>

                <?php if (!empty($flow['job_description'])): ?>
                <div class="flow-description">
                    <?= htmlspecialchars(substr($flow['job_description'], 0, 150)) ?>
                    <?= strlen($flow['job_description']) > 150 ? '...' : '' ?>
                </div>
                <?php endif; ?>

                <div style="margin-bottom: 15px;">
                    <?php
                    $badge_class = 'badge-success';
                    if ($flow['status'] === 'inactive') $badge_class = 'badge-warning';
                    if ($flow['status'] === 'archived') $badge_class = 'badge-danger';
                    ?>
                    <span class="badge <?= $badge_class ?>"><?= ucfirst($flow['status']) ?></span>
                    <small style="color: #999; margin-left: 10px;">
                        Created: <?= date('M j, Y', strtotime($flow['created_at'])) ?>
                    </small>
                </div>

                <div class="flow-actions">
                    <a href="<?= base_url('interview/edit_flow/' . $flow['id']) ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('interview/create_interview?flow_id=' . $flow['id']) ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-link"></i> Create Interview
                    </a>
                    <?php if ($flow['status'] === 'active'): ?>
                    <a href="<?= base_url('interview/interviews?flow_id=' . $flow['id']) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-list"></i> View Interviews
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-clipboard-list"></i>
        <h3>No Interview Flows Yet</h3>
        <p>Create your first interview flow to get started with candidate interviews.</p>
        <a href="<?= base_url('interview/create_flow') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Your First Flow
        </a>
    </div>
    <?php endif; ?>
</div>
