<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Recruitment Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <?php if(isset($page_specific_css)): ?>
        <?php foreach($page_specific_css as $css): ?>
            <link rel="stylesheet" href="<?= base_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Custom Global CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/modern/css/style.css') ?>">
    
    <!-- Theme CSS (Light/Dark mode support) -->
    <link rel="stylesheet" href="<?= base_url('assets/modern/css/themes/light.css') ?>" id="theme-stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            color: white;
            position: fixed;
            z-index: 999;
            transition: all 0.3s;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        #sidebar-wrapper.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }
        
        .sidebar-heading {
            padding: 1.2rem 1rem;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem;
        }
        
        .sidebar-nav .nav-item {
            position: relative;
        }
        
        .sidebar-nav .nav-link {
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .sidebar-nav .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-nav .nav-link.active {
            color: white;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-nav .nav-link i {
            margin-right: 0.5rem;
            width: 1.5rem;
            text-align: center;
        }
        
        /* Content Wrapper */
        #content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        #content-wrapper.expanded {
            margin-left: 0;
            width: 100%;
        }
        
        /* Topbar */
        .topbar {
            height: 70px;
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .topbar .dropdown-menu {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }
        
        .topbar .navbar-search {
            width: 30rem;
        }
        
        .topbar .navbar-search input {
            font-size: 0.85rem;
            height: auto;
        }
        
        .topbar .topbar-divider {
            width: 0;
            border-right: 1px solid #e3e6f0;
            height: calc(4.375rem - 2rem);
            margin: auto 1rem;
        }
        
        .topbar .nav-item .nav-link {
            height: 4.375rem;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
        }
        
        .topbar .nav-item .nav-link .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            margin-top: -0.25rem;
        }
        
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        /* Card Styles */
        .card-dashboard {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.2s;
        }
        
        .card-dashboard:hover {
            transform: translateY(-4px);
        }
        
        .card-dashboard .card-body {
            padding: 1.25rem;
        }
        
        .card-dashboard .card-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            text-transform: uppercase;
        }
        
        .card-dashboard .card-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        /* Card Border Colors */
        .card-primary {
            border-left: 4px solid var(--primary-color);
        }
        
        .card-success {
            border-left: 4px solid var(--success-color);
        }
        
        .card-info {
            border-left: 4px solid var(--info-color);
        }
        
        .card-warning {
            border-left: 4px solid var(--warning-color);
        }
        
        .card-danger {
            border-left: 4px solid var(--danger-color);
        }
        
        /* Form Styles */
        .form-control:focus {
            border-color: #d1d3e2;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #sidebar-wrapper.mobile-show {
                margin-left: 0;
            }
            
            #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .topbar .navbar-search {
                width: 100%;
            }
        }
        
        /* Dark mode */
        .dark-mode {
            background-color: #1e1e2d;
            color: #e6e6e6;
        }
        
        .dark-mode .card,
        .dark-mode .topbar {
            background-color: #2b2b40;
            color: #e6e6e6;
        }
        
        .dark-mode .card-title,
        .dark-mode .card-value {
            color: #e6e6e6;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-primary" id="sidebar-wrapper">
            <div class="sidebar-heading text-center">
                <img src="<?= base_url('Assets/login_page/Image/CompanyLogo.png') ?>" alt="Logo" height="40" class="me-2">
                <span>RMS</span>
            </div>
            <div class="sidebar-divider my-0"></div>
            
            <!-- Nav Items -->
            <ul class="nav flex-column sidebar-nav">
                <?php if($this->session->userdata('Role') === 'Admin'): ?>
                <!-- Admin Menu Items -->
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'A_dashboard' && $this->uri->segment(2) == '' ? 'active' : '' ?>" href="<?= base_url('A_dashboard') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Arecruiter_view' ? 'active' : '' ?>" href="<?= base_url('A_dashboard/Arecruiter_view') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        Recruiters
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Ascandidate_view' ? 'active' : '' ?>" href="<?= base_url('A_dashboard/Ascandidate_view') ?>">
                        <i class="fas fa-fw fa-user-tie"></i>
                        Candidates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Acalendar_view' ? 'active' : '' ?>" href="<?= base_url('A_dashboard/Acalendar_view') ?>">
                        <i class="fas fa-fw fa-calendar"></i>
                        Calendar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'realtime_dashboard' ? 'active' : '' ?>" href="<?= base_url('realtime_dashboard') ?>">
                        <i class="fas fa-fw fa-chart-line"></i>
                        <span style="background: linear-gradient(90deg, #4ade80, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Real-Time Dashboard</span>
                    </a>
                </li>
                <?php else: ?>
                <!-- Recruiter Menu Items -->
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'R_dashboard' && $this->uri->segment(2) == '' ? 'active' : '' ?>" href="<?= base_url('R_dashboard') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Rcandidate_view' ? 'active' : '' ?>" href="<?= base_url('R_dashboard/Rcandidate_view') ?>">
                        <i class="fas fa-fw fa-user-tie"></i>
                        Add Candidate
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'kanban_view' ? 'active' : '' ?>" href="<?= base_url('R_dashboard/kanban_view') ?>">
                        <i class="fas fa-fw fa-columns"></i>
                        Pipeline
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Rcalendar_view' ? 'active' : '' ?>" href="<?= base_url('R_dashboard/Rcalendar_view') ?>">
                        <i class="fas fa-fw fa-calendar"></i>
                        Calendar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Rstatus_view' ? 'active' : '' ?>" href="<?= base_url('R_dashboard/Rstatus_view') ?>">
                        <i class="fas fa-fw fa-chart-line"></i>
                        Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Rscandidate_view' ? 'active' : '' ?>" href="<?= base_url('R_dashboard/Rscandidate_view') ?>">
                        <i class="fas fa-fw fa-check-circle"></i>
                        Selected Candidates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'realtime_dashboard' ? 'active' : '' ?>" href="<?= base_url('realtime_dashboard') ?>">
                        <i class="fas fa-fw fa-chart-line"></i>
                        <span style="background: linear-gradient(90deg, #4ade80, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 700;">Real-Time Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>
                
                <div class="sidebar-divider"></div>
                
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'Raccount_details_view' || $this->uri->segment(2) == 'Aaccount_details_view' ? 'active' : '' ?>" href="<?= base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard/Aaccount_details_view' : 'R_dashboard/Raccount_details_view') ?>">
                        <i class="fas fa-fw fa-user-circle"></i>
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Login/logout') ?>">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <h1 class="h3 mb-0 text-gray-800 d-none d-md-inline-block"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
                    
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline me-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge bg-danger badge-counter rounded-pill position-absolute top-0 end-0">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header bg-primary text-white">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="me-3">
                                        <div class="icon-circle bg-primary text-white">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">March 28, 2025</div>
                                        <span>New candidate application received!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="me-3">
                                        <div class="icon-circle bg-success text-white">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">March 27, 2025</div>
                                        <span>Interview scheduled for tomorrow</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="me-3">
                                        <div class="icon-circle bg-warning text-white">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">March 26, 2025</div>
                                        <span>Reminder: Submit interview feedback</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('username') ?></span>
                                <img class="img-profile rounded-circle" width="32" height="32" src="<?= base_url('Assets/Admin_Dashboard/img/profile/' . ($this->session->userdata('gender') === 'Female' ? 'femaleprofile.png' : 'maleprofile.png')) ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard/Aaccount_details_view' : 'R_dashboard/Raccount_details_view') ?>">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('Login/logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Recruitment System <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php if(isset($page_specific_js)): ?>
        <?php foreach($page_specific_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/modern/js/main.js') ?>"></script>
    
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('collapsed');
            document.getElementById('content-wrapper').classList.toggle('expanded');
        });
        
        // Add scrolling animation to links with #
        document.querySelectorAll('a.scroll-to-top, a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Only apply to internal links that start with #
                if (href.startsWith('#') && href.length > 1) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 70,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
        
        // Scroll to top button
        window.addEventListener('scroll', function() {
            const scrollToTopButton = document.querySelector('.scroll-to-top');
            if (window.pageYOffset > 100) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        });
        
        // Theme toggle function
        function toggleTheme() {
            const body = document.body;
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/light.css') ?>';
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/dark.css') ?>';
            }
        }
        
        // Check for saved theme preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('theme-stylesheet').href = '<?= base_url('assets/modern/css/themes/dark.css') ?>';
            }
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });
    </script>
    
    <?php if(isset($custom_script)): ?>
    <script>
        <?= $custom_script ?>
    </script>
    <?php endif; ?>
</body>
</html>                    