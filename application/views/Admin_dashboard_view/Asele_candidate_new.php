<?php
// Set page-specific variables
$data['page_title'] = 'Selected Candidates';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-card-header">
                <div class="stat-card-title">Selected</div>
                <div class="stat-card-icon" style="background: rgba(28, 200, 138, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card-value"><?= isset($can_details) ? $can_details->num_rows() : 0 ?></div>
            <div class="stat-card-footer">Total selected candidates</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-card-header">
                <div class="stat-card-title">This Month</div>
                <div class="stat-card-icon" style="background: rgba(54, 185, 204, 0.1); color: var(--info-color);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Selected this month</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-card-header">
                <div class="stat-card-title">This Week</div>
                <div class="stat-card-icon" style="background: rgba(246, 194, 62, 0.1); color: var(--warning-color);">
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Selected this week</div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-title">Today</div>
                <div class="stat-card-icon" style="background: rgba(102, 126, 234, 0.1); color: var(--primary-color);">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="stat-card-value">0</div>
            <div class="stat-card-footer">Selected today</div>
        </div>
    </div>
</div>

<!-- Selected Candidates Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Selected Candidates</h3>
        <div>
            <button class="btn btn-primary-modern btn-modern">
                <i class="fas fa-download me-2"></i>Export List
            </button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="candidatesTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Recruiter</th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Interview Rounds</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $hasData = false;
                if(isset($can_details) && $can_details->num_rows() > 0): 
                    $i = 1; 
                    foreach ($can_details->result_array() as $row): 
                        // Show all selected candidates
                        $hasData = true;
                ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <div style="font-weight: 600;"><?= $row['cd_name'] ?></div>
                            </td>
                            <td><?= $row['cd_rec_username'] ?></td>
                            <td><?= $row['cd_job_title'] ?></td>
                            <td><?= $row['cd_email'] ?></td>
                            <td><?= $row['cd_phone'] ?></td>
                            <td>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                </div>
                                <small style="color: #999;">4/4 Completed</small>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Selected
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary-modern btn-modern" onclick="viewDetails(<?= $row['cd_id'] ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                <?php 
                    endforeach; 
                endif;
                
                if(!$hasData): 
                ?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><span class="badge bg-secondary">No Data</span></td>
                        <td>-</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$custom_script = "
// Initialize DataTable
$(document).ready(function() {
    $('#candidatesTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            emptyTable: 'No selected candidates yet',
            zeroRecords: 'No matching candidates found',
            search: '_INPUT_',
            searchPlaceholder: 'Search candidates...'
        },
        columnDefs: [
            { orderable: false, targets: 8 } // Disable sorting on Actions column
        ]
    });
});

function viewDetails(id) {
    // Fetch candidate details via AJAX
    $.ajax({
        url: '<?= base_url('A_dashboard/get_candidate_details') ?>',
        type: 'POST',
        data: { candidate_id: id },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                const candidate = response.candidate;
                let modalContent = `
                    <div class=\"modal fade\" id=\"candidateModal\" tabindex=\"-1\">
                        <div class=\"modal-dialog modal-lg\">
                            <div class=\"modal-content\">
                                <div class=\"modal-header\" style=\"background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;\">
                                    <h5 class=\"modal-title\"><i class=\"fas fa-user-circle me-2\"></i>Candidate Details</h5>
                                    <button type=\"button\" class=\"btn-close btn-close-white\" data-bs-dismiss=\"modal\"></button>
                                </div>
                                <div class=\"modal-body\">
                                    <div class=\"row g-3\">
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-user me-2\"></i>Full Name</label>
                                                <p>\${candidate.cd_name || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-briefcase me-2\"></i>Job Title</label>
                                                <p>\${candidate.cd_job_title || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-envelope me-2\"></i>Email</label>
                                                <p>\${candidate.cd_email || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-phone me-2\"></i>Phone</label>
                                                <p>\${candidate.cd_phone || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-venus-mars me-2\"></i>Gender</label>
                                                <p>\${candidate.cd_gender || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-user-tie me-2\"></i>Recruiter</label>
                                                <p>\${candidate.cd_rec_username || 'N/A'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-info-circle me-2\"></i>Status</label>
                                                <p><span class=\"badge bg-success\">\${candidate.cd_status || 'N/A'}</span></p>
                                            </div>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-calendar me-2\"></i>Interview Status</label>
                                                <p>\${candidate.cd_interview_status == 1 ? '<span class=\"badge bg-info\">Scheduled</span>' : '<span class=\"badge bg-secondary\">Not Scheduled</span>'}</p>
                                            </div>
                                        </div>
                                        <div class=\"col-12\">
                                            <div class=\"detail-item\">
                                                <label><i class=\"fas fa-align-left me-2\"></i>Description</label>
                                                <p>\${candidate.cd_description || 'No description available'}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"modal-footer\">
                                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing modal if any
                $('#candidateModal').remove();
                
                // Append and show modal
                $('body').append(modalContent);
                $('#candidateModal').modal('show');
                
                // Clean up modal after it's hidden
                $('#candidateModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to load candidate details'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch candidate details'
            });
        }
    });
}

// Add CSS for detail items
const style = document.createElement('style');
style.textContent = `
    .detail-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid var(--primary-color);
    }
    .detail-item label {
        font-weight: 600;
        color: #666;
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
    }
    .detail-item p {
        margin: 0;
        color: #333;
        font-size: 14px;
    }
`;
document.head.appendChild(style);
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
