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
            <th>Scheduled</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
            <?php $i = 1; foreach ($can_details->result_array() as $row): ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><strong><?php echo htmlspecialchars($row['cd_name']); ?></strong></td>
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
                <td style="text-align: center;">
                  <?php if($row['cd_interview_status'] == 1): ?>
                    <i class="fas fa-check-circle check-icon"></i>
                  <?php else: ?>
                    <i class="fas fa-times-circle times-icon"></i>
                  <?php endif; ?>
                </td>
                <td>
                  <div style="display: flex; gap: 0.5rem;">
                    <?php if($row['cd_interview_status'] == 1): ?>
                      <button class="btn-action btn-schedule" disabled>
                        <i class="fas fa-calendar-check"></i>
                        Scheduled
                      </button>
                    <?php else: ?>
                      <button 
                        class="btn-action btn-schedule" 
                        onclick="scheduleInterview(<?php echo $row['cd_id']; ?>)"
                        <?php echo ($row['cd_status'] != 'Interested') ? 'disabled' : ''; ?>
                      >
                        <i class="fas fa-calendar-plus"></i>
                        Schedule
                      </button>
                    <?php endif; ?>
                    <button class="btn-action btn-edit" onclick="editCandidate(<?php echo $row['cd_id']; ?>)">
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

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
  const searchTerm = this.value.toLowerCase();
  const table = document.getElementById('candidateTable');
  const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
  
  for(let row of rows) {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchTerm) ? '' : 'none';
  }
});

function scheduleInterview(candidateId) {
  window.location.href = '<?php echo base_url("R_dashboard/Rcalendar_view"); ?>?candidate_id=' + candidateId;
}

function editCandidate(candidateId) {
  // Add your edit functionality here
  alert('Edit candidate ID: ' + candidateId);
}
</script>
