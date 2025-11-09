<?php
// Set page-specific variables
$data['page_title'] = 'Schedule Interview';
$data['use_charts'] = false;

// Load the recruiter header template
$this->load->view('templates/recruiter_header', $data);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Schedule Interview</h1>
    <a href="<?= base_url('R_dashboard') ?>" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left fa-sm"></i> Back to Dashboard
    </a>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('msg')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?= $this->session->flashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Schedule Interview Form -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card card-dashboard shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-plus me-2"></i>Interview Schedule Details
                </h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('R_dashboard/schedule_proc') ?>" method="post" id="scheduleForm">
                    
                    <!-- Candidate Name -->
                    <div class="mb-4">
                        <label for="can_name" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Candidate Name
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="can_name" 
                               name="can_name" 
                               value="<?= isset($can_name) ? $can_name : '' ?>" 
                               placeholder="Enter candidate full name"
                               required>
                        <input type="hidden" name="can_id" value="<?= isset($can_id) ? $can_id : '' ?>">
                    </div>

                    <!-- Interview Start Date -->
                    <div class="mb-4">
                        <label for="sdate" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-success"></i>Interview Start Date & Time
                        </label>
                        <input type="datetime-local" 
                               class="form-control form-control-lg" 
                               id="sdate" 
                               name="sdate" 
                               required>
                        <small class="form-text text-muted">Select the date and time when the interview will start</small>
                    </div>

                    <!-- Interview End Date -->
                    <div class="mb-4">
                        <label for="edate" class="form-label fw-bold">
                            <i class="fas fa-calendar-check me-2 text-warning"></i>Interview End Date & Time
                        </label>
                        <input type="datetime-local" 
                               class="form-control form-control-lg" 
                               id="edate" 
                               name="edate" 
                               required>
                        <small class="form-text text-muted">Select the date and time when the interview will end</small>
                    </div>

                    <!-- Interviewer Selection -->
                    <div class="mb-4">
                        <label for="Interviewer" class="form-label fw-bold">
                            <i class="fas fa-user-tie me-2 text-info"></i>Interviewer
                        </label>
                        <select class="form-select form-select-lg" id="Interviewer" name="Interviewer" required>
                            <option value="">Select an interviewer</option>
                            <option value="Interviewer 1">Interviewer 1</option>
                            <option value="Interviewer 2">Interviewer 2</option>
                            <option value="Interviewer 3">Interviewer 3</option>
                            <option value="Interviewer 4">Interviewer 4</option>
                        </select>
                    </div>

                    <!-- Interview Round (Optional) -->
                    <div class="mb-4">
                        <label for="interview_round" class="form-label fw-bold">
                            <i class="fas fa-layer-group me-2 text-secondary"></i>Interview Round
                        </label>
                        <select class="form-select form-select-lg" id="interview_round" name="interview_round">
                            <option value="0.25">First Round (Screening)</option>
                            <option value="0.5">Second Round (Technical)</option>
                            <option value="0.75">Third Round (HR/Final)</option>
                            <option value="1">Final Round</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary btn-lg px-4">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-check me-2"></i>Schedule Interview
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="card card-dashboard shadow">
            <div class="card-body">
                <h6 class="font-weight-bold text-primary mb-3">
                    <i class="fas fa-info-circle me-2"></i>Scheduling Tips
                </h6>
                <ul class="mb-0">
                    <li class="mb-2">Ensure the candidate status is set to "Interested" before scheduling</li>
                    <li class="mb-2">Double-check the date and time to avoid conflicts</li>
                    <li class="mb-2">The interview will appear on your calendar after scheduling</li>
                    <li>You can update or cancel the interview from the calendar view</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and datetime handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('scheduleForm');
    const startDateInput = document.getElementById('sdate');
    const endDateInput = document.getElementById('edate');
    
    // Set minimum date to today
    const now = new Date();
    const minDateTime = now.toISOString().slice(0, 16);
    startDateInput.min = minDateTime;
    endDateInput.min = minDateTime;
    
    // Validate end date is after start date
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = '';
        }
    });
    
    form.addEventListener('submit', function(e) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (endDate <= startDate) {
            e.preventDefault();
            alert('Interview end time must be after start time');
            return false;
        }
        
        // Check if interview duration is reasonable (not more than 8 hours)
        const duration = (endDate - startDate) / (1000 * 60 * 60); // hours
        if (duration > 8) {
            if (!confirm('The interview duration is more than 8 hours. Do you want to continue?')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>

<?php
// Load the recruiter footer template
$this->load->view('templates/recruiter_footer', $data);
?>
