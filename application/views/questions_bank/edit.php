<?php
$data['page_title'] = 'Edit Question';
$this->load->view('templates/admin_header', $data);
?>

<style>
.edit-question-container {
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 20px;
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
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.options-container {
    margin-top: 15px;
}

.option-item {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.option-item input[type="text"] {
    flex: 1;
}

.option-item input[type="checkbox"] {
    width: 20px;
    height: 20px;
}

.btn {
    padding: 12px 24px;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-success {
    background: #38a169;
    color: white;
}

.btn-secondary {
    background: #718096;
    color: white;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 12px;
}

.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>

<div class="edit-question-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1><i class="fas fa-edit"></i> Edit Question</h1>
            <p>Update question details</p>
        </div>
        <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="form-card">
        <form method="post" action="<?= base_url('questions_bank/edit/' . $question['id']) ?>" id="question-form">
            
            <div class="form-group">
                <label for="question_text">Question Text *</label>
                <textarea name="question_text" id="question_text" class="form-control" required><?= htmlspecialchars($question['question_text']) ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="question_type">Question Type *</label>
                    <select name="question_type" id="question_type" class="form-control" required onchange="toggleOptions()">
                        <option value="mcq_single" <?= $question['question_type'] == 'mcq_single' ? 'selected' : '' ?>>Multiple Choice (Single Answer)</option>
                        <option value="mcq_multiple" <?= $question['question_type'] == 'mcq_multiple' ? 'selected' : '' ?>>Multiple Choice (Multiple Answers)</option>
                        <option value="descriptive" <?= $question['question_type'] == 'descriptive' ? 'selected' : '' ?>>Descriptive</option>
                        <option value="text" <?= $question['question_type'] == 'text' ? 'selected' : '' ?>>Text Answer</option>
                        <option value="rating" <?= $question['question_type'] == 'rating' ? 'selected' : '' ?>>Rating Scale</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $question['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="difficulty">Difficulty *</label>
                    <select name="difficulty" id="difficulty" class="form-control" required>
                        <option value="easy" <?= $question['difficulty'] == 'easy' ? 'selected' : '' ?>>Easy</option>
                        <option value="medium" <?= $question['difficulty'] == 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="hard" <?= $question['difficulty'] == 'hard' ? 'selected' : '' ?>>Hard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="points">Points *</label>
                    <input type="number" name="points" id="points" class="form-control" value="<?= $question['points'] ?>" min="1" max="100" required>
                </div>

                <div class="form-group">
                    <label for="time_limit">Time Limit (seconds) *</label>
                    <input type="number" name="time_limit" id="time_limit" class="form-control" value="<?= $question['time_limit'] ?>" min="30" max="600" required>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_mandatory" value="1" <?= $question['is_mandatory'] ? 'checked' : '' ?>>
                    Mark as Mandatory (will appear in all interviews)
                </label>
            </div>

            <!-- MCQ Options -->
            <div id="options-section" class="form-group" style="display: <?= in_array($question['question_type'], ['mcq_single', 'mcq_multiple']) ? 'block' : 'none' ?>;">
                <label>Answer Options</label>
                <div class="options-container" id="options-container">
                    <?php if (!empty($question['options'])): ?>
                        <?php foreach ($question['options'] as $index => $option): ?>
                            <div class="option-item">
                                <input type="text" name="options[]" class="form-control" value="<?= htmlspecialchars($option['option_text']) ?>" placeholder="Option <?= $index + 1 ?>">
                                <input type="checkbox" name="correct_options[]" value="<?= $index ?>" <?= $option['is_correct'] ? 'checked' : '' ?> title="Mark as correct">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="removeOption(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="option-item">
                            <input type="text" name="options[]" class="form-control" placeholder="Option 1">
                            <input type="checkbox" name="correct_options[]" value="0" title="Mark as correct">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="removeOption(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="addOption()">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>

            <div class="form-group">
                <label>Applicable Job Roles</label>
                <div class="checkbox-group">
                    <?php 
                    $selected_roles = array_column($question['roles'], 'id');
                    foreach ($roles as $role): 
                    ?>
                    <div class="checkbox-item">
                        <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" id="role_<?= $role['id'] ?>" 
                               <?= in_array($role['id'], $selected_roles) ? 'checked' : '' ?>>
                        <label for="role_<?= $role['id'] ?>"><?= htmlspecialchars($role['title']) ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Question
                </button>
                <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
let optionCount = <?= !empty($question['options']) ? count($question['options']) : 1 ?>;

function toggleOptions() {
    const type = document.getElementById('question_type').value;
    const optionsSection = document.getElementById('options-section');
    
    if (type === 'mcq_single' || type === 'mcq_multiple') {
        optionsSection.style.display = 'block';
    } else {
        optionsSection.style.display = 'none';
    }
}

function addOption() {
    optionCount++;
    const container = document.getElementById('options-container');
    const optionHtml = `
        <div class="option-item">
            <input type="text" name="options[]" class="form-control" placeholder="Option ${optionCount}">
            <input type="checkbox" name="correct_options[]" value="${optionCount - 1}" title="Mark as correct">
            <button type="button" class="btn btn-secondary btn-sm" onclick="removeOption(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', optionHtml);
}

function removeOption(btn) {
    if (document.querySelectorAll('.option-item').length > 1) {
        btn.closest('.option-item').remove();
    } else {
        alert('At least one option is required');
    }
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>
