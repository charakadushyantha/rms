<?php
$this->load->view('templates/admin_header', array('page_title' => 'System Setup'));
?>

<style>
.setup-category {
    margin-bottom: 2rem;
}

.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 10px 10px 0 0;
    margin-bottom: 0;
}

.category-header h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.category-cards {
    background: white;
    padding: 1.5rem;
    border-radius: 0 0 10px 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.setup-card {
    text-decoration: none;
    display: block;
    transition: all 0.3s;
}

.setup-card:hover {
    transform: translateY(-5px);
}

.setup-card-inner {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    height: 100%;
    transition: all 0.3s;
}

.setup-card:hover .setup-card-inner {
    border-color: #667eea;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
}

.setup-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
}

.setup-card h5 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.setup-card p {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}

.badge-new {
    background: linear-gradient(90deg, #4ade80, #3b82f6);
    color: white;
    font-size: 0.65rem;
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 5px;
}

.badge-coming {
    background: #fbbf24;
    color: #78350f;
    font-size: 0.65rem;
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 5px;
}
</style>

<div class="row g-4">
    <div class="col-12">
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-cog me-2"></i>System Setup & Configuration
                </h3>
            </div>
            <p class="p-3 text-muted">Configure and manage all system settings, integrations, and business rules.</p>
        </div>
    </div>
</div>

<!-- Core Configuration -->
<div class="setup-category">
    <div class="category-header">
        <h4><i class="fas fa-building me-2"></i>Core Configuration</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">

            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/company_settings') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5>Company Settings</h5>
                        <p>Profile, branches & departments</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/job_categories') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5>Job Categories</h5>
                        <p>Manage job classifications</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/job_positions') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h5>Job Positions</h5>
                        <p>Define available positions</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/company_settings#departments') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #36b9cc, #258391);">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <h5>Departments</h5>
                        <p>Organizational structure</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Management -->
<div class="setup-category">
    <div class="category-header">
        <h4><i class="fas fa-users-cog me-2"></i>User Management</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/manage_users') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #858796, #60616f);">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <h5>Manage Users</h5>
                        <p>Add, edit, and remove users</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/manage_recruiters') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Recruiters</h5>
                        <p>Manage recruiter accounts</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/manage_interviewers') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #e74a3b, #c92a2a);">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5>Interviewers</h5>
                        <p>Manage interviewer accounts</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Roles & Permissions <span class="badge-coming">Soon</span></h5>
                        <p>Configure user permissions</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Communication -->
<div class="setup-category">
    <div class="category-header">
        <h4><i class="fas fa-envelope me-2"></i>Communication</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <h5>Email Configuration <span class="badge-coming">Soon</span></h5>
                        <p>SMTP and email templates</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-sms"></i>
                        </div>
                        <h5>SMS Settings <span class="badge-coming">Soon</span></h5>
                        <p>SMS gateway configuration</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #25D366, #128C7E);">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp Setup <span class="badge-coming">Soon</span></h5>
                        <p>WhatsApp Business API</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h5>Notification Center <span class="badge-coming">Soon</span></h5>
                        <p>Manage all notifications</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Automation -->
<div class="setup-category">
    <div class="category-header">
        <h4><i class="fas fa-robot me-2"></i>Automation</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h5>Workflow Builder <span class="badge-coming">Soon</span></h5>
                        <p>Automate recruitment process</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-mail-bulk"></i>
                        </div>
                        <h5>Email Campaigns <span class="badge-coming">Soon</span></h5>
                        <p>Automated email sequences</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h5>Assessment Settings <span class="badge-coming">Soon</span></h5>
                        <p>Configure tests & quizzes</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #36b9cc, #258391);">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5>Scoring Rules <span class="badge-coming">Soon</span></h5>
                        <p>Candidate evaluation criteria</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Compliance (Sri Lankan Specific) -->
<div class="setup-category">
    <div class="category-header" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
        <h4><i class="fas fa-balance-scale me-2"></i>Compliance (Sri Lankan Specific)</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h5>EPF/ETF Settings <span class="badge-coming">Soon</span></h5>
                        <p>Employee provident fund setup</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #858796, #60616f);">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h5>Legal Templates <span class="badge-coming">Soon</span></h5>
                        <p>Employment contracts & forms</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5>Document Requirements <span class="badge-coming">Soon</span></h5>
                        <p>Required documents checklist</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #e74a3b, #c92a2a);">
                            <i class="fas fa-archive"></i>
                        </div>
                        <h5>Data Retention <span class="badge-coming">Soon</span></h5>
                        <p>Data retention policies</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Integration -->
<div class="setup-category">
    <div class="category-header" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
        <h4><i class="fas fa-plug me-2"></i>Integration</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h5>Job Boards <span class="badge-coming">Soon</span></h5>
                        <p>LinkedIn, Indeed, Glassdoor</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5>Calendar Sync <span class="badge-coming">Soon</span></h5>
                        <p>Google, Outlook, iCal</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                            <i class="fas fa-code"></i>
                        </div>
                        <h5>API Management <span class="badge-coming">Soon</span></h5>
                        <p>API keys and endpoints</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #36b9cc, #258391);">
                            <i class="fas fa-webhook"></i>
                        </div>
                        <h5>Webhooks <span class="badge-coming">Soon</span></h5>
                        <p>Event-driven integrations</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- System -->
<div class="setup-category">
    <div class="category-header" style="background: linear-gradient(135deg, #858796, #60616f);">
        <h4><i class="fas fa-server me-2"></i>System</h4>
    </div>
    <div class="category-cards">
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/database') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-database"></i>
                        </div>
                        <h5>Database</h5>
                        <p>View tables and statistics</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                            <i class="fas fa-hdd"></i>
                        </div>
                        <h5>Backup & Recovery <span class="badge-coming">Soon</span></h5>
                        <p>Database backup management</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #e74a3b, #c92a2a);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Security Settings <span class="badge-coming">Soon</span></h5>
                        <p>Password policies & 2FA</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="setup-card" onclick="alert('Coming Soon!'); return false;">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
                            <i class="fas fa-history"></i>
                        </div>
                        <h5>Audit Logs <span class="badge-coming">Soon</span></h5>
                        <p>Track system activities</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?= base_url('Setup/sample_data') ?>" class="setup-card">
                    <div class="setup-card-inner">
                        <div class="setup-icon" style="background: linear-gradient(135deg, #36b9cc, #258391);">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h5>Sample Data</h5>
                        <p>Generate test data</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.data-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
</style>

<?php
$this->load->view('templates/admin_footer');
?>
