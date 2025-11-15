<?php $this->load->view('templates/admin_header'); ?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <h1 class="h2 mb-2">
                <i class="fas fa-bullhorn text-primary"></i> Sales & Marketing Hub
            </h1>
            <p class="text-muted">Manage recruitment marketing, candidate sourcing, and employer branding</p>
        </div>

        <!-- Job Posting & Distribution -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-share-alt me-2"></i>Job Posting & Distribution</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Job_posting') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <h5>Job Posting Integration</h5>
                                <p>Post jobs to multiple platforms</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Setup/job_posting_platforms') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h5>Platform Configuration</h5>
                                <p>Configure job board APIs</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Job_posting/analytics') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>Job Analytics</h5>
                                <p>Track posting performance</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Auto_distribution') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <h5>Auto Distribution</h5>
                                <p>Automated job posting</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral & Sourcing -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-users me-2"></i>Referral & Candidate Sourcing</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Referral') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <h5>Referral Program</h5>
                                <p>Employee referral management</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Referral/analytics') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h5>Referral Analytics</h5>
                                <p>Track referral performance</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Candidate_sourcing') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h5>Candidate Sourcing</h5>
                                <p>AI-powered candidate search</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Candidate_sourcing/pools') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ff9a9e, #fecfef);">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h5>Talent Pool</h5>
                                <p>Candidate database management</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employer Branding -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-award me-2"></i>Employer Branding</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Employer_profile') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h5>Company Profile</h5>
                                <p>Manage employer brand</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Reviews_management') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h5>Reviews Management</h5>
                                <p>Monitor employer reviews</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Media_gallery') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="fas fa-images"></i>
                                </div>
                                <h5>Media Gallery</h5>
                                <p>Company photos & videos</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Awards_recognition') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <h5>Awards & Recognition</h5>
                                <p>Showcase achievements</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketing Campaigns -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-rocket me-2"></i>Recruitment Marketing</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Marketing_campaigns') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <h5>Marketing Campaigns</h5>
                                <p>Create recruitment campaigns</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Marketing_campaigns/email_campaigns') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5>Email Campaigns</h5>
                                <p>Email templates & campaigns</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Marketing_campaigns/social_media') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <h5>Social Media</h5>
                                <p>Social recruitment posts</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Paid_advertising') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ff9a9e, #fecfef);">
                                    <i class="fas fa-ad"></i>
                                </div>
                                <h5>Paid Advertising</h5>
                                <p>Manage sponsored job ads</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRM & Automation -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-magic me-2"></i>CRM & Automation</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Candidate_crm') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h5>Candidate CRM</h5>
                                <p>Relationship management</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Marketing_automation') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <h5>Marketing Automation</h5>
                                <p>Automated drip campaigns</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Integration_hub') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="fas fa-plug"></i>
                                </div>
                                <h5>Integration Hub</h5>
                                <p>Connect marketing tools</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Chatbot') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h5>Chatbot</h5>
                                <p>AI candidate engagement</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events & Advocacy -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-calendar-check me-2"></i>Events & Employee Advocacy</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Recruitment_events') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h5>Recruitment Events</h5>
                                <p>Manage job fairs & events</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Recruitment_events?type=Virtual') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                                    <i class="fas fa-video"></i>
                                </div>
                                <h5>Virtual Events</h5>
                                <p>Online recruitment events</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Employee_advocacy') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h5>Employee Advocacy</h5>
                                <p>Employee brand ambassadors</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Employee_advocacy/content') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #ff9a9e, #fecfef);">
                                    <i class="fas fa-share-square"></i>
                                </div>
                                <h5>Social Sharing</h5>
                                <p>Employee social sharing</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics & Reporting -->
        <div class="setup-category">
            <div class="category-header">
                <h4><i class="fas fa-chart-pie me-2"></i>Analytics & Reporting</h4>
            </div>
            <div class="category-cards">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Marketing_campaigns/analytics') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>Campaign Analytics</h5>
                                <p>Marketing performance metrics</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Roi_tracking') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="fas fa-funnel-dollar"></i>
                                </div>
                                <h5>ROI Tracking</h5>
                                <p>Marketing ROI analysis</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Custom_reports') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5>Custom Reports</h5>
                                <p>Build custom reports</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= base_url('Export_data') ?>" class="setup-card">
                            <div class="setup-card-inner">
                                <div class="setup-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                    <i class="fas fa-download"></i>
                                </div>
                                <h5>Export Data</h5>
                                <p>Export analytics data</p>
                                <span class="badge-status badge-active">Active</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.page-header {
    padding-bottom: 20px;
    border-bottom: 2px solid #e0e0e0;
}

.setup-category {
    margin-bottom: 40px;
}

.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 25px;
    border-radius: 12px 12px 0 0;
    margin-bottom: 0;
}

.category-header h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.category-cards {
    background: white;
    padding: 25px;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.setup-card {
    display: block;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    height: 100%;
}

.setup-card:hover {
    transform: translateY(-5px);
    text-decoration: none;
}

.setup-card-inner {
    background: white;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.setup-card:hover .setup-card-inner {
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.setup-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 28px;
}

.setup-card-inner h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2d3748;
}

.setup-card-inner p {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 15px;
}

.badge-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-active {
    background: #d4edda;
    color: #155724;
}

.badge-coming {
    background: #fff3cd;
    color: #856404;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-new {
    background: linear-gradient(90deg, #f093fb, #f5576c);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>

<?php $this->load->view('templates/admin_footer'); ?>
