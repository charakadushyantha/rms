<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Reports</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo TAB_LOGO; ?>">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/bootstrap.min.css">
    <!-- Font awesome CDN -->
    <script src="https://kit.fontawesome.com/2f33c29c83.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/font-awesome.min.css">
    <!-- Other CSS files... -->
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/adminpro-custon-icon.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/animate.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/form.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/style.css">
    <link rel="stylesheet" href="<?php echo ADMIN_ASSETS_PATH; ?>/css/responsive.css">
    <!-- modernizr JS -->
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- Header top area start-->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <div class="compnay-logo">
                        <a href="https://charaka.cmsads24.com/"><img src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo" /></a>
                        <a href="https://charaka.cmsads24.com/"><img src="<?php echo COMPANY_NAME; ?>" alt="Company Name" /></a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                    <div class="header-right-info">
                        <ul class="nav navbar-nav mai-top-nav header-right-menu">
                            <li class="nav-item">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                    class="nav-link dropdown-toggle">
                                    <span class="adminpro-icon adminpro-user-rounded header-riht-inf"></span>
                                    <span class="admin-name"><?php echo $uname; ?></span>
                                    <span class="author-project-icon adminpro-icon adminpro-down-arrow"></span>
                                </a>
                                <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated flipInX">
                                    <li><a href="<?php echo A_AC_DETAILS_URL;?>"><span
                                                class="adminpro-icon adminpro-user-rounded author-log-ic"></span>My
                                            Profile</a>
                                    </li>
                                    <li><a href="<?php echo A_LOGOUT_URL;?>"><span class="adminpro-icon adminpro-locked author-log-ic"></span>Log
                                            Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header top area end-->
    
    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs custom-menu-wrap">
                        <li><a href="<?php echo A_DASHBOARD_URL; ?>"><i class="fa fa-home"></i>Home</a>
                        </li>
                        <li><a href="<?php echo A_CALENDAR_URL; ?>"><i class="fa fa-calendar"></i>Calendar</a>
                        </li>
                        <li><a href="<?php echo A_SCANDIDATE_URL; ?>"><i class="fas fa-user-check"></i>Candidate</a>
                        </li>
                        <li><a href="<?php echo A_RECRUITER_URL; ?>"><i class="fas fa-user-plus"></i>Add Recruiter</a>
                        </li>
                        <?php /* <li><a href="<?php echo A_REPORTS_URL; ?>"><i class="fa fa-chart-bar"></i>Reports</a> */ ?>

                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <!-- Menu content sections... -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Main Menu area End-->

    <!-- Mobile Menu -->
    <div class="mobile-menu-area">
        <!-- Mobile menu content... -->
    </div>
    <!-- Mobile Menu end -->

    <!-- Breadcome area -->
    <div class="breadcome-area mg-b-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                        <div class="breadcome-heading">
                            <h2>Reports</h2>
                        </div>
                        <ul class="breadcome-menu">
                            <li><span class="bread-slash">Admin</span> <span class="bread-slash">/</span>
                            </li>
                            <li><span class="bread-blod">Reports</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Content -->
    <div class="data-table-area mg-b-15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sparkline13-list shadow-reset">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Recruitment Analytics</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <!-- Report content here -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Candidates by Status</h4>
                                            </div>
                                            <div class="card-body">
                                                <!-- Chart or data here -->
                                                <div class="chart-placeholder" style="height: 300px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                                    <p>Bar Chart: Candidates by Status</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Interview Progress</h4>
                                            </div>
                                            <div class="card-body">
                                                <!-- Chart or data here -->
                                                <div class="chart-placeholder" style="height: 300px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                                    <p>Pie Chart: Interview Rounds</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Recruitment Summary</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Job Title</th>
                                                                <th>Total Candidates</th>
                                                                <th>Interviews Scheduled</th>
                                                                <th>Selected</th>
                                                                <th>Rejection Rate</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Sample data -->
                                                            <tr>
                                                                <td>Software Developer</td>
                                                                <td>15</td>
                                                                <td>8</td>
                                                                <td>3</td>
                                                                <td>80%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>UI/UX Designer</td>
                                                                <td>10</td>
                                                                <td>6</td>
                                                                <td>2</td>
                                                                <td>80%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Data Scientist</td>
                                                                <td>8</td>
                                                                <td>5</td>
                                                                <td>1</td>
                                                                <td>87.5%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
        </div>
    </div>

    <!-- Footer Start-->
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copy-right">
                        <p>Copyright &#169; RMS System UCSC MIT 2024 by Charaka. all rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->

    <!-- JavaScript files -->
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/vendor/jquery-1.11.3.min.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/jquery.meanmenu.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/jquery.sticky.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/jquery.scrollUp.min.js"></script>
    <script src="<?php echo ADMIN_ASSETS_PATH; ?>/js/main.js"></script>
</body>

</html>