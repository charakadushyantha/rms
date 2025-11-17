<style>
.create-interview-container {
    padding: 30px;
    max-width: 800px;
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

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}
</style>

<div class="create-interview-container">
    <h1>🎯 Create Interview</h1>
    <p>Generate a unique interview link for a candidate</p>

    <div class="form-card">
        <form method="post" action="<?= base_url('interview/create_interview') ?>">
            <div class="form-group">
                <label for="flow_id">Select Interview Flow *</label>
                <select class="form-control" id="flow_id" name="flow_id" required>
                    <option value="">Choose a flow...</option>
                    <?php foreach ($flows as $flow): ?>
                    <option value="<?= $flow['id'] ?>" <?= $this->input->get('flow_id') == $flow['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($flow['job_title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="candidate_name">Candidate Name *</label>
                <input type="text" class="form-control" id="candidate_name" name="candidate_name" required>
            </div>

            <div class="form-group">
                <label for="candidate_email">Candidate Email *</label>
                <input type="email" class="form-control" id="candidate_email" name="candidate_email" required>
            </div>

            <div class="form-group">
                <label for="candidate_phone">Candidate Phone</label>
                <input type="tel" class="form-control" id="candidate_phone" name="candidate_phone">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="send_email" value="1" checked>
                    Send interview link via email
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-link"></i> Create Interview
                </button>
                <a href="<?= base_url('interview/interviews') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
