<style>
.interviews-container {
    padding: 30px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.filters {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.table-container {
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

th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #d1ecf1; color: #0c5460; }
.badge-success { background: #d4edda; color: #155724; }
.badge-danger { background: #f8d7da; color: #721c24; }

.btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    font-size: 12px;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}
</style>

<div class="interviews-container">
    <div class="page-header">
        <div>
            <h1>🎯 Interviews</h1>
            <p>Manage candidate interviews</p>
        </div>
        <a href="<?= base_url('interview/create_interview') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Interview
        </a>
    </div>

    <div class="filters">
        <div class="filter-group">
            <label>Filter by Flow</label>
            <select class="form-control" onchange="filterInterviews(this)">
                <option value="">All Flows</option>
                <?php foreach ($flows as $flow): ?>
                <option value="<?= $flow['id'] ?>" <?= $this->input->get('flow_id') == $flow['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($flow['job_title']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label>Filter by Status</label>
            <select class="form-control" onchange="filterByStatus(this)">
                <option value="">All Statuses</option>
                <option value="pending" <?= $this->input->get('status') === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="in_progress" <?= $this->input->get('status') === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="completed" <?= $this->input->get('status') === 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="expired" <?= $this->input->get('status') === 'expired' ? 'selected' : '' ?>>Expired</option>
            </select>
        </div>
    </div>

    <?php if (!empty($interviews)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Expires</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($interviews as $interview): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($interview['candidate_name']) ?></strong><br>
                        <small><?= htmlspecialchars($interview['candidate_email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($interview['job_title']) ?></td>
                    <td>
                        <?php
                        $badge_class = 'badge-warning';
                        if ($interview['status'] === 'in_progress') $badge_class = 'badge-info';
                        if ($interview['status'] === 'completed') $badge_class = 'badge-success';
                        if ($interview['status'] === 'expired') $badge_class = 'badge-danger';
                        ?>
                        <span class="badge <?= $badge_class ?>">
                            <?= ucfirst(str_replace('_', ' ', $interview['status'])) ?>
                        </span>
                    </td>
                    <td><?= date('M j, Y', strtotime($interview['created_at'])) ?></td>
                    <td><?= date('M j, Y', strtotime($interview['expires_at'])) ?></td>
                    <td>
                        <?php if ($interview['score'] !== null): ?>
                            <strong><?= $interview['score'] ?>%</strong>
                        <?php else: ?>
                            <span style="color: #999;">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('interview/view/' . $interview['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <h3>No Interviews Found</h3>
        <p>Create your first interview to get started.</p>
        <a href="<?= base_url('interview/create_interview') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Interview
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
function filterInterviews(select) {
    const flowId = select.value;
    const status = new URLSearchParams(window.location.search).get('status') || '';
    let url = '<?= base_url('interview/interviews') ?>';
    const params = [];
    if (flowId) params.push('flow_id=' + flowId);
    if (status) params.push('status=' + status);
    if (params.length) url += '?' + params.join('&');
    window.location.href = url;
}

function filterByStatus(select) {
    const status = select.value;
    const flowId = new URLSearchParams(window.location.search).get('flow_id') || '';
    let url = '<?= base_url('interview/interviews') ?>';
    const params = [];
    if (flowId) params.push('flow_id=' + flowId);
    if (status) params.push('status=' + status);
    if (params.length) url += '?' + params.join('&');
    window.location.href = url;
}
</script>
