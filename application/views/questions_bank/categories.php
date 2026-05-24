<style>
.categories-container {
    padding: 30px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.category-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    border-left: 4px solid #667eea;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
}

.category-name {
    font-size: 20px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.category-description {
    color: #666;
    font-size: 14px;
    margin-bottom: 15px;
    line-height: 1.5;
}

.category-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #666;
}

.stat-item i {
    color: #667eea;
}

.stat-value {
    font-weight: 700;
    color: #333;
}

.category-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-success {
    background: #38a169;
    color: white;
}

.btn-success:hover {
    background: #2f855a;
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

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-state i {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.3);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 20px;
}

.close {
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    background: none;
    border: none;
}

.close:hover {
    opacity: 0.8;
}

.modal-body {
    padding: 25px;
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
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: #c6f6d5;
    color: #22543d;
    border-left: 4px solid #38a169;
}

.alert-danger {
    background: #fed7d7;
    color: #742a2a;
    border-left: 4px solid #e53e3e;
}
</style>

<div class="categories-container">
    <div class="page-header">
        <div>
            <h1><i class="fas fa-folder"></i> Question Categories</h1>
            <p>Organize questions into categories for better management</p>
        </div>
        <div>
            <a href="<?= base_url('questions_bank') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Questions
            </a>
            <button onclick="openAddModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Categories Grid -->
    <?php if (!empty($categories)): ?>
    <div class="categories-grid">
        <?php foreach ($categories as $category): ?>
        <div class="category-card">
            <div class="category-header">
                <h3 class="category-name"><?= htmlspecialchars($category['name']) ?></h3>
            </div>
            
            <?php if (!empty($category['description'])): ?>
            <p class="category-description"><?= htmlspecialchars($category['description']) ?></p>
            <?php endif; ?>
            
            <div class="category-stats">
                <div class="stat-item">
                    <i class="fas fa-question-circle"></i>
                    <span><span class="stat-value"><?= $category['question_count'] ?? 0 ?></span> Questions</span>
                </div>
            </div>
            
            <div class="category-actions">
                <button onclick="openEditModal(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['name'])) ?>', '<?= htmlspecialchars(addslashes($category['description'] ?? '')) ?>')" 
                        class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button onclick="deleteCategory(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['name'])) ?>')" 
                        class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-folder-open"></i>
        <h3>No Categories Found</h3>
        <p>Create your first category to organize questions</p>
        <button onclick="openAddModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Category Modal -->
<div id="categoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Add Category</h2>
            <button class="close" onclick="closeModal()">&times;</button>
        </div>
        <form id="categoryForm" method="POST" action="<?= base_url('questions_bank/save_category') ?>">
            <input type="hidden" id="category_id" name="category_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="category_name">Category Name <span style="color: red;">*</span></label>
                    <input type="text" id="category_name" name="category_name" class="form-control" required placeholder="e.g., Technical Skills">
                </div>
                <div class="form-group">
                    <label for="category_description">Description</label>
                    <textarea id="category_description" name="category_description" class="form-control" placeholder="Brief description of this category"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('category_id').value = '';
    document.getElementById('category_name').value = '';
    document.getElementById('category_description').value = '';
    document.getElementById('categoryModal').style.display = 'block';
}

function openEditModal(id, name, description) {
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('category_id').value = id;
    document.getElementById('category_name').value = name;
    document.getElementById('category_description').value = description;
    document.getElementById('categoryModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function deleteCategory(id, name) {
    if (confirm('Are you sure you want to delete the category "' + name + '"?\n\nThis will not delete the questions in this category.')) {
        window.location.href = '<?= base_url('questions_bank/delete_category/') ?>' + id;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('categoryModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>
