<?php
$this->load->view('templates/admin_header', array('page_title' => 'Configure Meeting Platforms'));
?>

<style>
.placeholder-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 40px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

.placeholder-icon {
    font-size: 80px;
    color: #667eea;
    margin-bottom: 20px;
}

.placeholder-title {
    font-size: 32px;
    color: #333;
    margin-bottom: 15px;
    font-weight: 700;
}

.placeholder-subtitle {
    font-size: 18px;
    color: #666;
    margin-bottom: 30px;
}

.feature-list {
    text-align: left;
    max-width: 600px;
    margin: 30px auto;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
}

.feature-list h4 {
    color: #667eea;
    margin-bottom: 20px;
}

.feature-list ul {
    list-style: none;
    padding: 0;
}

.feature-list li {
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}

.feature-list li:last-child {
    border-bottom: none;
}

.feature-list li i {
    color: #4caf50;
    margin-right: 10px;
}

.btn-back {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    margin-top: 20px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.current-data {
    margin-top: 40px;
    text-align: left;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.data-table th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px;
    text-align: left;
}

.data-table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
}

.data-table tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.badge-active {
    background: #4caf50;
    color: white;
}

.badge-inactive {
    background: #f44336;
    color: white;
}

.badge-video {
    background: #2196f3;
    color: white;
}

.badge-phone {
    background: #ff9800;
    color: white;
}

.badge-in-person {
    background: #9c27b0;
    color: white;
}
</style>

<div class="placeholder-container">
    <div class="placeholder-icon">
        <i class="fas fa-video"></i>
    </div>
    
    <h1 class="placeholder-title">Configure Meeting Platforms</h1>
    <p class="placeholder-subtitle">Manage video conferencing and meeting platforms</p>
    
    <div class="feature-list">
        <h4><i class="fas fa-wrench"></i> Planned Features</h4>
        <ul>
            <li><i class="fas fa-check"></i> Add new meeting platforms</li>
            <li><i class="fas fa-check"></i> Configure API keys (Zoom, Google Meet, Teams)</li>
            <li><i class="fas fa-check"></i> Test API connections</li>
            <li><i class="fas fa-check"></i> Enable/Disable platforms</li>
            <li><i class="fas fa-check"></i> Set webhook URLs</li>
            <li><i class="fas fa-check"></i> Auto-generate real meeting links</li>
        </ul>
    </div>
    
    <?php if (!empty($platforms)): ?>
    <div class="current-data">
        <h3 style="color: #667eea; margin-bottom: 15px;">
            <i class="fas fa-database"></i> Current Meeting Platforms
        </h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Platform Name</th>
                    <th>Type</th>
                    <th>API Enabled</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($platforms as $platform): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($platform->platform_name) ?></strong></td>
                    <td>
                        <span class="badge badge-<?= $platform->platform_type ?>">
                            <?= ucfirst($platform->platform_type) ?>
                        </span>
                    </td>
                    <td><?= $platform->api_enabled ? '✓ Yes' : '✗ No' ?></td>
                    <td>
                        <span class="badge <?= $platform->is_active ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $platform->is_active ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p style="margin-top: 15px; color: #666; font-size: 14px;">
            <i class="fas fa-info-circle"></i> These platforms are currently available in the interview form.
        </p>
    </div>
    <?php endif; ?>
    
    <a href="<?= base_url('Setup/interview_configuration') ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Interview Configuration
    </a>
</div>

<?php
$this->load->view('templates/admin_footer');
?>
