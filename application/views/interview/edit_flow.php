<style>
.edit-flow-container {
    padding: 30px;
    max-width: 900px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

.question-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 15px;
    border-left: 3px solid #667eea;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
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

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 12px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<div class="edit-flow-container">
    <h1>✏️ Edit Interview Flow</h1>
    <p>Update your interview template</p>

    <?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?= validation_errors() ?>
    </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="post" action="<?= base_url('interview/edit_flow/' . $flow['id']) ?>">
            <div class="form-group">
                <label for="job_title">Job Title *</label>
                <input type="text" class="form-control" id="job_title" name="job_title" 
                       value="<?= htmlspecialchars($flow['job_title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="job_description">Job Description</label>
                <textarea class="form-control" id="job_description" name="job_description"><?= htmlspecialchars($flow['job_description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="interview_type">Interview Type *</label>
                <select class="form-control" id="interview_type" name="interview_type" required>
                    <option value="video" <?= $flow['interview_type'] === 'video' ? 'selected' : '' ?>>Video Interview</option>
                    <option value="text" <?= $flow['interview_type'] === 'text' ? 'selected' : '' ?>>Text Interview</option>
                    <option value="audio" <?= $flow['interview_type'] === 'audio' ? 'selected' : '' ?>>Audio Interview</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="enable_video_capture" value="1" 
                           <?= $flow['enable_video_capture'] ? 'checked' : '' ?>>
                    Enable Video Recording
                </label>
            </div>

            <div class="form-group">
                <label for="duration_minutes">Total Duration (minutes) *</label>
                <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" 
                       value="<?= $flow['duration_minutes'] ?>" min="5" max="180" required>
            </div>

            <div class="form-group">
                <label for="passing_score">Passing Score (%) *</label>
                <input type="number" class="form-control" id="passing_score" name="passing_score" 
                       value="<?= $flow['passing_score'] ?>" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" <?= $flow['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $flow['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="archived" <?= $flow['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                </select>
            </div>

            <div class="form-group">
                <label>Interview Questions</label>
                <div id="questions-container">
                    <?php 
                    $questions = is_array($flow['questions']) ? $flow['questions'] : json_decode($flow['questions'], true);
                    foreach ($questions as $index => $question): 
                    ?>
                    <div class="question-item">
                        <div class="question-header">
                            <strong>Question <?= $index + 1 ?></strong>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion(this)">Remove</button>
                        </div>
                        <input type="text" class="form-control" name="questions[]" 
                               value="<?= htmlspecialchars($question['question']) ?>" 
                               placeholder="Enter question" required>
                        <div style="margin-top: 10px;">
                            <label>Duration (seconds)</label>
                            <input type="number" class="form-control" name="durations[]" 
                                   value="<?= $question['duration'] ?>" min="30" max="600">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="addQuestion()">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Flow
                </button>
                <a href="<?= base_url('interview/flows') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
let questionCount = <?= count($questions) ?>;

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questions-container');
    const questionHtml = `
        <div class="question-item">
            <div class="question-header">
                <strong>Question ${questionCount}</strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion(this)">Remove</button>
            </div>
            <input type="text" class="form-control" name="questions[]" placeholder="Enter question" required>
            <div style="margin-top: 10px;">
                <label>Duration (seconds)</label>
                <input type="number" class="form-control" name="durations[]" value="120" min="30" max="600">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', questionHtml);
}

function removeQuestion(btn) {
    btn.closest('.question-item').remove();
}
</script>
