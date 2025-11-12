<!-- Help & Documentation Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="helpModalLabel">
                    <i class="fas fa-book me-2"></i>Help & System Documentation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Sidebar Navigation -->
                    <div class="col-md-3">
                        <div class="list-group" id="help-nav">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#help-getting-started">
                                <i class="fas fa-rocket me-2"></i>Getting Started
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-dashboard">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-candidates">
                                <i class="fas fa-users me-2"></i>Managing Candidates
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-jobs">
                                <i class="fas fa-briefcase me-2"></i>Job Postings
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-interviews">
                                <i class="fas fa-calendar-check me-2"></i>Interviews
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-reports">
                                <i class="fas fa-chart-bar me-2"></i>Reports & Analytics
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-setup">
                                <i class="fas fa-cog me-2"></i>System Setup
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-troubleshooting">
                                <i class="fas fa-wrench me-2"></i>Troubleshooting
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#help-faq">
                                <i class="fas fa-question-circle me-2"></i>FAQ
                            </a>
                        </div>
                        
                        <div class="card mt-3 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-headset fa-2x text-primary mb-2"></i>
                                <h6>Need More Help?</h6>
                                <p class="small text-muted">Contact our support team</p>
                                <a href="mailto:support@rms.com" class="btn btn-sm btn-primary">
                                    <i class="fas fa-envelope me-1"></i>Email Support
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="col-md-9">
                        <div class="tab-content" id="help-content">
                            
                            <!-- Getting Started -->
                            <div class="tab-pane fade show active" id="help-getting-started">
                                <h4 class="mb-3"><i class="fas fa-rocket me-2 text-primary"></i>Getting Started</h4>
                                <p class="lead">Welcome to the Recruitment Management System! This guide will help you get started quickly.</p>
                                
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Quick Start Guide</h6>
                                    </div>
                                    <div class="card-body">
                                        <ol>
                                            <li class="mb-2">
                                                <strong>Set Up Your Company Profile</strong> - Navigate to Setup → Company Settings to configure your organization details.
                                                <br><a href="<?= base_url('Setup/company_settings') ?>" class="btn btn-sm btn-outline-primary mt-1" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-right me-1"></i>Go to Company Settings
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Create Job Positions</strong> - Go to Setup → Job Positions to define available roles.
                                                <br><a href="<?= base_url('Setup/job_positions') ?>" class="btn btn-sm btn-outline-primary mt-1" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-right me-1"></i>Go to Job Positions
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Add Users</strong> - Set up recruiters and interviewers in Setup → User Management.
                                                <br><a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-sm btn-outline-primary mt-1" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-right me-1"></i>Go to User Management
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Post Your First Job</strong> - Click "New Job" from the Jobs menu to create a job posting.
                                                <br><a href="<?= base_url('A_dashboard/Ajob_post_view') ?>" class="btn btn-sm btn-outline-primary mt-1" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-right me-1"></i>Create New Job
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Start Receiving Applications</strong> - Share your job posting link or manually add candidates.
                                                <br><a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-sm btn-outline-primary mt-1" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-right me-1"></i>View Candidates
                                                </a>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Pro Tip:</strong> Use the Setup wizard to configure all essential settings in one go!
                                    <a href="<?= base_url('Setup') ?>" class="btn btn-sm btn-primary ms-2" data-bs-dismiss="modal">
                                        <i class="fas fa-cog me-1"></i>Open Setup
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Dashboard -->
                            <div class="tab-pane fade" id="help-dashboard">
                                <h4 class="mb-3"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Overview</h4>
                                <p class="lead">The enhanced dashboard provides a real-time, interactive overview of your recruitment activities with modern UI/UX features.</p>
                                
                                <div class="mb-4">
                                    <a href="<?= base_url('A_dashboard') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                                    </a>
                                </div>
                                
                                <div class="card mb-3 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-star me-2"></i>New Features</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="mb-0">
                                            <li><strong>Welcome Banner:</strong> Personalized greeting with quick refresh button</li>
                                            <li><strong>Quick Actions:</strong> One-click access to common tasks (Add Candidate, Schedule Interview, View Reports, Audit Logs)</li>
                                            <li><strong>Enhanced Statistics Cards:</strong> Animated cards with hover effects showing key metrics</li>
                                            <li><strong>Recent Candidates Widget:</strong> Compact list showing the 5 most recent candidates with colorful avatars</li>
                                            <li><strong>Active Filters Display:</strong> Visual badges showing currently applied filters with one-click removal</li>
                                            <li><strong>Smooth Animations:</strong> Professional transitions and count-up effects</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <h6 class="mt-4"><i class="fas fa-chart-line me-2 text-success"></i>Key Metrics Cards</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <strong>Total Candidates</strong>
                                                <p class="small text-muted mb-0">Shows the total number of candidates in your system with animated count-up effect</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <strong>Selected</strong>
                                                <p class="small text-muted mb-0">Successfully selected candidates (green card)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <strong>In Progress</strong>
                                                <p class="small text-muted mb-0">Candidates with interviews scheduled (yellow card)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <strong>Interested</strong>
                                                <p class="small text-muted mb-0">Interested candidates awaiting next steps (cyan card)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mt-4"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h6>
                                <p>Four colorful action cards provide instant access to common tasks:</p>
                                <ul>
                                    <li><strong>Add Candidate:</strong> Register new candidate (purple gradient)</li>
                                    <li><strong>Schedule Interview:</strong> Book interview slots (pink gradient)</li>
                                    <li><strong>View Reports:</strong> Analytics & insights (blue gradient)</li>
                                    <li><strong>Audit Logs:</strong> Track system activities (orange gradient)</li>
                                </ul>
                                
                                <h6 class="mt-4"><i class="fas fa-users me-2 text-info"></i>Recent Candidates Widget</h6>
                                <p>Displays the 5 most recent candidates with:</p>
                                <ul>
                                    <li>Colorful avatar with candidate initials</li>
                                    <li>Active status indicator (green dot)</li>
                                    <li>Hover effects for better interactivity</li>
                                    <li>"View All Candidates" button at the bottom</li>
                                    <li>Shows "+X more" if there are additional candidates</li>
                                </ul>
                                
                                <h6 class="mt-4"><i class="fas fa-filter me-2 text-primary"></i>Advanced Filtering</h6>
                                <p>The candidates table includes powerful filtering options:</p>
                                <ul>
                                    <li><strong>Search:</strong> Real-time search across all candidate fields</li>
                                    <li><strong>Status Filter:</strong> Filter by interview round (Not Started, Round 1-3, Completed)</li>
                                    <li><strong>Progress Filter:</strong> Filter by completion percentage (0-24%, 25-49%, 50-74%, 75-99%, 100%)</li>
                                    <li><strong>Recruiter Filter:</strong> View candidates by assigned recruiter</li>
                                    <li><strong>Job Title Filter:</strong> Filter by job position</li>
                                    <li><strong>Active Filters Display:</strong> Visual badges show applied filters with click-to-remove functionality</li>
                                    <li><strong>Reset Button:</strong> Clear all filters instantly</li>
                                </ul>
                                
                                <h6 class="mt-4"><i class="fas fa-chart-bar me-2 text-success"></i>Candidate Status Chart</h6>
                                <p>Interactive bar chart showing the distribution of candidates across different statuses. Hover over bars to see exact numbers.</p>
                                
                                <h6 class="mt-4"><i class="fas fa-download me-2 text-primary"></i>Export Options</h6>
                                <p>Multiple export options available:</p>
                                <ul>
                                    <li><strong>Export CSV:</strong> Download filtered data to CSV format</li>
                                    <li><strong>Print:</strong> Print-friendly view of the table</li>
                                    <li>Exports respect active filters - only filtered data is exported</li>
                                </ul>
                                
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Pro Tips:</strong>
                                    <ul class="mb-0">
                                        <li>Hover over stat cards to see lift animation</li>
                                        <li>Click on filter badges to remove individual filters</li>
                                        <li>Use the refresh button in the welcome banner to reload dashboard data</li>
                                        <li>The table automatically scrolls into view when you apply filters</li>
                                        <li>Recent candidates list shows only 5 to keep the view compact</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="<?= base_url('A_dashboard/reports_view') ?>" class="btn btn-sm btn-outline-success me-2" data-bs-dismiss="modal">
                                        <i class="fas fa-chart-bar me-1"></i>View Detailed Reports
                                    </a>
                                    <a href="<?= base_url('Setup/audit_logs') ?>" class="btn btn-sm btn-outline-warning" data-bs-dismiss="modal">
                                        <i class="fas fa-history me-1"></i>View Audit Logs
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Managing Candidates -->
                            <div class="tab-pane fade" id="help-candidates">
                                <h4 class="mb-3"><i class="fas fa-users me-2 text-primary"></i>Managing Candidates</h4>
                                
                                <div class="mb-3">
                                    <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-users me-2"></i>Go to Candidates
                                    </a>
                                    <a href="<?= base_url('A_dashboard/Asele_candidate_new') ?>" class="btn btn-success ms-2" data-bs-dismiss="modal">
                                        <i class="fas fa-plus me-2"></i>Add New Candidate
                                    </a>
                                </div>
                                
                                <h6>Adding Candidates</h6>
                                <p>You can add candidates in two ways:</p>
                                <ul>
                                    <li><strong>Manual Entry:</strong> Click "Add Candidate" and fill in the details</li>
                                    <li><strong>Application Form:</strong> Candidates apply through your public job posting link</li>
                                </ul>
                                
                                <h6 class="mt-4">Candidate Status</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-info">New</span></td>
                                                <td>Recently submitted application</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-primary">Screening</span></td>
                                                <td>Under initial review</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-warning">Interview</span></td>
                                                <td>Scheduled for interview</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-success">Selected</span></td>
                                                <td>Offered the position</td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-danger">Rejected</span></td>
                                                <td>Not selected</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h6 class="mt-4">Bulk Actions</h6>
                                <p>Select multiple candidates to perform bulk operations like status updates, email notifications, or exports.</p>
                            </div>
                            
                            <!-- Job Postings -->
                            <div class="tab-pane fade" id="help-jobs">
                                <h4 class="mb-3"><i class="fas fa-briefcase me-2 text-primary"></i>Job Postings</h4>
                                
                                <div class="mb-3">
                                    <a href="<?= base_url('A_dashboard/Ajob_post_view') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-briefcase me-2"></i>View All Jobs
                                    </a>
                                    <a href="<?= base_url('A_dashboard/Ajob_post_view') ?>" class="btn btn-success ms-2" data-bs-dismiss="modal">
                                        <i class="fas fa-plus me-2"></i>Create New Job
                                    </a>
                                </div>
                                
                                <h6>Creating a Job Posting</h6>
                                <ol>
                                    <li>Navigate to Jobs → New Job</li>
                                    <li>Fill in job details (title, description, requirements)</li>
                                    <li>Set salary range and benefits</li>
                                    <li>Choose job category and location</li>
                                    <li>Publish or save as draft</li>
                                </ol>
                                
                                <h6 class="mt-4">Job Status</h6>
                                <ul>
                                    <li><strong>Draft:</strong> Not visible to candidates</li>
                                    <li><strong>Active:</strong> Accepting applications</li>
                                    <li><strong>Closed:</strong> No longer accepting applications</li>
                                    <li><strong>Filled:</strong> Position has been filled</li>
                                </ul>
                                
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-share-alt me-2"></i>
                                    <strong>Sharing Jobs:</strong> Each job has a unique URL that can be shared on social media or job boards.
                                </div>
                            </div>
                            
                            <!-- Interviews -->
                            <div class="tab-pane fade" id="help-interviews">
                                <h4 class="mb-3"><i class="fas fa-calendar-check me-2 text-primary"></i>Interview Management</h4>
                                
                                <div class="mb-3">
                                    <a href="<?= base_url('A_dashboard/Ainterviewer_view') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-calendar-check me-2"></i>View Interviews
                                    </a>
                                    <a href="<?= base_url('Setup/manage_interviewers') ?>" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal">
                                        <i class="fas fa-user-tie me-2"></i>Manage Interviewers
                                    </a>
                                </div>
                                
                                <h6>Scheduling Interviews</h6>
                                <ol>
                                    <li>Select a candidate from the candidate list</li>
                                    <li>Click "Schedule Interview"</li>
                                    <li>Choose date, time, and interview type</li>
                                    <li>Assign interviewers</li>
                                    <li>Add meeting link (for virtual interviews)</li>
                                    <li>Send invitation</li>
                                </ol>
                                
                                <h6 class="mt-4">Interview Types</h6>
                                <ul>
                                    <li><strong>Phone Screening:</strong> Initial phone call</li>
                                    <li><strong>Video Interview:</strong> Online video meeting</li>
                                    <li><strong>In-Person:</strong> Face-to-face interview</li>
                                    <li><strong>Technical Test:</strong> Skills assessment</li>
                                    <li><strong>Final Round:</strong> Last stage interview</li>
                                </ul>
                                
                                <h6 class="mt-4">Calendar Integration</h6>
                                <p>Sync interviews with Google Calendar or Outlook to avoid scheduling conflicts.</p>
                                
                                <div class="mt-3">
                                    <a href="<?= base_url('Setup/calendar_sync') ?>" class="btn btn-sm btn-outline-info" data-bs-dismiss="modal">
                                        <i class="fas fa-calendar-alt me-1"></i>Setup Calendar Sync
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Reports -->
                            <div class="tab-pane fade" id="help-reports">
                                <h4 class="mb-3"><i class="fas fa-chart-bar me-2 text-primary"></i>Reports & Analytics</h4>
                                
                                <div class="mb-3">
                                    <a href="<?= base_url('A_dashboard/reports_view') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-chart-bar me-2"></i>View Reports
                                    </a>
                                </div>
                                
                                <h6>Available Reports</h6>
                                <ul>
                                    <li><strong>Recruitment Pipeline:</strong> Track candidates through each stage</li>
                                    <li><strong>Time to Hire:</strong> Average time from application to offer</li>
                                    <li><strong>Source Effectiveness:</strong> Which channels bring the best candidates</li>
                                    <li><strong>Interview Success Rate:</strong> Conversion rates at each stage</li>
                                    <li><strong>Diversity Metrics:</strong> Track diversity in your hiring</li>
                                </ul>
                                
                                <h6 class="mt-4">Exporting Data</h6>
                                <p>All reports can be exported to Excel, PDF, or CSV formats for further analysis.</p>
                            </div>
                            
                            <!-- System Setup -->
                            <div class="tab-pane fade" id="help-setup">
                                <h4 class="mb-3"><i class="fas fa-cog me-2 text-primary"></i>System Setup</h4>
                                
                                <div class="mb-3">
                                    <a href="<?= base_url('Setup') ?>" class="btn btn-primary" data-bs-dismiss="modal">
                                        <i class="fas fa-cog me-2"></i>Go to System Setup
                                    </a>
                                </div>
                                
                                <h6>Essential Configuration</h6>
                                <div class="accordion" id="setupAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#setup1">
                                                Company Settings
                                            </button>
                                        </h2>
                                        <div id="setup1" class="accordion-collapse collapse show" data-bs-parent="#setupAccordion">
                                            <div class="accordion-body">
                                                Configure your company name, logo, address, and contact information. This appears on job postings and communications.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/company_settings') ?>" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Open Company Settings
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#setup2">
                                                Email Configuration
                                            </button>
                                        </h2>
                                        <div id="setup2" class="accordion-collapse collapse" data-bs-parent="#setupAccordion">
                                            <div class="accordion-body">
                                                Set up SMTP settings for sending automated emails. Configure email templates for different stages of recruitment.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/email_configuration') ?>" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Open Email Configuration
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#setup3">
                                                User Management
                                            </button>
                                        </h2>
                                        <div id="setup3" class="accordion-collapse collapse" data-bs-parent="#setupAccordion">
                                            <div class="accordion-body">
                                                Add recruiters, interviewers, and admins. Assign roles and permissions to control access levels.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-sm btn-outline-primary me-1" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Manage Users
                                                    </a>
                                                    <a href="<?= base_url('A_dashboard/roles_permissions_view') ?>" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-shield-alt me-1"></i>Roles & Permissions
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#setup4">
                                                Automation Settings
                                            </button>
                                        </h2>
                                        <div id="setup4" class="accordion-collapse collapse" data-bs-parent="#setupAccordion">
                                            <div class="accordion-body">
                                                Configure automated email campaigns, assessment settings, and candidate scoring rules to streamline your workflow.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/automation_settings') ?>" class="btn btn-sm btn-outline-primary me-1" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Automation Settings
                                                    </a>
                                                    <a href="<?= base_url('Setup/workflow_builder') ?>" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-project-diagram me-1"></i>Workflow Builder
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Troubleshooting -->
                            <div class="tab-pane fade" id="help-troubleshooting">
                                <h4 class="mb-3"><i class="fas fa-wrench me-2 text-primary"></i>Troubleshooting</h4>
                                
                                <h6>Common Issues & Solutions</h6>
                                
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <strong>Issue:</strong> Emails not being sent
                                    </div>
                                    <div class="card-body">
                                        <strong>Solution:</strong>
                                        <ul>
                                            <li>Check SMTP settings in Setup → Email Configuration</li>
                                            <li>Verify your email credentials are correct</li>
                                            <li>Check if your email provider allows SMTP access</li>
                                            <li>Test the connection using the "Test Email" button</li>
                                        </ul>
                                        <a href="<?= base_url('Setup/email_configuration') ?>" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
                                            <i class="fas fa-cog me-1"></i>Fix Email Settings
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <strong>Issue:</strong> Cannot upload candidate documents
                                    </div>
                                    <div class="card-body">
                                        <strong>Solution:</strong>
                                        <ul>
                                            <li>Check file size (max 10MB per file)</li>
                                            <li>Ensure file format is supported (PDF, DOC, DOCX, JPG, PNG)</li>
                                            <li>Verify upload folder permissions on server</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <strong>Issue:</strong> Calendar sync not working
                                    </div>
                                    <div class="card-body">
                                        <strong>Solution:</strong>
                                        <ul>
                                            <li>Re-authenticate your calendar connection</li>
                                            <li>Check calendar permissions</li>
                                            <li>Ensure time zone settings match</li>
                                        </ul>
                                        <a href="<?= base_url('Setup/calendar_sync') ?>" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
                                            <i class="fas fa-calendar-alt me-1"></i>Fix Calendar Sync
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Still having issues?</strong> Contact support with error details and screenshots.
                                </div>
                            </div>
                            
                            <!-- FAQ -->
                            <div class="tab-pane fade" id="help-faq">
                                <h4 class="mb-3"><i class="fas fa-question-circle me-2 text-primary"></i>Frequently Asked Questions</h4>
                                
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                                How do I reset a user's password?
                                            </button>
                                        </h2>
                                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Go to Setup → User Management, find the user, and click "Reset Password". An email will be sent to the user with reset instructions.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/manage_users') ?>" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Go to User Management
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                                Can I customize email templates?
                                            </button>
                                        </h2>
                                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes! Navigate to Setup → Email Configuration → Templates. You can edit subject lines, body content, and use variables like {candidate_name}, {job_title}, etc.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/email_configuration') ?>" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Edit Email Templates
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                                How do I export candidate data?
                                            </button>
                                        </h2>
                                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                From the Candidates page, select the candidates you want to export, then click "Export" and choose your preferred format (Excel, CSV, or PDF).
                                                <div class="mt-2">
                                                    <a href="<?= base_url('A_dashboard/Acandidate_users_view') ?>" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">
                                                        <i class="fas fa-arrow-right me-1"></i>Go to Candidates
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                                What are the system requirements?
                                            </button>
                                        </h2>
                                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <strong>Browser:</strong> Chrome, Firefox, Safari, or Edge (latest versions)<br>
                                                <strong>Internet:</strong> Stable broadband connection<br>
                                                <strong>Screen:</strong> Minimum 1280x720 resolution
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                                How is my data secured?
                                            </button>
                                        </h2>
                                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                All data is encrypted in transit (SSL/TLS) and at rest. We perform regular backups and follow industry-standard security practices. Access is controlled through role-based permissions.
                                                <div class="mt-2">
                                                    <a href="<?= base_url('Setup/security_settings') ?>" class="btn btn-sm btn-outline-primary me-1" data-bs-dismiss="modal">
                                                        <i class="fas fa-shield-alt me-1"></i>Security Settings
                                                    </a>
                                                    <a href="<?= base_url('Setup/backup_recovery') ?>" class="btn btn-sm btn-outline-success me-1" data-bs-dismiss="modal">
                                                        <i class="fas fa-hdd me-1"></i>Backup & Recovery
                                                    </a>
                                                    <a href="<?= base_url('Setup/audit_logs') ?>" class="btn btn-sm btn-outline-warning" data-bs-dismiss="modal">
                                                        <i class="fas fa-history me-1"></i>Audit Logs
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download PDF Guide
                </a>
            </div>
        </div>
    </div>
</div>

<style>
#helpModal .list-group-item {
    border-left: 3px solid transparent;
    transition: all 0.3s;
}

#helpModal .list-group-item:hover {
    background: #f8f9fa;
    border-left-color: #667eea;
}

#helpModal .list-group-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-left-color: #667eea;
}

#helpModal .tab-content {
    min-height: 500px;
}

#helpModal .card {
    border: 1px solid #e0e0e0;
}

#helpModal .accordion-button:not(.collapsed) {
    background: #f8f9fa;
    color: #667eea;
}
</style>
