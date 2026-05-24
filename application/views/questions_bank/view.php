<?php
$data['page_title'] = 'View Question';
$this->load->view('templates/admin_header', $data);
?>

<style>
.view-question-container {
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.question-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 20px;
}

.question-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.question-header h2 {
    margin: 0 0 10px 0;
    color: white;
}

.question-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.9);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.info-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.info-item label {
    font-weight: 600;
    color: #666;
    font-size: 13px;
    margin-bottom: 5px;
    display: block;
}

.info-item p {
    margin: 0;
    color: #333;
    font-size: 15px;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-easy { background: #c6f6d5; color: #22543d; }
.badge-medium { background: #feebc8; color: #7c2d12; }
.badge-hard { background: #fed7d7; color: #742a2a; }
.badge-mandatory { background: #ffecd2; color: #dd6b20; }
.badge-mcq { background: #d1ecf1; color: #0c5460; }
.badge-text { background: #e2e8f0; color: #2d3748; }
.badge-rating { background: #fef3c7; color: #78350f; }

.options-list {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.option-item {
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.option-item.correct {
    background: #c6f6d5;
    border-left: 4px solid #38a169;
}

.option-number {
    width: 30px;
    height: 30px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    flex-shrink: 0;
}

.option-item.correct .option-number {
    background: #38a169;
}

.roles-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.role-badge {
    padding: 8px 16px;
    background: #e2e8f0;
    color: #2d3748;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5568d3;
    transform: translateY(-2px);
}

.btn-warning {
    background: #dd6b20;
    color: white;
}

.btn-warning:hover {
    background: #c05621;
}

.btn-danger {
    background: #e53e3e;
    color: white;
}

.btn-danger:hover {
    background: #c53030;
}

.btn-secondary {
    background: #718096;
    color: white;
}

.btn-secondary:hover {
    background: #4a5568;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #667eea;
}
</style>

<div class="view-question-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1><i class="fas fa-eye"></i> View Question</h1>
            <p>Question details and information</p>
        </div>
        <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- Question Header -->
    <div class="question-header">
        <h2><?= htmlspecialchars($question['question_text']) ?></h2>
        <div class="question-meta">
            <div class="meta-item">
                <i class="fas fa-folder"></i>
                <span><?= htmlspecialchars($question['category_name'] ?? 'N/A') ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-signal"></i>
                <span><?= ucfirst($question['difficulty']) ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-star"></i>
                <span><?= $question['points'] ?> Points</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-clock"></i>
                <span><?= $question['time_limit'] ?> seconds</span>
            </div>
            <?php if ($question['is_mandatory']): ?>
            <div class="meta-item">
                <i class="fas fa-exclamation-circle"></i>
                <span>Mandatory</span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Question Details -->
    <div class="question-card">
        <div class="info-grid">
            <div class="info-item">
                <label><i class="fas fa-list-alt me-2"></i>Question Type</label>
                <p>
                    <?php
                    $type_labels = [
                        'mcq_single' => 'Multiple Choice (Single)',
                        'mcq_multiple' => 'Multiple Choice (Multiple)',
                        'descriptive' => 'Descriptive',
                        'text' => 'Text Answer',
                        'rating' => 'Rating Scale'
                    ];
                    echo $type_labels[$question['question_type']] ?? ucfirst(str_replace('_', ' ', $question['question_type']));
                    ?>
                </p>
            </div>

            <div class="info-item">
                <label><i class="fas fa-folder me-2"></i>Category</label>
                <p><?= htmlspecialchars($question['category_name'] ?? 'N/A') ?></p>
            </div>

            <div class="info-item">
                <label><i class="fas fa-signal me-2"></i>Difficulty Level</label>
                <p>
                    <span class="badge badge-<?= $question['difficulty'] ?>">
                        <?= ucfirst($question['difficulty']) ?>
                    </span>
                </p>
            </div>

            <div class="info-item">
                <label><i class="fas fa-star me-2"></i>Points</label>
                <p><?= $question['points'] ?> points</p>
            </div>

            <div class="info-item">
                <label><i class="fas fa-clock me-2"></i>Time Limit</label>
                <p><?= $question['time_limit'] ?> seconds (<?= round($question['time_limit'] / 60, 1) ?> minutes)</p>
            </div>

            <div class="info-item">
                <label><i class="fas fa-toggle-on me-2"></i>Status</label>
                <p>
                    <?php if ($question['is_mandatory']): ?>
                        <span class="badge badge-mandatory">Mandatory</span>
                    <?php else: ?>
                        <span class="badge" style="background: #e2e8f0; color: #2d3748;">Optional</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Answer Options (for MCQ) -->
        <?php if (in_array($question['question_type'], ['mcq_single', 'mcq_multiple']) && !empty($question['options'])): ?>
        <div style="margin-top: 30px;">
            <h3 class="section-title">
                <i class="fas fa-list-ul"></i>
                Answer Options
            </h3>
            <ul class="options-list">
                <?php foreach ($question['options'] as $index => $option): ?>
                <li class="option-item <?= $option['is_correct'] ? 'correct' : '' ?>">
                    <div class="option-number"><?= chr(65 + $index) ?></div>
                    <div style="flex: 1;">
                        <?= htmlspecialchars($option['option_text']) ?>
                        <?php if ($option['is_correct']): ?>
                            <i class="fas fa-check-circle" style="color: #38a169; margin-left: 10px;"></i>
                            <span style="color: #38a169; font-weight: 600; margin-left: 5px;">Correct Answer</span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Applicable Job Roles -->
        <?php if (!empty($question['roles'])): ?>
        <div style="margin-top: 30px;">
            <h3 class="section-title">
                <i class="fas fa-user-tie"></i>
                Applicable Job Roles
            </h3>
            <div class="roles-list">
                <?php foreach ($question['roles'] as $role): ?>
                <span class="role-badge">
                    <i class="fas fa-briefcase me-1"></i>
                    <?= htmlspecialchars($role['title']) ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <div style="margin-top: 30px;">
            <h3 class="section-title">
                <i class="fas fa-user-tie"></i>
                Applicable Job Roles
            </h3>
            <p class="text-muted">This question is not mapped to any specific job roles.</p>
        </div>
        <?php endif; ?>

        <!-- Tags (if available) -->
        <?php if (!empty($question['tags'])): ?>
        <div style="margin-top: 30px;">
            <h3 class="section-title">
                <i class="fas fa-tags"></i>
                Tags
            </h3>
            <div class="roles-list">
                <?php foreach ($question['tags'] as $tag): ?>
                <span class="role-badge" style="background: #fef3c7; color: #78350f;">
                    <i class="fas fa-tag me-1"></i>
                    <?= htmlspecialchars($tag['name']) ?>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid #e2e8f0;">
            <h3 class="section-title">
                <i class="fas fa-bolt"></i>
                Actions
            </h3>
            <div class="action-buttons">
                <a href="<?= base_url('questions_bank/edit/' . $question['id']) ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Question
                </a>
                <button onclick="deleteQuestion(<?= $question['id'] ?>)" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Question
                </button>
                <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function deleteQuestion(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete this question!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("questions_bank/delete/") ?>' + id;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this question?')) {
            window.location.href = '<?= base_url("questions_bank/delete/") ?>' + id;
        }
    }
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>
