<style>
.add-question-container {
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

.ai-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.ai-section h3 {
    margin-bottom: 15px;
}

.ai-input-group {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 15px;
    margin-top: 20px;
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

.btn-ai {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.ai-suggestions {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    display: none;
}

.suggestion-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.suggestion-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.loading {
    text-align: center;
    padding: 20px;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="add-question-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1><i class="fas fa-plus-circle"></i> Add Question</h1>
            <p>Create a new interview question or use AI to generate one</p>
        </div>
        <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- AI Question Generator -->
    <div class="ai-section">
        <h3><i class="fas fa-magic"></i> AI Question Generator</h3>
        <p>Let AI help you create interview questions based on job role and topic</p>
        
        <div class="ai-input-group">
            <div>
                <select id="ai-role" class="form-control" style="margin-bottom: 10px;">
                    <option value="">Select Job Role</option>
                    <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['title']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" id="ai-topic" class="form-control" placeholder="Enter topic (e.g., 'problem solving', 'teamwork', 'technical skills')">
            </div>
            <button type="button" class="btn btn-ai" onclick="generateAIQuestions()">
                <i class="fas fa-robot"></i> Generate Questions
            </button>
        </div>

        <div id="ai-suggestions" class="ai-suggestions">
            <h4>AI Generated Questions (Click to use)</h4>
            <div id="suggestions-list"></div>
        </div>
    </div>

    <!-- Manual Question Form -->
    <div class="form-card">
        <h3>Question Details</h3>
        <form method="post" action="<?= base_url('questions_bank/add') ?>" id="question-form">
            
            <div class="form-group">
                <label for="question_text">Question Text *</label>
                <textarea name="question_text" id="question_text" class="form-control" required placeholder="Enter your interview question here..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="question_type">Question Type *</label>
                    <select name="question_type" id="question_type" class="form-control" required onchange="toggleOptions()">
                        <option value="mcq_single">Multiple Choice (Single Answer)</option>
                        <option value="mcq_multiple">Multiple Choice (Multiple Answers)</option>
                        <option value="text">Text Answer</option>
                        <option value="rating">Rating Scale</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?> (<?= ucfirst($cat['type']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="difficulty">Difficulty *</label>
                    <select name="difficulty" id="difficulty" class="form-control" required>
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="points">Points *</label>
                    <input type="number" name="points" id="points" class="form-control" value="1" min="1" max="100" required>
                </div>

                <div class="form-group">
                    <label for="time_limit">Time Limit (seconds) *</label>
                    <input type="number" name="time_limit" id="time_limit" class="form-control" value="120" min="30" max="600" required>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_mandatory" value="1">
                    Mark as Mandatory (will appear in all interviews)
                </label>
            </div>

            <!-- MCQ Options -->
            <div id="options-section" class="form-group">
                <label>Answer Options</label>
                <div class="options-container" id="options-container">
                    <div class="option-item">
                        <input type="text" name="options[]" class="form-control" placeholder="Option 1">
                        <input type="checkbox" name="correct_options[]" value="0" title="Mark as correct">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="removeOption(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="addOption()">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>

            <div class="form-group">
                <label>Applicable Job Roles</label>
                <div class="checkbox-group">
                    <?php foreach ($roles as $role): ?>
                    <div class="checkbox-item">
                        <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" id="role_<?= $role['id'] ?>">
                        <label for="role_<?= $role['id'] ?>"><?= htmlspecialchars($role['title']) ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Question
                </button>
                <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
let optionCount = 1;

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
    btn.closest('.option-item').remove();
}

// AI Question Generation
function generateAIQuestions() {
    const role = document.getElementById('ai-role').value;
    const topic = document.getElementById('ai-topic').value;
    
    if (!role || !topic) {
        alert('Please select a role and enter a topic');
        return;
    }
    
    const suggestionsDiv = document.getElementById('ai-suggestions');
    const suggestionsList = document.getElementById('suggestions-list');
    
    suggestionsDiv.style.display = 'block';
    suggestionsList.innerHTML = '<div class="loading"><div class="spinner"></div><p>AI is generating questions...</p></div>';
    
    // Simulate AI generation (replace with actual API call)
    setTimeout(() => {
        const questions = generateMockQuestions(role, topic);
        displaySuggestions(questions);
    }, 2000);
}

function generateMockQuestions(role, topic) {
    // Mock AI-generated questions (replace with actual AI API)
    return [
        {
            text: `Describe a situation where you demonstrated ${topic} in your previous role.`,
            type: 'text',
            difficulty: 'medium',
            points: 5
        },
        {
            text: `How would you approach ${topic} when working on a team project?`,
            type: 'text',
            difficulty: 'medium',
            points: 5
        },
        {
            text: `What strategies do you use to improve your ${topic} skills?`,
            type: 'text',
            difficulty: 'easy',
            points: 3
        },
        {
            text: `Rate your proficiency in ${topic} on a scale of 1-10 and explain why.`,
            type: 'rating',
            difficulty: 'easy',
            points: 2
        }
    ];
}

function displaySuggestions(questions) {
    const suggestionsList = document.getElementById('suggestions-list');
    let html = '';
    
    questions.forEach((q, index) => {
        html += `
            <div class="suggestion-item" onclick='useSuggestion(${JSON.stringify(q)})'>
                <strong>Question ${index + 1}:</strong> ${q.text}
                <br><small>Type: ${q.type} | Difficulty: ${q.difficulty} | Points: ${q.points}</small>
            </div>
        `;
    });
    
    suggestionsList.innerHTML = html;
}

function useSuggestion(question) {
    document.getElementById('question_text').value = question.text;
    document.getElementById('question_type').value = question.type;
    document.getElementById('difficulty').value = question.difficulty;
    document.getElementById('points').value = question.points;
    
    toggleOptions();
    
    // Scroll to form
    document.getElementById('question-form').scrollIntoView({ behavior: 'smooth' });
    
    // Highlight the form
    const formCard = document.querySelector('.form-card');
    formCard.style.border = '3px solid #667eea';
    setTimeout(() => {
        formCard.style.border = 'none';
    }, 2000);
}

// Initialize
toggleOptions();
</script>
