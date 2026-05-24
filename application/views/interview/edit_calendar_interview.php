<style>
.edit-interview-card {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    max-width: 900px;
    margin: 0 auto;
}

.form-header {
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 2px solid #f7fafc;
}

.form-title {
    font-size: 28px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}

.form-subtitle {
    color: #718096;
    font-size: 14px;
}

.form-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #667eea;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    display: block;
}

.form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-group-custom {
    display: flex;
    gap: 12px;
    margin-top: 32px;
}

@media (max-width: 768px) {
    .btn-group-custom {
        flex-direction: column;
    }
}
</style>

<div class="container-fluid py-4">
    <div class="edit-interview-card">
        <div class="form-header">
            <h1 class="form-title">
                <i class="fas fa-edit me-2"></i>Edit Interview
            </h1>
            <p class="form-subtitle">Update interview details and schedule</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('Interview/edit/' . $interview['ce_id']) ?>">
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user me-2"></i>Candidate Information
                </h3>

                <div class="form-group">
                    <label class="form-label" for="candidate_name">
                        Candidate Name <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="candidate_name" name="candidate_name" required>
                        <option value="">Select Candidate</option>
                        <?php foreach ($candidates as $candidate): ?>
                            <option value="<?= htmlspecialchars($candidate['cd_name']) ?>" 
                                    <?= $candidate['cd_name'] == $interview['ce_can_name'] ? 'selected' : '' ?>
                                    data-email="<?= htmlspecialchars($candidate['cd_email']) ?>"
                                    data-phone="<?= htmlspecialchars($candidate['cd_phone']) ?>"
                                    data-job="<?= htmlspecialchars($candidate['cd_job_title']) ?>">
                                <?= htmlspecialchars($candidate['cd_name']) ?> - <?= htmlspecialchars($candidate['cd_job_title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt me-2"></i>Interview Schedule
                </h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="start_date">
                                Start Date & Time <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($interview['ce_start_date'])) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="end_date">
                                End Date & Time <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($interview['ce_end_date'])) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="interview_round">
                        Interview Round
                    </label>
                    <select class="form-select" id="interview_round" name="interview_round">
                        <option value="Round 1" <?= $interview['ce_interview_round'] == 'Round 1' ? 'selected' : '' ?>>Round 1 - Initial Screening</option>
                        <option value="Round 2" <?= $interview['ce_interview_round'] == 'Round 2' ? 'selected' : '' ?>>Round 2 - Technical Interview</option>
                        <option value="Round 3" <?= $interview['ce_interview_round'] == 'Round 3' ? 'selected' : '' ?>>Round 3 - HR Interview</option>
                        <option value="Final Round" <?= $interview['ce_interview_round'] == 'Final Round' ? 'selected' : '' ?>>Final Round</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user-tie me-2"></i>Interviewer Assignment
                </h3>

                <div class="form-group">
                    <label class="form-label" for="interviewer">
                        Assigned Interviewer <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="interviewer" name="interviewer" required>
                        <option value="">Select Interviewer</option>
                        <?php foreach ($interviewers as $interviewer_item): ?>
                            <option value="<?= htmlspecialchars($interviewer_item['u_username']) ?>" 
                                    <?= $interviewer_item['u_username'] == $interview['ce_interviewer'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($interviewer_item['u_username']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="btn-group-custom">
                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
                <a href="<?= base_url('A_dashboard/Acalendar_view') ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-update end time when start time changes (add 1 hour by default)
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDate = new Date(startDate.getTime() + 60 * 60 * 1000); // Add 1 hour
    
    const year = endDate.getFullYear();
    const month = String(endDate.getMonth() + 1).padStart(2, '0');
    const day = String(endDate.getDate()).padStart(2, '0');
    const hours = String(endDate.getHours()).padStart(2, '0');
    const minutes = String(endDate.getMinutes()).padStart(2, '0');
    
    document.getElementById('end_date').value = `${year}-${month}-${day}T${hours}:${minutes}`;
});
</script>
