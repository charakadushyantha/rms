<style>
.form-container {
    max-width: 900px;
    margin: 30px auto;
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
}

.question-item {
    background: #f5f6fa;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.btn {
    padding: 12px 24px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
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

.btn-success {
    background: #28a745;
    color: white;
}
</style>

<div class="form-container">
    <h1>Create Interview Flow</h1>
    <p>Define your interview template with custom questions</p>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('interview/create_flow') ?>">
        
        <!-- Basic Information -->
        <div class="form-group">
            <label>Job Title *</label>
            <input type="text" name="job_title" class="form-control" required placeholder="e.g., Software Engineer">
        </div>

        <div class="form-group">
            <label>Job Description</label>
            <textarea name="job_description" class="form-control" rows="4" placeholder="Brief description of the position..."></textarea>
        </div>

        <div class="form-group">
            <label>Interview Type *</label>
            <select name="interview_type" class="form-control" required>
                <option value="video">Video Interview</option>
                <option value="audio">Audio Interview</option>
                <option value="text">Text Interview</option>
            </select>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="enable_video_capture" value="1">
                Enable Video Recording
            </label>
        </div>

        <div class="form-group">
            <label>Total Duration (minutes) *</label>
            <input type="number" name="duration_minutes" class="form-control" value="30" required min="5" max="120">
        </div>

        <div class="form-group">
            <label>Passing Score (%) *</label>
            <input type="number" name="passing_score" class="form-control" value="70" required min="0" max="100">
        </div>

        <!-- Questions -->
        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <label style="margin: 0;">Interview Questions *</label>
                <button type="button" class="btn btn-success" onclick="addQuestion()">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </div>
            
            <div id="questions-container">
                <!-- Questions will be added here -->
                <div class="question-item">
                    <div class="question-header">
                        <strong>Question 1</strong>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion(this)">Remove</button>
                    </div>
                    <textarea name="questions[]" class="form-control" rows="3" required placeholder="Enter your question..."></textarea>
                    <div style="margin-top: 10px;">
                        <label>Duration (seconds):</label>
                        <input type="number" name="durations[]" class="form-control" value="120" min="30" max="300" style="width: 150px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="form-group" style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Interview Flow
            </button>
            <a href="<?= base_url('interview/flows') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
let questionCount = 1;

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questions-container');
    const questionHtml = `
        <div class="question-item">
            <div class="question-header">
                <strong>Question ${questionCount}</strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion(this)">Remove</button>
            </div>
            <textarea name="questions[]" class="form-control" rows="3" required placeholder="Enter your question..."></textarea>
            <div style="margin-top: 10px;">
                <label>Duration (seconds):</label>
                <input type="number" name="durations[]" class="form-control" value="120" min="30" max="300" style="width: 150px;">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', questionHtml);
}

function removeQuestion(button) {
    const container = document.getElementById('questions-container');
    if (container.children.length > 1) {
        button.closest('.question-item').remove();
        updateQuestionNumbers();
    } else {
        alert('You must have at least one question.');
    }
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((item, index) => {
        item.querySelector('strong').textContent = `Question ${index + 1}`;
    });
    questionCount = questions.length;
}
</script>
