<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Hiring Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('Assets/css/realtime-dashboard.css'); ?>">
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-chart-line"></i> Real-Time Hiring Dashboard</h1>
                <span class="live-indicator">
                    <span class="pulse"></span> LIVE
                </span>
            </div>
            <div class="header-right">
                <a href="<?php echo base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard' : 'R_dashboard'); ?>" class="btn-main-dashboard">
                    <i class="fas fa-home"></i>
                    <span>Main Dashboard</span>
                </a>
                <button id="refresh-btn" class="btn-icon" title="Refresh Dashboard" onclick="dashboard.manualRefresh()">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button id="settings-btn" class="btn-icon" title="Settings" onclick="dashboard.openSettings()">
                    <i class="fas fa-cog"></i>
                </button>
                <div class="user-info" onclick="dashboard.toggleUserMenu()" style="cursor: pointer; position: relative;">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo $this->session->userdata('username'); ?></span>
                    <i class="fas fa-chevron-down" style="font-size: 12px; margin-left: 5px;"></i>
                    
                    <!-- User Dropdown Menu -->
                    <div id="user-menu" class="user-dropdown" style="display: none;">
                        <a href="<?php echo base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard/Aaccount_details_view' : 'R_dashboard/Raccount_details_view'); ?>">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                        <a href="<?php echo base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard' : 'R_dashboard'); ?>">
                            <i class="fas fa-tachometer-alt"></i> Main Dashboard
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url('Login/logout'); ?>" style="color: #dc3545;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Metrics Bar -->
        <div class="metrics-bar">
            <div id="metrics-container" class="metrics-grid">
                <!-- Metrics will be loaded here -->
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-content">
            <!-- Pipeline View -->
            <div class="pipeline-section">
                <div class="section-header">
                    <h2><i class="fas fa-stream"></i> Hiring Pipeline</h2>
                    <div class="section-actions">
                        <button class="btn-secondary" id="pipeline-refresh-btn" onclick="if(typeof dashboard !== 'undefined') { dashboard.manualRefresh(); } else { location.reload(); }">
                            <i class="fas fa-redo"></i> Refresh
                        </button>
                    </div>
                </div>
                
                <div id="pipeline-container" class="pipeline-grid">
                    <!-- Pipeline stages will be loaded here -->
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i> Loading pipeline...
                    </div>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="activity-section">
                <div class="section-header">
                    <h3><i class="fas fa-history"></i> Recent Activity</h3>
                </div>
                <div id="activity-feed" class="activity-feed">
                    <!-- Activity will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div id="quick-view-modal" class="modal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3><i class="fas fa-user"></i> Candidate Quick View</h3>
                <button class="modal-close" onclick="document.getElementById('quick-view-modal').style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="quick-view-content">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settings-modal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3><i class="fas fa-cog"></i> Dashboard Settings</h3>
                <button class="modal-close" onclick="document.getElementById('settings-modal').style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="setting-group">
                    <label><i class="fas fa-clock"></i> Auto-Refresh Interval</label>
                    <select id="refresh-interval" class="form-control" onchange="dashboard.updateRefreshInterval(this.value)">
                        <option value="3000">3 seconds</option>
                        <option value="5000" selected>5 seconds</option>
                        <option value="10000">10 seconds</option>
                        <option value="30000">30 seconds</option>
                        <option value="60000">1 minute</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
                <div class="setting-group">
                    <label><i class="fas fa-bell"></i> Notifications</label>
                    <div class="toggle-switch">
                        <input type="checkbox" id="notifications-toggle" checked onchange="dashboard.toggleNotifications(this.checked)">
                        <label for="notifications-toggle">Enable notifications</label>
                    </div>
                </div>
                <div class="setting-group">
                    <label><i class="fas fa-volume-up"></i> Sound Alerts</label>
                    <div class="toggle-switch">
                        <input type="checkbox" id="sound-toggle" onchange="dashboard.toggleSound(this.checked)">
                        <label for="sound-toggle">Enable sound alerts</label>
                    </div>
                </div>
                <div class="setting-group">
                    <label><i class="fas fa-palette"></i> Theme</label>
                    <select id="theme-select" class="form-control" onchange="dashboard.changeTheme(this.value)">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="auto">Auto (System)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Voting Modal -->
    <div id="voting-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-vote-yea"></i> Vote on Candidate</h3>
                <button class="modal-close" onclick="document.getElementById('voting-modal').style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="vote-options">
                    <button class="vote-btn vote-yes" onclick="submitVote('yes')">
                        <i class="fas fa-thumbs-up"></i> Yes
                    </button>
                    <button class="vote-btn vote-no" onclick="submitVote('no')">
                        <i class="fas fa-thumbs-down"></i> No
                    </button>
                    <button class="vote-btn vote-abstain" onclick="submitVote('abstain')">
                        <i class="fas fa-minus"></i> Abstain
                    </button>
                </div>
                <div class="vote-comment">
                    <label>Comment (optional):</label>
                    <textarea id="vote-comment" rows="3" placeholder="Add your feedback..."></textarea>
                </div>
                <div class="vote-anonymous">
                    <label>
                        <input type="checkbox" id="vote-anonymous-check">
                        Submit anonymously
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration -->
    <script>
        const dashboardConfig = {
            baseUrl: '<?php echo base_url(); ?>',
            updateInterval: 5000,
            userId: <?php echo $user_id; ?>,
            userRole: '<?php echo $user_role; ?>'
        };
    </script>

    <!-- Load Dashboard Script -->
    <script src="<?php echo base_url('Assets/js/realtime-dashboard.js'); ?>"></script>
</body>
</html>
