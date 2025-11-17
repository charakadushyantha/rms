<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo TAB_LOGO; ?>">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Recruiter Dashboard - RMS</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Animate.css for SweetAlert2 animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
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
            --primary-color: #f97316;
            --primary-dark: #ea580c;
            --secondary-color: #fb923c;
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

        .sidebar-brand h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-brand p {
            font-size: 12px;
            opacity: 0.8;
            margin: 5px 0 0 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left: 4px solid white;
        }

        .sidebar-menu a i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
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
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Topbar */
        .topbar {
            background: white;
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark-color);
            cursor: pointer;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 10px 40px 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            width: 300px;
            font-size: 14px;
        }

        .search-box button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 25px;
            transition: background 0.3s;
        }

        .user-menu:hover {
            background: var(--light-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            color: #6b7280;
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

        /* Utility Classes */
        .btn-modern {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .search-box input {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2><i class="fas fa-user-tie"></i> RMS</h2>
            <p>Recruiter Panel</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo base_url('R_dashboard'); ?>" class="<?= ($this->uri->segment(1) == 'R_dashboard' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('R_dashboard/Rcandidate_view'); ?>" class="<?= $this->uri->segment(2) == 'Rcandidate_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-plus"></i>
                    <span>Add Candidate</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('R_dashboard/Rstatus_view'); ?>" class="<?= $this->uri->segment(2) == 'Rstatus_view' ? 'active' : '' ?>">
                    <i class="fas fa-list"></i>
                    <span>Pipeline</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('R_dashboard/Rcalendar_view'); ?>" class="<?= $this->uri->segment(2) == 'Rcalendar_view' ? 'active' : '' ?>">
                    <i class="fas fa-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('R_dashboard/Rscandidate_view'); ?>" class="<?= $this->uri->segment(2) == 'Rscandidate_view' ? 'active' : '' ?>">
                    <i class="fas fa-check-circle"></i>
                    <span>Selected Candidates</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('interview'); ?>" class="<?= $this->uri->segment(1) == 'interview' ? 'active' : '' ?>">
                    <i class="fas fa-video"></i>
                    <span style="background: linear-gradient(90deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Interviews</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('questions_bank'); ?>" class="<?= $this->uri->segment(1) == 'questions_bank' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i>
                    <span style="background: linear-gradient(90deg, #fb923c, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Questions Bank</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('realtime_dashboard'); ?>" class="<?= $this->uri->segment(1) == 'realtime_dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i>
                    <span style="background: linear-gradient(90deg, #4ade80, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Real-Time Dashboard</span>
                </a>
            </li>
            
            <div class="sidebar-divider"></div>
            
            <li>
                <a href="<?php echo base_url('R_dashboard/Raccount_details_view'); ?>" class="<?= $this->uri->segment(2) == 'Raccount_details_view' ? 'active' : '' ?>">
                    <i class="fas fa-user-circle"></i>
                    <span>My Account</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('Login/logout'); ?>">
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
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="user-menu">
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
                            <?php echo strtoupper(substr($display_name, 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    <span><?php echo htmlspecialchars($display_name); ?></span>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
