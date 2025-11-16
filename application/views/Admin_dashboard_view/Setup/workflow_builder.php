<?php
// Set page-specific variables
$data['page_title'] = 'Workflow Builder';

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
.section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.workflow-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    transition: all 0.3s;
}

.workflow-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.workflow-item {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.3s;
    cursor: pointer;
}

.workflow-item:hover {
    border-color: #667eea;
    background: #f7fafc;
    transform: translateY(-2px);
}

.workflow-item.active {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.step-node {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    position: relative;
}

.step-node::after {
    content: '↓';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 20px;
    color: #667eea;
}

.step-node:last-child::after {
    display: none;
}

.trigger-badge {
    background: #dbeafe;
    color: #1e40af;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.action-badge {
    background: #d1fae5;
    color: #065f46;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.condition-badge {
    background: #fef3c7;
    color: #92400e;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<!-- Page Header -->
<div class="section-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="fas fa-project-diagram me-2"></i>Workflow Builder</h2>
            <p class="mb-0 opacity-90">Automate your recruitment process with custom workflows</p>
        </div>
        <button class="btn btn-light" onclick="createNewWorkflow()">
            <i class="fas fa-plus me-2"></i>Create Workflow
        </button>
    </div>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success_msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Pre-built Workflows -->
<div class="workflow-card">
    <h4 class="mb-4"><i class="fas fa-magic me-2 text-primary"></i>Pre-built Workflows</h4>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="workflow-item">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">Auto-Send Welcome Email</h5>
                        <p class="text-muted small mb-2">Automatically send welcome email when candidate is added</p>
                        <span class="trigger-badge"><i class="fas fa-bolt me-1"></i>Trigger: New Candidate</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
                <div class="step-node">
                    <strong>1. Trigger:</strong> New candidate added
                </div>
                <div class="step-node">
                    <strong>2. Action:</strong> Send welcome email
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="workflow-item">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">Interview Reminder</h5>
                        <p class="text-muted small mb-2">Send reminder 24 hours before interview</p>
                        <span class="trigger-badge"><i class="fas fa-clock me-1"></i>Trigger: Time-based</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
                <div class="step-node">
                    <strong>1. Trigger:</strong> 24 hours before interview
                </div>
                <div class="step-node">
                    <strong>2. Action:</strong> Send SMS + Email reminder
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="workflow-item">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">Auto-Assign Recruiter</h5>
                        <p class="text-muted small mb-2">Automatically assign candidates to recruiters based on job title</p>
                        <span class="trigger-badge"><i class="fas fa-bolt me-1"></i>Trigger: New Candidate</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox">
                    </div>
                </div>
                <div class="step-node">
                    <strong>1. Trigger:</strong> New candidate added
                </div>
                <div class="step-node">
                    <strong>2. Condition:</strong> Check job title
                </div>
                <div class="step-node">
                    <strong>3. Action:</strong> Assign to recruiter
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="workflow-item">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">Selection Notification</h5>
                        <p class="text-muted small mb-2">Notify candidate via multiple channels when selected</p>
                        <span class="trigger-badge"><i class="fas fa-bolt me-1"></i>Trigger: Status Change</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
                <div class="step-node">
                    <strong>1. Trigger:</strong> Status changed to "Selected"
                </div>
                <div class="step-node">
                    <strong>2. Action:</strong> Send Email + SMS + WhatsApp
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Workflow Components -->
<div class="workflow-card">
    <h4 class="mb-4"><i class="fas fa-cubes me-2 text-success"></i>Workflow Components</h4>
    
    <div class="row g-3">
        <div class="col-md-4">
            <h6 class="mb-3"><i class="fas fa-bolt text-primary me-2"></i>Triggers</h6>
            <ul class="list-unstyled">
                <li class="mb-2"><span class="trigger-badge">New Candidate Added</span></li>
                <li class="mb-2"><span class="trigger-badge">Status Changed</span></li>
                <li class="mb-2"><span class="trigger-badge">Interview Scheduled</span></li>
                <li class="mb-2"><span class="trigger-badge">Time-based (Schedule)</span></li>
                <li class="mb-2"><span class="trigger-badge">Document Uploaded</span></li>
            </ul>
        </div>

        <div class="col-md-4">
            <h6 class="mb-3"><i class="fas fa-code-branch text-warning me-2"></i>Conditions</h6>
            <ul class="list-unstyled">
                <li class="mb-2"><span class="condition-badge">If Status = X</span></li>
                <li class="mb-2"><span class="condition-badge">If Job Title = X</span></li>
                <li class="mb-2"><span class="condition-badge">If Source = X</span></li>
                <li class="mb-2"><span class="condition-badge">If Experience > X</span></li>
                <li class="mb-2"><span class="condition-badge">Custom Field Check</span></li>
            </ul>
        </div>

        <div class="col-md-4">
            <h6 class="mb-3"><i class="fas fa-play text-success me-2"></i>Actions</h6>
            <ul class="list-unstyled">
                <li class="mb-2"><span class="action-badge">Send Email</span></li>
                <li class="mb-2"><span class="action-badge">Send SMS</span></li>
                <li class="mb-2"><span class="action-badge">Send WhatsApp</span></li>
                <li class="mb-2"><span class="action-badge">Update Status</span></li>
                <li class="mb-2"><span class="action-badge">Assign Recruiter</span></li>
                <li class="mb-2"><span class="action-badge">Create Task</span></li>
                <li class="mb-2"><span class="action-badge">Send Notification</span></li>
            </ul>
        </div>
    </div>
</div>

<script>
function createNewWorkflow() {
    Swal.fire({
        title: 'Create New Workflow',
        html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label">Workflow Name</label>
                    <input type="text" class="form-control" id="workflowName" placeholder="Enter workflow name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="workflowDesc" rows="3" placeholder="Describe what this workflow does"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trigger</label>
                    <select class="form-select" id="workflowTrigger">
                        <option>New Candidate Added</option>
                        <option>Status Changed</option>
                        <option>Interview Scheduled</option>
                        <option>Time-based</option>
                    </select>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Create Workflow',
        cancelButtonText: 'Cancel',
        width: 600
    });
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>
