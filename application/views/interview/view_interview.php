<style>
.view-interview-container {
    padding: 30px;
    max-width: 1000px;
    margin: 0 auto;
}

.interview-header {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 20px;
}

.interview-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.info-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.info-label {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

.interview-link {
    background: #e7f3ff;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
    border-left: 3px solid #667eea;
}

.responses-section {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
}

.response-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 15px;
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

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}
</style>

<div class="view-interview-container">
    <div class="interview-header">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1>📋 Interview Details</h1>
                <h2><?= htmlspecialchars($interview['job_title']) ?></h2>
            </div>
            <?php
            $badge_class = 'badge-warning';
            if ($interview['status'] === 'in_progress') $badge_class = 'badge-info';
            if ($interview['status'] === 'completed') $badge_class = 'badge-success';
            if ($interview['status'] === 'expired') $badge_class = 'badge-danger';
            ?>
            <span class="badge <?= $badge_class ?>">
                <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?>
            </span>
        </div>

        <div class="interview-info">
            <div class="info-item">
                <div class="info-label">Candidate</div>
                <div class="info-value"><?= htmlspecialchars($interview['candidate_name']) ?></div>
                <small><?= htmlspecialchars($interview['candidate_email']) ?></small>
            </div>
            <div class="info-item">
                <div class="info-label">Created</div>
                <div class="info-value"><?= date('M j, Y H:i', strtotime($interview['created_at'])) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Expires</div>
                <div class="info-value"><?= date('M j, Y H:i', strtotime($interview['expires_at'])) ?></div>
            </div>
            <?php if ($interview['score'] !== null): ?>
            <div class="info-item">
                <div class="info-label">Score</div>
                <div class="info-value"><?= $interview['score'] ?>%</div>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($interview['status'] !== 'completed'): ?>
        <div class="interview-link">
            <strong>Interview Link:</strong><br>
            <a href="<?= $interview_link ?>" target="_blank"><?= $interview_link ?></a>
            <button onclick="copyLink()" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-copy"></i> Copy
            </button>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($responses)): ?>
    <div class="responses-section">
        <h3>Candidate Responses</h3>
        <?php foreach ($responses as $response): ?>
        <div class="response-item">
            <strong>Q: <?= htmlspecialchars($response['question']) ?></strong>
            <p style="margin-top: 10px; color: #666;">
                <?= htmlspecialchars($response['response_text']) ?>
            </p>
            <small style="color: #999;">
                Duration: <?= $response['duration'] ?>s
            </small>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Interviews
        </a>
    </div>
</div>

<script>
function copyLink() {
    const link = '<?= $interview_link ?>';
    navigator.clipboard.writeText(link).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
