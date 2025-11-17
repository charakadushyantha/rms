<?php
// Load the admin header template
$data['page_title'] = isset($page_title) ? $page_title : 'Signup Audit Logs';
$data['use_datatable'] = true;
$this->load->view('templates/admin_header', $data);
?>

<style>
    .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .audit-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .action-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .action-user_approved { background: #d4edda; color: #155724; }
        .action-user_rejected { background: #f8d7da; color: #721c24; }
        .action-user_created { background: #d1ecf1; color: #0c5460; }
        .action-user_updated { background: #fff3cd; color: #856404; }
        .action-user_deleted { background: #f8d7da; color: #721c24; }
        .action-status_changed { background: #e2e3e5; color: #383d41; }
        .action-bulk_approval { background: #d4edda; color: #155724; }
        .action-settings_updated { background: #cce5ff; color: #004085; }
        
        .stat-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .stat-box:hover {
            transform: translateY(-4px);
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 8px;
        }
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
</style>

<!-- Page Content -->
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2"><i class="fas fa-history me-2"></i><?php echo $page_title; ?></h1>
                    <p class="mb-0 opacity-75">Complete activity log of all signup controller actions</p>
                </div>
                <div>
                    <a href="<?php echo base_url('Signup_controller/export_audit_logs'); ?>" class="btn btn-light me-2">
                        <i class="fas fa-download me-1"></i>Export CSV
                    </a>
                    <a href="<?php echo base_url('Signup_controller'); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number"><?php echo $total_logs; ?></div>
                    <div class="stat-label">Total Activities</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number">
                        <?php 
                        $today_count = 0;
                        foreach($audit_logs as $log) {
                            if(date('Y-m-d', strtotime($log->created_at)) == date('Y-m-d')) {
                                $today_count++;
                            }
                        }
                        echo $today_count;
                        ?>
                    </div>
                    <div class="stat-label">Today's Activities</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number">
                        <?php 
                        $unique_admins = array();
                        foreach($audit_logs as $log) {
                            if($log->performed_by && !in_array($log->performed_by, $unique_admins)) {
                                $unique_admins[] = $log->performed_by;
                            }
                        }
                        echo count($unique_admins);
                        ?>
                    </div>
                    <div class="stat-label">Active Admins</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-number">
                        <?php 
                        $week_count = 0;
                        $week_ago = date('Y-m-d', strtotime('-7 days'));
                        foreach($audit_logs as $log) {
                            if(date('Y-m-d', strtotime($log->created_at)) >= $week_ago) {
                                $week_count++;
                            }
                        }
                        echo $week_count;
                        ?>
                    </div>
                    <div class="stat-label">This Week</div>
                </div>
            </div>
        </div>

        <!-- Audit Logs Table -->
        <div class="audit-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Activity Log</h5>
                <div>
                    <span class="text-muted">Showing <?php echo count($audit_logs); ?> of <?php echo $total_logs; ?> records</span>
                </div>
            </div>

            <?php if (!empty($audit_logs)): ?>
            <div class="table-responsive">
                <table class="table table-hover" id="auditLogsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>Performed By</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($audit_logs as $log): ?>
                        <tr>
                            <td><span class="badge bg-secondary">#<?php echo $log->id; ?></span></td>
                            <td>
                                <span class="action-badge action-<?php echo $log->action; ?>">
                                    <?php echo ucwords(str_replace('_', ' ', $log->action)); ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                // Clean up the details display
                                $details = $log->details;
                                $original_details = $details;
                                
                                // Remove JSON-like formatting if present
                                $details = str_replace('{"admin_signup_enabled":', 'Admin Signup: ', $details);
                                $details = str_replace('"recruiter_signup_enabled":', ' | Recruiter Signup: ', $details);
                                $details = str_replace('"interviewer_signup_enabled":', ' | Interviewer Signup: ', $details);
                                $details = str_replace('"candidate_signup_enabled":', ' | Candidate Signup: ', $details);
                                $details = str_replace('"auto_approve_admin":', ' | Auto-approve Admin: ', $details);
                                $details = str_replace('"auto_approve_recruiter":', ' | Auto-approve Recruiter: ', $details);
                                $details = str_replace('"auto_approve_interviewer":', ' | Auto-approve Interviewer: ', $details);
                                $details = str_replace('"auto_approve_candidate":', ' | Auto-approve Candidate: ', $details);
                                $details = str_replace('"require_email_verification":', ' | Email Verification: ', $details);
                                $details = str_replace('"default_signup_role":', ' | Default Role: ', $details);
                                $details = str_replace('"updated_at":', ' | Updated: ', $details);
                                $details = str_replace('"updated_by":', ' | By: ', $details);
                                $details = str_replace('_', ' ', $details);
                                $details = str_replace('{', '', $details);
                                $details = str_replace('}', '', $details);
                                $details = str_replace('"', '', $details);
                                $details = str_replace(',', '', $details);
                                $details = str_replace('0', 'No', $details);
                                $details = str_replace('1', 'Yes', $details);
                                
                                // Check if details are too long
                                $is_long = strlen($details) > 100;
                                $short_details = $is_long ? substr($details, 0, 100) . '...' : $details;
                                ?>
                                
                                <div style="max-width: 500px;">
                                    <div class="details-short">
                                        <?php echo htmlspecialchars($short_details); ?>
                                        <?php if ($is_long): ?>
                                        <a href="#" class="text-primary" onclick="toggleDetails(<?php echo $log->id; ?>); return false;">
                                            <small>[Show more]</small>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($is_long): ?>
                                    <div class="details-full" id="details-<?php echo $log->id; ?>" style="display: none;">
                                        <?php echo htmlspecialchars($details); ?>
                                        <a href="#" class="text-primary" onclick="toggleDetails(<?php echo $log->id; ?>); return false;">
                                            <small>[Show less]</small>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-user-shield text-primary me-1"></i>
                                <?php echo htmlspecialchars($log->performed_by ? $log->performed_by : 'System'); ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-network-wired me-1"></i>
                                    <?php echo htmlspecialchars($log->ip_address ? $log->ip_address : 'N/A'); ?>
                                </small>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo date('M d, Y', strtotime($log->created_at)); ?>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?php echo date('h:i A', strtotime($log->created_at)); ?>
                                </small>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_logs > $limit): ?>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_logs); ?> of <?php echo $total_logs; ?> entries
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <?php if ($offset > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="?offset=<?php echo max(0, $offset - $limit); ?>">Previous</a>
                        </li>
                        <?php endif; ?>
                        
                        <?php
                        $total_pages = ceil($total_logs / $limit);
                        $current_page = floor($offset / $limit) + 1;
                        
                        for ($i = 1; $i <= $total_pages; $i++):
                            if ($i == 1 || $i == $total_pages || abs($i - $current_page) <= 2):
                        ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?offset=<?php echo ($i - 1) * $limit; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                            elseif (abs($i - $current_page) == 3):
                        ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php
                            endif;
                        endfor;
                        ?>
                        
                        <?php if ($offset + $limit < $total_logs): ?>
                        <li class="page-item">
                            <a class="page-link" href="?offset=<?php echo $offset + $limit; ?>">Next</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No audit logs found</h5>
                <p class="text-muted">Activity logs will appear here as actions are performed</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Action Legend -->
        <div class="audit-card">
            <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Action Types Legend</h6>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-user_approved">User Approved</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-user_rejected">User Rejected</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-user_created">User Created</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-user_updated">User Updated</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-user_deleted">User Deleted</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-status_changed">Status Changed</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-bulk_approval">Bulk Approval</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="action-badge action-settings_updated">Settings Updated</span>
                </div>
            </div>
        </div>

</div>
<!-- End Content Area -->

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#auditLogsTable').DataTable({
        pageLength: 25,
        order: [[0, 'desc']], // Sort by ID descending (newest first)
        columnDefs: [
            { orderable: false, targets: [2] } // Disable sorting on details column
        ],
        language: {
            search: "Search logs:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ logs",
            infoEmpty: "No logs available",
            infoFiltered: "(filtered from _MAX_ total logs)"
        }
    });
});

function toggleDetails(id) {
    const shortDiv = $('#details-' + id).siblings('.details-short');
    const fullDiv = $('#details-' + id);
    
    if (fullDiv.is(':visible')) {
        fullDiv.hide();
        shortDiv.show();
    } else {
        shortDiv.hide();
        fullDiv.show();
    }
}
</script>

<?php $this->load->view('templates/admin_footer'); ?>