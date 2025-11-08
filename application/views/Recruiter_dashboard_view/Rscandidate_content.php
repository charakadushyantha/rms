<style>
.selected-wrapper {
  max-width: 1200px;
  margin: 1.5rem auto;
  padding: 0 1rem;
}

.selected-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  overflow: hidden;
}

.selected-header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.selected-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.selected-header h3 i {
  color: #10b981;
}

.selected-actions {
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

.stats-bar {
  padding: 1rem 2rem;
  background: #f9fafb;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  gap: 2rem;
  align-items: center;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.stat-item i {
  color: #10b981;
  font-size: 1.125rem;
}

.stat-item span {
  font-size: 0.875rem;
  color: #6b7280;
}

.stat-item strong {
  color: #1f2937;
  font-size: 1.125rem;
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

.round-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.8125rem;
  font-weight: 500;
}

.round-1 {
  background: #dbeafe;
  color: #1e40af;
}

.round-2 {
  background: #e0e7ff;
  color: #4338ca;
}

.round-3 {
  background: #fce7f3;
  color: #9f1239;
}

.round-final {
  background: #d1fae5;
  color: #065f46;
}

.status-selected {
  background: #d1fae5;
  color: #065f46;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.8125rem;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
}

.status-selected i {
  font-size: 0.875rem;
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

.btn-view {
  background: #667eea;
  color: white;
}

.btn-view:hover {
  background: #5568d3;
  transform: translateY(-1px);
}

.btn-contact {
  background: #f3f4f6;
  color: #6b7280;
}

.btn-contact:hover {
  background: #e5e7eb;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: #9ca3af;
}

.empty-state i {
  font-size: 4rem;
  margin-bottom: 1rem;
  opacity: 0.3;
  color: #d1d5db;
}

.empty-state h4 {
  font-size: 1.125rem;
  color: #6b7280;
  margin: 0 0 0.5rem 0;
}

.empty-state p {
  font-size: 0.875rem;
  margin: 0;
}

@media (max-width: 768px) {
  .selected-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .search-box input {
    width: 100%;
  }
  
  .stats-bar {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
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

<div class="selected-wrapper">
  <div class="selected-card">
    <div class="selected-header">
      <h3>
        <i class="fas fa-user-check"></i>
        Selected Candidates
      </h3>
      <div class="selected-actions">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" id="searchInput" placeholder="Search candidates...">
        </div>
      </div>
    </div>
    
    <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
    <div class="stats-bar">
      <div class="stat-item">
        <i class="fas fa-users"></i>
        <span>Total Selected:</span>
        <strong><?php echo $can_details->num_rows(); ?></strong>
      </div>
    </div>
    <?php endif; ?>
    
    <div class="table-container">
      <table class="modern-table" id="candidateTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Candidate Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Interview Round</th>
            <th>Status</th>
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
                    $round = isset($row['cd_interview_round']) ? $row['cd_interview_round'] : 1;
                    $round_class = 'round-1';
                    $round_text = 'Round 1';
                    
                    if($round == 2) {
                      $round_class = 'round-2';
                      $round_text = 'Round 2';
                    } elseif($round == 3) {
                      $round_class = 'round-3';
                      $round_text = 'Round 3';
                    } elseif($round >= 4) {
                      $round_class = 'round-final';
                      $round_text = 'Final Round';
                    }
                  ?>
                  <span class="round-badge <?php echo $round_class; ?>">
                    <?php echo $round_text; ?>
                  </span>
                </td>
                <td>
                  <span class="status-selected">
                    <i class="fas fa-check-circle"></i>
                    Selected
                  </span>
                </td>
                <td>
                  <div style="display: flex; gap: 0.5rem;">
                    <button class="btn-action btn-view" onclick="viewCandidate(<?php echo $row['cd_id']; ?>)">
                      <i class="fas fa-eye"></i>
                      View
                    </button>
                    <button class="btn-action btn-contact" onclick="contactCandidate('<?php echo htmlspecialchars($row['cd_email']); ?>')">
                      <i class="fas fa-envelope"></i>
                      Contact
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8">
                <div class="empty-state">
                  <i class="fas fa-user-check"></i>
                  <h4>No Selected Candidates Yet</h4>
                  <p>Candidates who pass the interview process will appear here</p>
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

function viewCandidate(candidateId) {
  // Add your view candidate details functionality
  window.location.href = '<?php echo base_url("R_dashboard/view_candidate_details/"); ?>' + candidateId;
}

function contactCandidate(email) {
  window.location.href = 'mailto:' + email;
}
</script>
