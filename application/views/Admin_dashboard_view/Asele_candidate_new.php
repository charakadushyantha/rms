<?php
// Set page-specific variables
$data['page_title'] = 'Selected Candidates';
$data['use_datatable'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<!-- Stats Row -->
<?php if(!isset($selected_this_month) || ($selected_this_month == 0 && $selected_this_week == 0 && $selected_today == 0)): ?>
<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Note:</strong> Time-based statistics require the <code>cd_created_at</code> column. 
    <a href="<?= base_url('add_created_at_column.php') ?>" class="alert-link">Click here to add it</a> or all stats will show total count.
</div>
<?php endif; ?>

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
            <div class="stat-card-value"><?= isset($selected_this_month) ? $selected_this_month : 0 ?></div>
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
            <div class="stat-card-value"><?= isset($selected_this_week) ? $selected_this_week : 0 ?></div>
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
            <div class="stat-card-value"><?= isset($selected_today) ? $selected_today : 0 ?></div>
            <div class="stat-card-footer">Selected today</div>
        </div>
    </div>
</div>

<!-- Selected Candidates Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">All Candidates</h3>
        <div>
            <button class="btn btn-primary-modern btn-modern" onclick="exportFilteredData()">
                <i class="fas fa-download me-2"></i>Export Data
            </button>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="p-3 bg-light border-bottom">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">
                    <i class="fas fa-search me-1"></i>Search
                </label>
                <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search candidates...">
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-flag me-1"></i>Status
                </label>
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Round 1">Round 1</option>
                    <option value="Round 2">Round 2</option>
                    <option value="Round 3">Round 3</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-tasks me-1"></i>Progress
                </label>
                <select class="form-select form-select-sm" id="progressFilter">
                    <option value="">All Progress</option>
                    <option value="100">100% Complete</option>
                    <option value="75-99">75-99% Complete</option>
                    <option value="50-74">50-74% Complete</option>
                    <option value="25-49">25-49% Complete</option>
                    <option value="0-24">0-24% Complete</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-user-tie me-1"></i>Recruiter
                </label>
                <select class="form-select form-select-sm" id="recruiterFilter">
                    <option value="">All Recruiters</option>
                    <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
                        <?php 
                        $recruiters = array();
                        foreach($can_details->result() as $row) {
                            if(!empty($row->cd_rec_username) && !in_array($row->cd_rec_username, $recruiters)) {
                                $recruiters[] = $row->cd_rec_username;
                            }
                        }
                        foreach($recruiters as $recruiter): 
                        ?>
                            <option value="<?= $recruiter ?>"><?= $recruiter ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label small fw-bold">
                    <i class="fas fa-briefcase me-1"></i>Job Title
                </label>
                <select class="form-select form-select-sm" id="jobFilter">
                    <option value="">All Jobs</option>
                    <?php if(isset($can_details) && $can_details->num_rows() > 0): ?>
                        <?php 
                        $jobs = array();
                        foreach($can_details->result() as $row) {
                            if(!empty($row->cd_job_title) && !in_array($row->cd_job_title, $jobs)) {
                                $jobs[] = $row->cd_job_title;
                            }
                        }
                        foreach($jobs as $job): 
                        ?>
                            <option value="<?= $job ?>"><?= $job ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()" title="Reset Filters">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-12">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Showing <span id="filteredCount">0</span> of <span id="totalCount">0</span> candidates
                </small>
            </div>
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
                                <button class="btn btn-sm btn-primary-modern btn-modern view-candidate-btn" data-candidate-id="<?= $row['cd_id'] ?>">
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
$base_url = base_url();
$custom_script = <<<JAVASCRIPT
// Initialize DataTable
$(document).ready(function() {
    console.log('=== SCRIPT LOADED SUCCESSFULLY ===');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Initializing DataTable and event handlers...');
    
    // Add a visible indicator that script loaded
    $('body').append('<div id="script-loaded-indicator" style="position:fixed;top:10px;right:10px;background:green;color:white;padding:5px 10px;border-radius:5px;z-index:9999;">Script Loaded ✓</div>');
    setTimeout(function() { $('#script-loaded-indicator').fadeOut(); }, 3000);
    
    var table = $('#candidatesTable').DataTable({
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
        ],
        dom: 'lrtip', // Remove default search box
        initComplete: function() {
            updateCounts();
        }
    });
    
    // Custom search filter
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
        updateCounts();
    });
    
    // Custom column filters
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var statusFilter = $('#statusFilter').val();
            var progressFilter = $('#progressFilter').val();
            var recruiterFilter = $('#recruiterFilter').val();
            var jobFilter = $('#jobFilter').val();
            
            var status = data[7] || ''; // Status column
            var recruiter = data[2] || ''; // Recruiter column
            var job = data[3] || ''; // Job Title column
            var progress = data[5] || ''; // Progress column (if exists)
            
            // Status filter
            if (statusFilter && !status.includes(statusFilter)) {
                return false;
            }
            
            // Recruiter filter
            if (recruiterFilter && !recruiter.includes(recruiterFilter)) {
                return false;
            }
            
            // Job filter
            if (jobFilter && !job.includes(jobFilter)) {
                return false;
            }
            
            // Progress filter
            if (progressFilter) {
                var progressNum = parseInt(progress);
                if (progressFilter === '100' && progressNum !== 100) return false;
                if (progressFilter === '75-99' && (progressNum < 75 || progressNum >= 100)) return false;
                if (progressFilter === '50-74' && (progressNum < 50 || progressNum >= 75)) return false;
                if (progressFilter === '25-49' && (progressNum < 25 || progressNum >= 50)) return false;
                if (progressFilter === '0-24' && (progressNum < 0 || progressNum >= 25)) return false;
            }
            
            return true;
        }
    );
    
    // Apply filters on change
    $('#statusFilter, #progressFilter, #recruiterFilter, #jobFilter').on('change', function() {
        table.draw();
        updateCounts();
    });
    
    // Update counts
    function updateCounts() {
        var info = table.page.info();
        $('#filteredCount').text(info.recordsDisplay);
        $('#totalCount').text(info.recordsTotal);
    }
    
    // Make updateCounts global
    window.updateCounts = updateCounts;
    
    // Event delegation for view button clicks
    $(document).on('click', '.view-candidate-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('candidate-id');
        console.log('Button clicked! Candidate ID:', candidateId);
        viewDetails(candidateId);
    });
    
    console.log('Event handlers attached successfully');
});

function viewDetails(id) {
    console.log('Viewing candidate ID:', id);
    
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
        alert('jQuery is not loaded. Please refresh the page.');
        return;
    }
    
    // Fetch candidate details via AJAX
    $.ajax({
        url: '{$base_url}A_dashboard/get_candidate_details',
        type: 'POST',
        data: { candidate_id: id },
        dataType: 'json',
        beforeSend: function() {
            console.log('Sending AJAX request...');
        },
        success: function(response) {
            console.log('Response received:', response);
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
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response:', xhr.responseText);
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch candidate details: ' + error
                });
            } else {
                alert('Error: Failed to fetch candidate details. Check console for details.');
            }
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

// Reset filters function
function resetFilters() {
    $('#searchInput').val('');
    $('#statusFilter').val('');
    $('#progressFilter').val('');
    $('#recruiterFilter').val('');
    $('#jobFilter').val('');
    var table = $('#candidatesTable').DataTable();
    table.search('').draw();
    if (typeof updateCounts === 'function') {
        updateCounts();
    }
}

// Export filtered data function
function exportFilteredData() {
    var table = $('#candidatesTable').DataTable();
    var data = table.rows({ search: 'applied' }).data();
    
    // Create CSV content
    var csv = 'No,Name,Recruiter,Job Title,Email,Phone,Progress,Status\\n';
    data.each(function(row) {
        // Clean HTML tags from data
        var cleanRow = [];
        for (var i = 0; i < row.length - 1; i++) { // Exclude Actions column
            var cell = row[i].toString().replace(/<[^>]*>/g, '').replace(/,/g, ';');
            cleanRow.push(cell);
        }
        csv += cleanRow.join(',') + '\\n';
    });
    
    // Download CSV
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'candidates_' + new Date().toISOString().slice(0,10) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

JAVASCRIPT;

// Load the footer template
$this->load->view('templates/admin_footer');
?>

<script>
<?= $custom_script ?>
</script>
