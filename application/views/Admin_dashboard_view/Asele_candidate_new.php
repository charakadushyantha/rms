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
                        if($row['ce_interview_round'] == 1): 
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
                        endif; 
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
    alert('View candidate details: ' + id);
    // Add your view details logic here
}
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/admin_footer', $data);
?>
