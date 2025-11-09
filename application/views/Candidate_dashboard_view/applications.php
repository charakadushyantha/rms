<?php
$data['page_title'] = 'My Applications';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.applications-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.applications-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.875rem;
    background: white;
    cursor: pointer;
}

.application-card {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border-left: 4px solid #14b8a6;
    transition: all 0.2s;
}

.application-card:hover {
    background: #f3f4f6;
    transform: translateX(4px);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
}

.application-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.application-date {
    font-size: 0.875rem;
    color: #6b7280;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-applied {
    background: #dbeafe;
    color: #1e40af;
}

.status-screening {
    background: #fef3c7;
    color: #92400e;
}

.status-interview_scheduled {
    background: #d1fae5;
    color: #065f46;
}

.status-interviewed {
    background: #e0e7ff;
    color: #4338ca;
}

.status-offer_extended {
    background: #d1fae5;
    color: #065f46;
}

.status-hired {
    background: #dcfce7;
    color: #166534;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.application-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.detail-item i {
    color: #14b8a6;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>

<div class="applications-container">
    <div class="applications-card">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-briefcase me-2"></i>My Applications
            </h1>
            <div class="filter-group">
                <select class="filter-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="applied">Applied</option>
                    <option value="screening">Screening</option>
                    <option value="interview_scheduled">Interview Scheduled</option>
                    <option value="interviewed">Interviewed</option>
                    <option value="offer_extended">Offer Extended</option>
                    <option value="hired">Hired</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <?php if (!empty($applications)): ?>
            <?php foreach ($applications as $app): ?>
                <div class="application-card" data-status="<?php echo $app['status']; ?>">
                    <div class="application-header">
                        <div>
                            <h3 class="application-title"><?php echo htmlspecialchars($app['job_title']); ?></h3>
                            <div class="application-date">
                                <i class="fas fa-calendar me-1"></i>
                                Applied on <?php echo date('F d, Y', strtotime($app['applied_at'])); ?>
                            </div>
                        </div>
                        <span class="status-badge status-<?php echo $app['status']; ?>">
                            <?php echo ucwords(str_replace('_', ' ', $app['status'])); ?>
                        </span>
                    </div>

                    <div class="application-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>Last updated: <?php echo date('M d, Y', strtotime($app['updated_at'])); ?></span>
                        </div>
                        <?php if (!empty($app['notes'])): ?>
                        <div class="detail-item">
                            <i class="fas fa-info-circle"></i>
                            <span><?php echo htmlspecialchars($app['notes']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-briefcase"></i>
                <h3>No Applications Yet</h3>
                <p>You haven't applied to any positions yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$custom_script = "
// Filter applications by status
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    const cards = document.querySelectorAll('.application-card');
    
    cards.forEach(card => {
        if (status === '' || card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
