<style>
.interview-detail-card {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 24px;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 2px solid #f7fafc;
}

.detail-title {
    font-size: 28px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}

.detail-subtitle {
    color: #718096;
    font-size: 14px;
}

.detail-actions {
    display: flex;
    gap: 12px;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 32px;
}

.detail-item {
    padding: 20px;
    background: #f7fafc;
    border-radius: 12px;
    border-left: 4px solid #667eea;
}

.detail-label {
    font-size: 12px;
    color: #718096;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.detail-value {
    font-size: 16px;
    color: #2d3748;
    font-weight: 500;
}

.detail-value i {
    margin-right: 8px;
    color: #667eea;
}

.status-badge-large {
    padding: 8px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
}

.status-scheduled {
    background: #e6f7ff;
    color: #0066cc;
}

.status-completed {
    background: #c6f6d5;
    color: #22543d;
}

.status-cancelled {
    background: #fed7d7;
    color: #742a2a;
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
}
</style>

<div class="container-fluid py-4">
    <div class="interview-detail-card">
        <div class="detail-header">
            <div>
                <h1 class="detail-title">
                    <i class="fas fa-calendar-check me-2"></i>Interview Details
                </h1>
                <p class="detail-subtitle">Complete information about this interview</p>
            </div>
            <div class="detail-actions">
                <a href="<?= base_url('Interview/edit/' . $interview['ce_id']) ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="<?= base_url('A_dashboard/Acalendar_view') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Calendar
                </a>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Candidate Name</div>
                <div class="detail-value">
                    <i class="fas fa-user"></i>
                    <?= htmlspecialchars($interview['ce_can_name']) ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Job Position</div>
                <div class="detail-value">
                    <i class="fas fa-briefcase"></i>
                    <?= htmlspecialchars($interview['cd_job_title'] ?? 'N/A') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value">
                    <i class="fas fa-envelope"></i>
                    <?= htmlspecialchars($interview['cd_email'] ?? 'N/A') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Phone</div>
                <div class="detail-value">
                    <i class="fas fa-phone"></i>
                    <?= htmlspecialchars($interview['cd_phone'] ?? 'N/A') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Interview Start</div>
                <div class="detail-value">
                    <i class="fas fa-clock"></i>
                    <?php
                    $start = new DateTime($interview['ce_start_date']);
                    echo $start->format('M d, Y g:i A');
                    ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Interview End</div>
                <div class="detail-value">
                    <i class="fas fa-clock"></i>
                    <?php
                    $end = new DateTime($interview['ce_end_date']);
                    echo $end->format('M d, Y g:i A');
                    ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Interviewer</div>
                <div class="detail-value">
                    <i class="fas fa-user-tie"></i>
                    <?= htmlspecialchars($interview['ce_interviewer'] ?? 'TBD') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Interview Round</div>
                <div class="detail-value">
                    <i class="fas fa-layer-group"></i>
                    <?= htmlspecialchars($interview['ce_interview_round'] ?? 'Round 1') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Recruiter</div>
                <div class="detail-value">
                    <i class="fas fa-user-check"></i>
                    <?= htmlspecialchars($interview['ce_rec_username'] ?? 'N/A') ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <?php
                    $start_date = new DateTime($interview['ce_start_date']);
                    $now = new DateTime();
                    $today = date('Y-m-d');
                    $interview_date = $start_date->format('Y-m-d');
                    
                    if ($start_date < $now) {
                        echo '<span class="status-badge-large status-completed">Completed</span>';
                    } elseif ($interview_date == $today) {
                        echo '<span class="status-badge-large status-scheduled">Today</span>';
                    } else {
                        echo '<span class="status-badge-large status-scheduled">Scheduled</span>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="<?= base_url('Interview/edit/' . $interview['ce_id']) ?>" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-edit me-2"></i>Edit Interview
            </a>
            <button onclick="deleteInterview(<?= $interview['ce_id'] ?>)" class="btn btn-danger btn-lg">
                <i class="fas fa-trash me-2"></i>Delete Interview
            </button>
        </div>
    </div>
</div>

<script>
function deleteInterview(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the interview permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('Interview/delete/') ?>' + id;
            }
        });
    } else {
        if (confirm('Are you sure you want to delete this interview?')) {
            window.location.href = '<?= base_url('Interview/delete/') ?>' + id;
        }
    }
}
</script>
