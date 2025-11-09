<style>
.status-wrapper {
  max-width: 1200px;
  margin: 1.5rem auto;
  padding: 0 1rem;
}

.status-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  overflow: hidden;
}

.status-header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.status-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.status-actions {
  display: flex;
  gap: 0.75rem;
  align-items: center;
}

.search-box {
  position: relative;
}

.search-box input {
  padding: 0.5rem 0.75rem 0.5rem 2.25rem;
  border: 1.5px solid #e5e7eb;
  border-radius: 6px;
  font-size: 0.875rem;
  width: 250px;
  transition: all 0.2s ease;
}

.search-box input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.06);
}

.search-box i {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.table-container {
  overflow-x: auto;
}

.modern-table {
  width: 100%;
  border-collapse: collapse;
}

.modern-table thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.modern-table th {
  padding: 0.875rem 1rem;
  text-align: left;
  font-size: 0.8125rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.modern-table tbody tr {
  border-bottom: 1px solid #f3f4f6;
  transition: background 0.15s ease;
}

.modern-table tbody tr:hover {
  background: #f9fafb;
}

.modern-table td {
  padding: 1rem;
  font-size: 0.9375rem;
  color: #374151;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.8125rem;
  font-weight: 500;
}

.status-interested {
  background: #d1fae5;
  color: #065f46;
}

.status-not-picking {
  background: #fee2e2;
  color: #991b1b;
}

.status-not-interested {
  background: #fef3c7;
  color: #92400e;
}

.status-callback {
  background: #dbeafe;
  color: #1e40af;
}

.check-icon {
  color: #10b981;
  font-size: 1.125rem;
}

.times-icon {
  color: #ef4444;
  font-size: 1.125rem;
}

.btn-action {
  padding: 0.5rem 1rem;
  font-size: 0.8125rem;
  font-weight: 500;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
}

.btn-schedule {
  background: #667eea;
  color: white;
}

.btn-schedule:hover:not(:disabled) {
  background: #5568d3;
  transform: translateY(-1px);
}

.btn-schedule:disabled {
  background: #e5e7eb;
  color: #9ca3af;
  cursor: not-allowed;
}

.btn-edit {
  background: #f3f4f6;
  color: #6b7280;
}

.btn-edit:hover {
  background: #e5e7eb;
}

.btn-view {
  background: #10b981;
  color: white;
}

.btn-view:hover:not(:disabled) {
  background: #059669;
  transform: translateY(-1px);
}

.btn-reschedule {
  background: #f59e0b;
  color: white;
}

.btn-reschedule:hover:not(:disabled) {
  background: #d97706;
  transform: translateY(-1px);
}

.btn-cancel {
  background: #ef4444;
  color: white;
}

.btn-cancel:hover:not(:disabled) {
  background: #dc2626;
  transform: translateY(-1px);
}

.empty-state {
  text-align: center;
  padding: 3rem 2rem;
  color: #9ca3af;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

/* SweetAlert2 Custom Styles */
.swal2-popup {
  border-radius: 16px;
  padding: 2rem;
  font-family: 'Inter', sans-serif;
}

.swal2-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
}

.swal2-html-container {
  font-size: 1rem;
  color: #6b7280;
}

.swal2-confirm {
  border-radius: 8px;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  transition: all 0.3s;
}

.swal2-confirm:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
}

.swal2-cancel {
  border-radius: 8px;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
}

.swal2-icon {
  border-width: 3px;
}

.swal2-icon.swal2-success .swal2-success-ring {
  border-color: rgba(16, 185, 129, 0.3);
}

.swal2-icon.swal2-success [class^='swal2-success-line'] {
  background-color: #10b981;
}

.swal2-icon.swal2-error {
  border-color: #ef4444;
}

.swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
  background-color: #ef4444;
}

.swal2-icon.swal2-warning {
  border-color: #f59e0b;
  color: #f59e0b;
}

.swal2-timer-progress-bar {
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

@media (max-width: 768px) {
  .status-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .search-box input {
    width: 100%;
  }
  
  .modern-table {
    font-size: 0.875rem;
  }
  
  .modern-table th,
  .modern-table td {
    padding: 0.75rem 0.5rem;
  }
  
  .swal2-popup {
    padding: 1.5rem;
  }
}
</style>

<div class="status-wrapper">
  <div class="status-card">
    <div class="status-header">
      <h3>Candidate Pipeline</h3>
      <div class="status-actions">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search candidates...">
        </div>
      </div>
    </div>
    
    <div class="table-container">
      <table class="modern-table" id="candidateTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Candidate Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Interview Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
            <?php 
            $i = 1; 
            foreach ($can_details->result_array() as $row): 
              // Get interview details if scheduled
              $interview = null;
              if($row['cd_interview_status'] == 1) {
                $interview = $this->db->select('ce_id, ce_start_date, ce_end_date, ce_interviewer, ce_interview_round')
                                      ->where('ce_id', $row['cd_id'])
                                      ->get(TBL_CALENDAR)
                                      ->row();
              }
            ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?= base_url('Assets/Admin_Dashboard/img/profile/' . ($row['cd_gender'] === 'Female' ? 'femaleprofile.png' : 'maleprofile.png')) ?>" 
                         style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    <strong><?php echo htmlspecialchars($row['cd_name']); ?></strong>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($row['cd_job_title']); ?></td>
                <td><?php echo htmlspecialchars($row['cd_email']); ?></td>
                <td><?php echo htmlspecialchars($row['cd_phone']); ?></td>
                <td>
                  <?php 
                    $status = $row['cd_status'];
                    $badge_class = 'status-interested';
                    if($status == 'Not Picking up Call') $badge_class = 'status-not-picking';
                    elseif($status == 'Not Interested') $badge_class = 'status-not-interested';
                    elseif($status == 'Call Back Later') $badge_class = 'status-callback';
                  ?>
                  <span class="status-badge <?php echo $badge_class; ?>">
                    <?php echo htmlspecialchars($status); ?>
                  </span>
                </td>
                <td>
                  <?php if($row['cd_interview_status'] == 1 && $interview): ?>
                    <div style="font-size: 0.85rem;">
                      <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 4px;">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <strong>Scheduled</strong>
                      </div>
                      <div style="color: #6b7280; font-size: 0.8rem;">
                        <div><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($interview->ce_start_date)); ?></div>
                        <div><i class="far fa-clock"></i> <?php echo date('h:i A', strtotime($interview->ce_start_date)); ?></div>
                        <div><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($interview->ce_interviewer); ?></div>
                        <?php if(isset($interview->ce_interview_round)): ?>
                          <div><i class="fas fa-layer-group"></i> Round <?php echo round($interview->ce_interview_round * 4); ?></div>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php else: ?>
                    <div style="display: flex; align-items: center; gap: 5px; color: #9ca3af;">
                      <i class="fas fa-times-circle"></i>
                      <span>Not Scheduled</span>
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <?php if($row['cd_interview_status'] == 1): ?>
                      <button 
                        class="btn-action btn-view" 
                        onclick="viewInterviewDetails(<?php echo $row['cd_id']; ?>)"
                        title="View interview details"
                      >
                        <i class="fas fa-eye"></i>
                        View
                      </button>
                      <button 
                        class="btn-action btn-reschedule" 
                        onclick="rescheduleInterview(<?php echo $row['cd_id']; ?>)"
                        title="Reschedule this interview"
                      >
                        <i class="fas fa-calendar-alt"></i>
                        Reschedule
                      </button>
                      <button 
                        class="btn-action btn-cancel" 
                        onclick="cancelInterview(<?php echo $row['cd_id']; ?>)"
                        title="Cancel this interview"
                      >
                        <i class="fas fa-times"></i>
                        Cancel
                      </button>
                    <?php else: ?>
                      <button 
                        class="btn-action btn-schedule" 
                        onclick="scheduleInterview(<?php echo $row['cd_id']; ?>)"
                        <?php echo ($row['cd_status'] != 'Interested') ? 'disabled' : ''; ?>
                        title="<?php echo ($row['cd_status'] != 'Interested') ? 'Candidate must be interested to schedule' : 'Schedule an interview'; ?>"
                      >
                        <i class="fas fa-calendar-plus"></i>
                        Schedule
                      </button>
                    <?php endif; ?>
                    <button class="btn-action btn-edit" onclick="editCandidate(<?php echo $row['cd_id']; ?>)" title="Edit candidate details">
                      <i class="fas fa-edit"></i>
                      Edit
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8">
                <div class="empty-state">
                  <i class="fas fa-inbox"></i>
                  <p>No candidates found</p>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Schedule Interview Modal -->
<div class="modal fade" id="scheduleInterviewModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-calendar-plus me-2"></i>Schedule Interview
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('R_dashboard/schedule_interview') ?>" method="post" id="scheduleInterviewForm">
        <div class="modal-body">
          <input type="hidden" name="candidate_id" id="schedule_candidate_id">
          
          <div class="mb-3">
            <label class="form-label">Candidate Name</label>
            <input type="text" class="form-control" id="schedule_candidate_name" readonly style="background: #f5f5f5;">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="text" class="form-control" id="schedule_position" readonly style="background: #f5f5f5;">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Interview Round <span style="color: red;">*</span></label>
            <select class="form-select" name="interview_round" required>
              <option value="">Select Round</option>
              <option value="0.25">Initial Screening</option>
              <option value="0.5">First Round - Technical</option>
              <option value="0.75">Second Round - HR</option>
              <option value="1">Final Round</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Interviewer(s) <span style="color: red;">*</span></label>
            <select class="form-select" name="interviewers[]" id="interviewers" multiple required style="min-height: 100px;">
              <?php
              $interviewers = $this->db->select('u_username, u_email, u_role')
                                       ->where_in('u_role', array('Admin', 'Recruiter'))
                                       ->get(TBL_USERS)
                                       ->result();
              foreach($interviewers as $interviewer):
              ?>
                <option value="<?= $interviewer->u_username ?>">
                  <?= $interviewer->u_username ?> (<?= $interviewer->u_role ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple interviewers for panel interview</small>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Interview Date <span style="color: red;">*</span></label>
                <input type="date" class="form-control" name="interview_date" id="interview_date" required min="<?= date('Y-m-d') ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Interview Time <span style="color: red;">*</span></label>
                <select class="form-select" name="interview_time" required>
                  <option value="">Select Time</option>
                  <option value="09:00:00">09:00 AM</option>
                  <option value="09:30:00">09:30 AM</option>
                  <option value="10:00:00">10:00 AM</option>
                  <option value="10:30:00">10:30 AM</option>
                  <option value="11:00:00">11:00 AM</option>
                  <option value="11:30:00">11:30 AM</option>
                  <option value="12:00:00">12:00 PM</option>
                  <option value="13:00:00">01:00 PM</option>
                  <option value="13:30:00">01:30 PM</option>
                  <option value="14:00:00">02:00 PM</option>
                  <option value="14:30:00">02:30 PM</option>
                  <option value="15:00:00">03:00 PM</option>
                  <option value="15:30:00">03:30 PM</option>
                  <option value="16:00:00">04:00 PM</option>
                  <option value="16:30:00">04:30 PM</option>
                  <option value="17:00:00">05:00 PM</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Notes (Optional)</label>
            <textarea class="form-control" name="notes" rows="3" placeholder="Add any special instructions or notes..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary-modern btn-modern">
            <i class="fas fa-calendar-check me-2"></i>Schedule Interview
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
