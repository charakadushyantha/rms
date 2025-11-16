<style>
.questions-bank-container {
    padding: 30px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #667eea;
}

.stat-label {
    font-size: 14px;
    color: #666;
}

.filters-section {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.questions-list {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

th, td {
    padding: 15px;
    text-align: left;
}

tbody tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-mandatory { background: #ffecd2; color: #dd6b20; }
.badge-easy { background: #c6f6d5; color: #38a169; }
.badge-medium { background: #feebc8; color: #dd6b20; }
.badge-hard { background: #fed7d7; color: #e53e3e; }
.badge-mcq { background: #d1ecf1; color: #0c5460; }

.btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    margin: 2px;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-success {
    background: #38a169;
    color: white;
}

.btn-danger {
    background: #e53e3e;
    color: white;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
    padding: 20px;
}
</style>

<div class="questions-bank-container">
    <div class="page-header">
        <div>
            <h1><i class="fas fa-question-circle"></i> Questions Bank</h1>
            <p>Manage interview questions and generate question sets</p>
        </div>
        <div>
            <a href="<?= base_url('questions_bank/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Question
            </a>
            <a href="<?= base_url('questions_bank/categories') ?>" class="btn btn-success">
                <i class="fas fa-folder"></i> Categories
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?= $stats['total_questions'] ?></div>
            <div class="stat-label">Total Questions</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $stats['mandatory_questions'] ?></div>
            <div class="stat-label">Mandatory</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $stats['mcq_questions'] ?></div>
            <div class="stat-label">MCQ Questions</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $stats['total_categories'] ?></div>
            <div class="stat-label">Categories</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $stats['total_roles'] ?></div>
            <div class="stat-label">Job Roles</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="get" action="<?= base_url('questions_bank') ?>">
            <div class="filter-row">
                <div>
                    <input type="text" name="search" class="form-control" placeholder="Search questions..." value="<?= $this->input->get('search') ?>">
                </div>
                <div>
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $this->input->get('category') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="difficulty" class="form-control">
                        <option value="">All Difficulties</option>
                        <option value="easy" <?= $this->input->get('difficulty') == 'easy' ? 'selected' : '' ?>>Easy</option>
                        <option value="medium" <?= $this->input->get('difficulty') == 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="hard" <?= $this->input->get('difficulty') == 'hard' ? 'selected' : '' ?>>Hard</option>
                    </select>
                </div>
                <div>
                    <select name="role" class="form-control">
                        <option value="">All Roles</option>
                        <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['id'] ?>" <?= $this->input->get('role') == $role['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($role['title']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Questions List -->
    <div class="questions-list">
        <?php if (!empty($questions)): ?>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Difficulty</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars(substr($question['question_text'], 0, 100)) ?>...
                        <?php if ($question['is_mandatory']): ?>
                        <span class="badge badge-mandatory">Mandatory</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($question['category_name'] ?? 'N/A') ?></td>
                    <td>
                        <span class="badge badge-mcq"><?= strtoupper(str_replace('_', ' ', $question['question_type'])) ?></span>
                    </td>
                    <td>
                        <span class="badge badge-<?= $question['difficulty'] ?>">
                            <?= ucfirst($question['difficulty']) ?>
                        </span>
                    </td>
                    <td><?= $question['points'] ?></td>
                    <td>
                        <a href="<?= base_url('questions_bank/view/' . $question['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('questions_bank/edit/' . $question['id']) ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= base_url('questions_bank/delete/' . $question['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this question?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-sm">Previous</a>
            <?php endif; ?>
            
            <span>Page <?= $page ?> of <?= $total_pages ?></span>
            
            <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-sm">Next</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-question-circle" style="font-size: 64px; color: #ddd;"></i>
            <h3>No Questions Found</h3>
            <p>Start by adding your first question to the bank</p>
            <a href="<?= base_url('questions_bank/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Question
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
