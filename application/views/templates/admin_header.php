<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo TAB_LOGO; ?>">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Admin Dashboard - RMS</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- DataTables CSS (if needed) -->
    <?php if(isset($use_datatable) && $use_datatable): ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <?php endif; ?>
    
    <!-- FullCalendar CSS (if needed) -->
    <?php if(isset($use_calendar) && $use_calendar): ?>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <?php endif; ?>
    
    <!-- Chart.js (if needed) -->
    <?php if(isset($use_charts) && $use_charts): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
    
    <!-- Custom Page CSS -->
    <?php if(isset($page_specific_css)): ?>
        <?php foreach($page_specific_css as $css): ?>
            <link rel="stylesheet" href="<?= base_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5568d3;
            --secondary-color: #764ba2;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .sidebar-brand h4 {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 25px;
        }

        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left: 4px solid white;
            font-weight: 600;
        }

        .sidebar-menu a i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
            text-align: center;
        }

        .sidebar-heading {
            padding: 20px 20px 10px 20px;
            margin-top: 10px;
        }

        .sidebar-heading span {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 15px 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--dark-color);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar-toggle:hover {
            background: var(--light-color);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-search {
            position: relative;
            display: none;
        }

        .topbar-search input {
            width: 300px;
            padding: 8px 15px 8px 40px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 14px;
        }

        .topbar-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .topbar-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--light-color);
            color: var(--dark-color);
            cursor: pointer;
            transition: all 0.3s;
        }

        .topbar-icon:hover {
            background: #e0e0e0;
        }

        .topbar-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Enhanced Search Styles */
        .topbar-search input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .search-results {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            max-height: 500px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
        }

        .search-results.show {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        .search-category {
            padding: 12px 16px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
        }

        .search-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .search-item:hover {
            background: #f8f9fa;
            padding-left: 20px;
        }

        .search-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .search-item-content {
            flex: 1;
        }

        .search-item-title {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .search-item-subtitle {
            font-size: 12px;
            color: #718096;
        }

        .search-no-results {
            padding: 40px 20px;
            text-align: center;
            color: #a0aec0;
        }

        .search-no-results i {
            font-size: 48px;
            opacity: 0.3;
            margin-bottom: 12px;
        }

        /* Notification Dropdown Styles */
        .notification-icon {
            position: relative;
        }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            width: 380px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: none;
            z-index: 1000;
        }

        .notification-dropdown.show {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        .notification-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h6 {
            margin: 0;
            font-weight: 600;
            color: #2d3748;
        }

        .btn-mark-read {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 12px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .btn-mark-read:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            gap: 12px;
        }

        .notification-item:hover {
            background: #f8f9fa;
        }

        .notification-item.unread {
            background: rgba(102, 126, 234, 0.05);
        }

        .notification-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 13px;
            color: #718096;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .notification-time {
            font-size: 11px;
            color: #a0aec0;
        }

        .notification-footer {
            padding: 12px 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
        }

        .notification-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .notification-footer a:hover {
            text-decoration: underline;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .user-info:hover {
            background: var(--light-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .user-role {
            font-size: 12px;
            color: #999;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            padding: 30px;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border-left: 4px solid var(--primary-color);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card.info {
            border-left-color: var(--info-color);
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .stat-card.danger {
            border-left-color: var(--danger-color);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            opacity: 0.2;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .stat-card-footer {
            font-size: 13px;
            color: #999;
        }

        /* Data Table Card */
        .data-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-top: 30px;
        }

        .data-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .data-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Buttons */
        .btn-modern {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Footer */
        .footer {
            background: white;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 14px;
        }

        /* Modern Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.mobile-show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 0 15px;
            }

            .page-title {
                font-size: 18px;
            }

            .user-details {
                display: none;
            }

            .content-area {
                padding: 15px;
            }

            .topbar-search {
                display: none;
            }
        }

        @media (min-width: 992px) {
            .topbar-search {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo">
            <h4>Admin Panel</h4>
        </div>
        
        <ul class="sidebar-menu">
            <?php
            // Load module visibility settings
            $module_visibility = array();
            try {
                if ($this->db->table_exists('module_visibility')) {
                    $visibility_data = $this->db->get('module_visibility')->result_array();
                    foreach ($visibility_data as $item) {
                        $module_visibility[$item['module_key']] = $item['is_visible'];
                    }
                }
            } catch (Exception $e) {
                // Default to showing all if table doesn't exist
            }
            
            // Helper function to check visibility
            function is_module_visible($key, $visibility_array) {
                return !isset($visibility_array[$key]) || $visibility_array[$key] == 1;
            }
            ?>
            
            <!-- Main Dashboard -->
            <?php if (is_module_visible('dashboard', $module_visibility)): ?>
            <li>
                <a href="<?php echo A_DASHBOARD_URL; ?>" class="<?= ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php 
            // Check if any recruitment modules are visible
            $show_recruitment = is_module_visible('candidates', $module_visibility) || 
                               is_module_visible('calendar', $module_visibility) || 
                               is_module_visible('analytics', $module_visibility);
            if ($show_recruitment): 
            ?>
            <div class="sidebar-divider"></div>
            
            <!-- Core Recruitment -->
            <li class="sidebar-heading">
                <span>CORE RECRUITMENT</span>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('candidates', $module_visibility)): ?>
            <li>
                <a href="<?php echo A_SCANDIDATE_URL; ?>" class="<?= $this->uri->segment(2) == 'Ascandidate_view' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Candidates</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('calendar', $module_visibility)): ?>
            <li>
                <a href="<?php echo A_CALENDAR_URL; ?>" class="<?= $this->uri->segment(2) == 'Acalendar_view' ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <?php endif; ?>
            
            <!-- Interview Management -->
            <li>
                <a href="<?php echo base_url('interview'); ?>" class="<?= $this->uri->segment(1) == 'interview' && $this->uri->segment(2) != 'management' ? 'active' : '' ?>">
                    <i class="fas fa-video"></i>
                    <span>Interviews</span>
                </a>
            </li>
            
            <!-- IMS - Interview Management System -->
            <li>
                <a href="<?php echo base_url('interview/management'); ?>" class="<?= ($this->uri->segment(1) == 'interview' && $this->uri->segment(2) == 'management') ? 'active' : '' ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Interview Management</span>
                    <span class="badge" style="background: #38b2ac; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; margin-left: auto;">IMS</span>
                </a>
            </li>
            
            <!-- Questions Bank -->
            <li>
                <a href="<?php echo base_url('questions_bank'); ?>" class="<?= $this->uri->segment(1) == 'questions_bank' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i>
                    <span>Questions Bank</span>
                </a>
            </li>
            
            <?php if (is_module_visible('analytics', $module_visibility)): ?>
            <li>
                <a href="<?php echo base_url('realtime_dashboard'); ?>" class="<?= $this->uri->segment(1) == 'realtime_dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics & Reports</span>
                </a>
            </li>
            <?php endif; ?>
            
            <div class="sidebar-divider"></div>
            
            <!-- Job Management -->
            <li class="sidebar-heading">
                <span>JOB MANAGEMENT</span>
            </li>
            <li>
                <a href="<?php echo base_url('Job_posting'); ?>" class="<?= $this->uri->segment(1) == 'Job_posting' && $this->uri->segment(2) != 'analytics' ? 'active' : '' ?>">
                    <i class="fas fa-briefcase"></i>
                    <span>Job Postings</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Job_posting/analytics'); ?>" class="<?= ($this->uri->segment(1) == 'Job_posting' && $this->uri->segment(2) == 'analytics') ? 'active' : '' ?>">
                    <i class="fas fa-chart-pie"></i>
                    <span>Job Analytics</span>
                </a>
            </li>
            
            <div class="sidebar-divider"></div>
            
            <!-- Recruitment Marketing -->
            <li class="sidebar-heading">
                <span>RECRUITMENT MARKETING</span>
            </li>
            <li>
                <a href="<?php echo base_url('Sales_marketing'); ?>" class="<?= $this->uri->segment(1) == 'Sales_marketing' ? 'active' : '' ?>">
                    <i class="fas fa-bullhorn"></i>
                    <span>Marketing Campaigns</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Marketing_campaigns'); ?>" class="<?= $this->uri->segment(1) == 'Marketing_campaigns' ? 'active' : '' ?>">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Email Campaigns</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Candidate_sourcing'); ?>" class="<?= $this->uri->segment(1) == 'Candidate_sourcing' && $this->uri->segment(2) != 'pools' ? 'active' : '' ?>">
                    <i class="fas fa-search"></i>
                    <span>Candidate Sourcing</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Candidate_sourcing/pools'); ?>" class="<?= ($this->uri->segment(1) == 'Candidate_sourcing' && $this->uri->segment(2) == 'pools') ? 'active' : '' ?>">
                    <i class="fas fa-layer-group"></i>
                    <span>Talent Pools</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Referral'); ?>" class="<?= $this->uri->segment(1) == 'Referral' ? 'active' : '' ?>">
                    <i class="fas fa-user-friends"></i>
                    <span>Referral Program</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Recruitment_events'); ?>" class="<?= $this->uri->segment(1) == 'Recruitment_events' ? 'active' : '' ?>">
                    <i class="fas fa-calendar-star"></i>
                    <span>Recruitment Events</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Employee_advocacy'); ?>" class="<?= $this->uri->segment(1) == 'Employee_advocacy' ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i>
                    <span>Employee Advocacy</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Employer_profile'); ?>" class="<?= $this->uri->segment(1) == 'Employer_profile' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    <span>Employer Branding</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Paid_advertising'); ?>" class="<?= $this->uri->segment(1) == 'Paid_advertising' ? 'active' : '' ?>">
                    <i class="fas fa-ad"></i>
                    <span>Paid Advertising</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Roi_tracking'); ?>" class="<?= $this->uri->segment(1) == 'Roi_tracking' ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>ROI Tracking</span>
                </a>
            </li>
            
            <div class="sidebar-divider"></div>
            
            <!-- CRM & Engagement -->
            <li class="sidebar-heading">
                <span>CRM & ENGAGEMENT</span>
            </li>
            <li>
                <a href="<?php echo base_url('Candidate_crm'); ?>" class="<?= $this->uri->segment(1) == 'Candidate_crm' ? 'active' : '' ?>">
                    <i class="fas fa-handshake"></i>
                    <span>Candidate CRM</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Media_gallery'); ?>" class="<?= $this->uri->segment(1) == 'Media_gallery' ? 'active' : '' ?>">
                    <i class="fas fa-images"></i>
                    <span>Media Gallery</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Reviews_management'); ?>" class="<?= $this->uri->segment(1) == 'Reviews_management' ? 'active' : '' ?>">
                    <i class="fas fa-star"></i>
                    <span>Reviews Management</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Awards_recognition'); ?>" class="<?= $this->uri->segment(1) == 'Awards_recognition' ? 'active' : '' ?>">
                    <i class="fas fa-trophy"></i>
                    <span>Awards & Recognition</span>
                </a>
            </li>
            
            <div class="sidebar-divider"></div>
            
            <!-- Integrations -->
            <li class="sidebar-heading">
                <span>INTEGRATIONS</span>
            </li>
            <li>
                <a href="<?php echo base_url('Integration_hub'); ?>" class="<?= $this->uri->segment(1) == 'Integration_hub' ? 'active' : '' ?>">
                    <i class="fas fa-plug"></i>
                    <span>Integration Hub</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Video_integrations'); ?>" class="<?= $this->uri->segment(1) == 'Video_integrations' ? 'active' : '' ?>">
                    <i class="fas fa-video"></i>
                    <span>Video Platforms</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Assessment_integrations'); ?>" class="<?= $this->uri->segment(1) == 'Assessment_integrations' ? 'active' : '' ?>">
                    <i class="fas fa-code"></i>
                    <span>Assessment Tools</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Background_check'); ?>" class="<?= $this->uri->segment(1) == 'Background_check' ? 'active' : '' ?>">
                    <i class="fas fa-shield-alt"></i>
                    <span>Background Checks</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Ats_integrations'); ?>" class="<?= $this->uri->segment(1) == 'Ats_integrations' ? 'active' : '' ?>">
                    <i class="fas fa-sync-alt"></i>
                    <span>ATS Integrations</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Setup/job_posting_platforms'); ?>" class="<?= ($this->uri->segment(1) == 'Setup' && $this->uri->segment(2) == 'job_posting_platforms') ? 'active' : '' ?>">
                    <i class="fas fa-share-alt"></i>
                    <span>Job Board Platforms</span>
                </a>
            </li>
            
            <?php 
            // Check if any user management modules are visible
            $show_user_mgmt = is_module_visible('recruiters', $module_visibility) || 
                             is_module_visible('interviewers', $module_visibility) || 
                             is_module_visible('candidate_users', $module_visibility);
            if ($show_user_mgmt): 
            ?>
            <div class="sidebar-divider"></div>
            
            <!-- User Management -->
            <li class="sidebar-heading">
                <span>USER MANAGEMENT</span>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('recruiters', $module_visibility)): ?>
            <li>
                <a href="<?php echo A_RECRUITER_URL; ?>" class="<?= $this->uri->segment(2) == 'Arecruiter_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-tie"></i>
                    <span>Recruiters</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('interviewers', $module_visibility)): ?>
            <li>
                <a href="<?php echo base_url('A_dashboard/Ainterviewer_view'); ?>" class="<?= $this->uri->segment(2) == 'Ainterviewer_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-check"></i>
                    <span>Interviewers</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('candidate_users', $module_visibility)): ?>
            <li>
                <a href="<?php echo base_url('A_dashboard/Acandidate_users_view'); ?>" class="<?= $this->uri->segment(2) == 'Acandidate_users_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-graduate"></i>
                    <span>Candidate Users</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('reports', $module_visibility)): ?>
            <div class="sidebar-divider"></div>
            
            <!-- Reports & Analytics -->
            <li class="sidebar-heading">
                <span>REPORTS & ANALYTICS</span>
            </li>
            <li>
                <a href="<?php echo base_url('A_dashboard/reports_view'); ?>" class="<?= $this->uri->segment(2) == 'reports_view' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i>
                    <span>MIS Reports</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Custom_reports'); ?>" class="<?= $this->uri->segment(1) == 'Custom_reports' ? 'active' : '' ?>">
                    <i class="fas fa-file-chart-line"></i>
                    <span>Custom Reports</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Export_data'); ?>" class="<?= $this->uri->segment(1) == 'Export_data' ? 'active' : '' ?>">
                    <i class="fas fa-file-export"></i>
                    <span>Export Data</span>
                </a>
            </li>
            <?php endif; ?>
            
            <div class="sidebar-divider"></div>
            
            <!-- Automation -->
            <li class="sidebar-heading">
                <span>AUTOMATION</span>
            </li>
            <li>
                <a href="<?php echo base_url('Marketing_automation'); ?>" class="<?= $this->uri->segment(1) == 'Marketing_automation' ? 'active' : '' ?>">
                    <i class="fas fa-robot"></i>
                    <span>Marketing Automation</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Auto_distribution'); ?>" class="<?= $this->uri->segment(1) == 'Auto_distribution' ? 'active' : '' ?>">
                    <i class="fas fa-random"></i>
                    <span>Auto Distribution</span>
                </a>
            </li>
            
            <?php
            // Load custom modules from database (with error handling)
            $has_custom_modules = false;
            try {
                if ($this->db->table_exists('custom_modules')) {
                    $this->db->where('is_active', 1);
                    $this->db->order_by('order_num', 'ASC');
                    $custom_modules = $this->db->get('custom_modules')->result_array();
                    
                    if (!empty($custom_modules)) {
                        $has_custom_modules = true;
                        
                        // Group modules by section
                        $grouped_modules = array();
                        foreach ($custom_modules as $module) {
                            $grouped_modules[$module['section']][] = $module;
                        }
                        
                        // Display grouped modules
                        foreach ($grouped_modules as $section => $modules):
                        ?>
                        <div class="sidebar-divider"></div>
                        
                        <!-- Custom Section: <?= $section ?> -->
                        <li class="sidebar-heading">
                            <span><?= strtoupper($section) ?></span>
                        </li>
                        <?php foreach ($modules as $module): ?>
                        <li>
                            <a href="<?= base_url($module['url']) ?>" class="<?= $this->uri->segment(2) == basename($module['url']) ? 'active' : '' ?>">
                                <i class="<?= $module['icon'] ?>"></i>
                                <span><?= $module['name'] ?></span>
                                <?php if ($module['show_badge']): ?>
                                <span class="badge" style="background: #10b981; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; margin-left: auto;"><?= $module['badge_text'] ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php 
                        endforeach;
                    }
                }
            } catch (Exception $e) {
                // Silently fail if table doesn't exist - no custom modules will be shown
            }
            ?>
            
            <div class="sidebar-divider"></div>
            
            <!-- System & Settings -->
            <li class="sidebar-heading">
                <span>SYSTEM & SETTINGS</span>
            </li>
            
            <?php if (is_module_visible('roles', $module_visibility)): ?>
            <li>
                <a href="<?php echo base_url('A_dashboard/roles_permissions_view'); ?>" class="<?= $this->uri->segment(2) == 'roles_permissions_view' ? 'active' : '' ?>">
                    <i class="fas fa-shield-alt"></i>
                    <span>Roles & Permissions</span>
                </a>
            </li>
            <?php endif; ?>
            
            <!-- Signup Controller -->
            <li>
                <a href="<?php echo base_url('Signup_controller'); ?>" class="<?= $this->uri->segment(1) == 'Signup_controller' ? 'active' : '' ?>">
                    <i class="fas fa-user-cog"></i>
                    <span>Signup Controller</span>
                </a>
            </li>
            
            <!-- Chatbot -->
            <li>
                <a href="<?php echo base_url('Chatbot'); ?>" class="<?= $this->uri->segment(1) == 'Chatbot' ? 'active' : '' ?>">
                    <i class="fas fa-robot"></i>
                    <span>AI Chatbot</span>
                </a>
            </li>
            
            <?php if (is_module_visible('setup', $module_visibility)): ?>
            <li>
                <a href="<?php echo base_url('Setup'); ?>" class="<?= $this->uri->segment(1) == 'Setup' && $this->uri->segment(2) == '' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <span>System Setup</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Setup/module_manager'); ?>" class="<?= ($this->uri->segment(1) == 'Setup' && $this->uri->segment(2) == 'module_manager') ? 'active' : '' ?>">
                    <i class="fas fa-th-large"></i>
                    <span>Module Manager</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Setup/company_settings'); ?>" class="<?= ($this->uri->segment(1) == 'Setup' && $this->uri->segment(2) == 'company_settings') ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    <span>Company Settings</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Setup/email_configuration'); ?>" class="<?= ($this->uri->segment(1) == 'Setup' && $this->uri->segment(2) == 'email_configuration') ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    <span>Email Configuration</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (is_module_visible('account', $module_visibility)): ?>
            <li>
                <a href="<?php echo A_AC_DETAILS_URL; ?>" class="<?= $this->uri->segment(2) == 'Aaccount_details_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-circle"></i>
                    <span>My Account</span>
                </a>
            </li>
            <?php endif; ?>
            
            <div class="sidebar-divider"></div>
            
            <li>
                <a href="<?php echo A_LOGOUT_URL; ?>" style="color: #ff6b6b;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
            </div>
            
            <div class="topbar-right">
                <!-- Global Search -->
                <div class="topbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalSearch" placeholder="Search candidates, jobs, interviews..." autocomplete="off">
                    <div class="search-results" id="searchResults"></div>
                </div>
                
                <!-- Notifications -->
                <div class="topbar-icon notification-icon" id="notificationIcon">
                    <i class="fas fa-bell"></i>
                    <span class="badge" id="notificationCount">0</span>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <h6>Notifications</h6>
                            <button class="btn-mark-read" onclick="markAllAsRead()">Mark all as read</button>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-bell-slash fa-2x mb-2"></i>
                                <p>No new notifications</p>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="<?= base_url('A_dashboard/notifications') ?>">View all notifications</a>
                        </div>
                    </div>
                </div>
                
                <!-- Help -->
                <div class="topbar-icon" data-bs-toggle="modal" data-bs-target="#helpModal" title="Help & Documentation">
                    <i class="fas fa-question-circle"></i>
                </div>
                
                <div class="user-dropdown dropdown">
                    <div class="user-info" data-bs-toggle="dropdown">
                        <?php 
                        // Get profile picture and display name from database
                        $username = $this->session->userdata('username');
                        $display_name = $this->session->userdata('full_name') ? $this->session->userdata('full_name') : $username;
                        $user_pic = $this->db->select('profile_picture')
                                             ->where('u_username', $username)
                                             ->get(TBL_USERS)
                                             ->row();
                        $profile_pic = ($user_pic && isset($user_pic->profile_picture)) ? $user_pic->profile_picture : '';
                        ?>
                        
                        <?php if($profile_pic && file_exists('./uploads/profiles/' . $profile_pic)): ?>
                            <img src="<?= base_url('uploads/profiles/' . $profile_pic) ?>" 
                                 alt="Profile" 
                                 class="user-avatar"
                                 style="object-fit: cover;">
                        <?php else: ?>
                            <div class="user-avatar">
                                <?= strtoupper(substr($display_name, 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <div class="user-details">
                            <div class="user-name"><?= htmlspecialchars($display_name) ?></div>
                            <div class="user-role">Administrator</div>
                        </div>
                        <i class="fas fa-chevron-down" style="color: #999; font-size: 12px;"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo A_AC_DETAILS_URL; ?>"><i class="fas fa-user me-2"></i> My Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo A_LOGOUT_URL; ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
        
        <?php $this->load->view('templates/help_modal'); ?>
