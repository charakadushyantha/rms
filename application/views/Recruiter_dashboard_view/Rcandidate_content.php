<!-- Success/Error Messages -->
<?php if($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show auto-dismiss-alert" role="alert" style="max-width: 680px; margin: 1.5rem auto 0;">
    <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error_msg')): ?>
<div class="alert alert-danger alert-dismissible fade show auto-dismiss-alert" role="alert" style="max-width: 680px; margin: 1.5rem auto 0;">
    <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error_msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<script>
// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.auto-dismiss-alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // 5 seconds
    });
});
</script>

<style>
.modern-form-wrapper {
  max-width: 680px;
  margin: 1.5rem auto;
}

.form-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  padding: 2rem;
}

.form-header {
  margin-bottom: 1.75rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #f0f0f0;
}

.form-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.25rem 0;
}

.form-header p {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
  margin-bottom: 1.25rem;
}

.form-field {
  margin-bottom: 1.25rem;
}

.form-field label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.4rem;
}

.form-field label .required {
  color: #ef4444;
  margin-left: 2px;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 0.625rem 0.75rem;
  font-size: 0.9375rem;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  background: #fafafa;
  transition: all 0.15s ease;
  font-family: inherit;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #667eea;
  background: white;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.06);
}

.form-input:hover,
.form-select:hover,
.form-textarea:hover {
  border-color: #d1d5db;
  background: white;
}

.form-textarea {
  resize: vertical;
  min-height: 70px;
}

.radio-group {
  display: flex;
  gap: 1.5rem;
  margin-top: 0.4rem;
}

.radio-option {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.radio-option input[type="radio"] {
  width: 16px;
  height: 16px;
  cursor: pointer;
  accent-color: #667eea;
}

.radio-option label {
  margin: 0;
  font-weight: 400;
  color: #6b7280;
  cursor: pointer;
}

.file-hint {
  display: block;
  font-size: 0.8125rem;
  color: #9ca3af;
  margin-top: 0.375rem;
}

.form-actions {
  display: flex;
  gap: 0.75rem;
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #f0f0f0;
}

.btn {
  padding: 0.625rem 1.5rem;
  font-size: 0.9375rem;
  font-weight: 500;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-primary {
  background: #667eea;
  color: white;
}

.btn-primary:hover {
  background: #5568d3;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.btn-secondary {
  background: #f3f4f6;
  color: #6b7280;
}

.btn-secondary:hover {
  background: #e5e7eb;
}

.btn-outline {
  background: white;
  color: #6b7280;
  border: 1.5px solid #e5e7eb;
}

.btn-outline:hover {
  background: #f9fafb;
  border-color: #d1d5db;
}

@media (max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .form-card {
    padding: 1.5rem;
  }
}
</style>

<div class="modern-form-wrapper">
  <div class="form-card">
    <div class="form-header">
      <h3>Add New Candidate</h3>
      <p>Fill in the candidate information below</p>
    </div>
    
    <form action="<?php echo base_url('R_dashboard/add_candidate_process'); ?>" method="post" enctype="multipart/form-data">
      
      <div class="form-row">
        <div class="form-field">
          <label>Full Name <span class="required">*</span></label>
          <input type="text" class="form-input" name="candidate_name" required placeholder="Enter full name">
        </div>
        
        <div class="form-field">
          <label>Email <span class="required">*</span></label>
          <input type="email" class="form-input" name="candidate_email" required placeholder="candidate@email.com">
        </div>
      </div>

      <div class="form-row">
        <div class="form-field">
          <label>Phone Number <span class="required">*</span></label>
          <input type="tel" class="form-input" name="candidate_phone" required placeholder="+1 234 567 8900">
        </div>
        
        <div class="form-field">
          <label>Gender</label>
          <div class="radio-group">
            <div class="radio-option">
              <input type="radio" name="candidate_gender" value="Male" id="male" checked>
              <label for="male">Male</label>
            </div>
            <div class="radio-option">
              <input type="radio" name="candidate_gender" value="Female" id="female">
              <label for="female">Female</label>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-field">
          <label>Position Applied <span class="required">*</span></label>
          <select class="form-select" name="job_title" required>
            <option value="">Select Position</option>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Frontend Developer">Frontend Developer</option>
            <option value="Backend Developer">Backend Developer</option>
            <option value="Full Stack Developer">Full Stack Developer</option>
            <option value="DevOps Engineer">DevOps Engineer</option>
            <option value="UI/UX Designer">UI/UX Designer</option>
            <option value="Product Manager">Product Manager</option>
            <option value="QA Engineer">QA Engineer</option>
            <option value="Data Scientist">Data Scientist</option>
          </select>
        </div>
        
        <div class="form-field">
          <label>Source</label>
          <select class="form-select" name="source">
            <option value="LinkedIn">LinkedIn</option>
            <option value="Indeed">Indeed</option>
            <option value="Company Website">Company Website</option>
            <option value="Referral">Referral</option>
            <option value="Job Fair">Job Fair</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <div class="form-field">
        <label>Current Status</label>
        <textarea class="form-textarea" name="current_status" placeholder="Brief note about candidate status..."></textarea>
      </div>

      <div class="form-field">
        <label>Resume Upload</label>
        <input type="file" class="form-input" name="resume" accept=".pdf,.doc,.docx">
        <span class="file-hint">Accepted formats: PDF, DOC, DOCX (Max 5MB)</span>
      </div>

      <div class="form-field">
        <label>Candidate's Status</label>
        <select class="form-select" name="candidate_status">
          <option value="Interested">Interested</option>
          <option value="Not Picking up Call">Not Picking up Call</option>
          <option value="Not Interested">Not Interested</option>
          <option value="Call Back Later">Call Back Later</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i>
          Save Candidate
        </button>
        <button type="reset" class="btn btn-secondary">
          <i class="fas fa-redo"></i>
          Reset
        </button>
        <a href="<?php echo base_url('R_dashboard'); ?>" class="btn btn-outline">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
