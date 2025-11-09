<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Interviewer Portal'; ?> - RMS</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- FullCalendar (if needed) -->
    <?php if (isset($use_calendar) && $use_calendar): ?>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <?php endif; ?>
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 260px;
            background: linear-gradient(180deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 2rem;
        }

        .sidebar-brand h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-brand p {
            font-size: 0.875rem;
            opacity: 0.8;
            margin: 0.25rem 0 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
        }

        .sidebar-menu i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            position: relative;
            background: #f3f4f6;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .notification-btn:hover {
            background: #e5e7eb;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f3f4f6;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-menu:hover {
            background: #e5e7eb;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown.show {
            display: block;
        }

        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
        }

        .user-dropdown a:hover {
            background: #f3f4f6;
        }

        .user-dropdown a:first-child {
            border-radius: 10px 10px 0 0;
        }

        .user-dropdown a:last-child {
            border-radius: 0 0 10px 10px;
            color: #ef4444;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><i class="fas fa-user-tie me-2"></i>Interviewer</h2>
            <p>Interview Management Portal</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo base_url('I_dashboard'); ?>" class="<?php echo $this->uri->segment(2) == '' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('I_dashboard/schedule'); ?>" class="<?php echo $this->uri->segment(2) == 'schedule' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Schedule</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('I_dashboard/feedback_history'); ?>" class="<?php echo $this->uri->segment(2) == 'feedback_history' ? 'active' : ''; ?>">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Feedback History</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('I_dashboard/profile'); ?>" class="<?php echo $this->uri->segment(2) == 'profile' ? 'active' : ''; ?>">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile & Availability</span>
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
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="topbar-title"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h1>
            
            <div class="topbar-actions">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <div class="user-menu" onclick="toggleUserDropdown()">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($uname, 0, 1)); ?>
                    </div>
                    <span><?php echo htmlspecialchars($uname); ?></span>
                    <i class="fas fa-chevron-down"></i>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="<?php echo base_url('I_dashboard/profile'); ?>">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="<?php echo base_url('I_dashboard/feedback_history'); ?>">
                            <i class="fas fa-clipboard-list"></i>
                            <span>My Feedback</span>
                        </a>
                        <a href="<?php echo base_url('Login/logout'); ?>">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
