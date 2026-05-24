<?php
$data['page_title'] = 'Real-Time Hiring Dashboard';
$this->load->view('templates/admin_header', $data);
?>

<style>
/* ── Real-Time Dashboard styles ── */
.rtd-live-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(34,197,94,.15); color: #16a34a;
    border: 1px solid rgba(34,197,94,.3);
    border-radius: 20px; padding: 3px 10px; font-size: 12px; font-weight: 700;
    vertical-align: middle; margin-left: 10px;
}
.rtd-live-badge .pulse {
    width: 8px; height: 8px; background: #22c55e; border-radius: 50%;
    animation: rtd-pulse 1.5s infinite;
}
@keyframes rtd-pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .5; transform: scale(1.4); }
}

/* Metrics */
.rtd-metrics { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-bottom: 28px; }
.rtd-metric-card {
    border-radius: 14px; padding: 22px 20px; color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
    position: relative; overflow: hidden;
}
.rtd-metric-card::after {
    content: ''; position: absolute; right: -20px; top: -20px;
    width: 100px; height: 100px; background: rgba(255,255,255,.1); border-radius: 50%;
}
.rtd-metric-card.c1 { background: linear-gradient(135deg,#667eea,#764ba2); }
.rtd-metric-card.c2 { background: linear-gradient(135deg,#f59e0b,#ef4444); }
.rtd-metric-card.c3 { background: linear-gradient(135deg,#ec4899,#8b5cf6); }
.rtd-metric-card.c4 { background: linear-gradient(135deg,#06b6d4,#3b82f6); }
.rtd-metric-value { font-size: 36px; font-weight: 800; line-height: 1; }
.rtd-metric-label { font-size: 13px; opacity: .85; margin-top: 6px; }

/* Pipeline */
.rtd-pipeline-header {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;
}
.rtd-pipeline-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}
.rtd-stage-col {
    background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); overflow: hidden;
}
.rtd-stage-header {
    padding: 10px 14px; display: flex; justify-content: space-between; align-items: center;
    font-size: 13px; font-weight: 700; color: #fff;
}
.rtd-stage-count {
    background: rgba(255,255,255,.25); border-radius: 20px;
    padding: 2px 8px; font-size: 12px; font-weight: 700;
}
.rtd-stage-body { padding: 10px; min-height: 80px; }
.rtd-candidate-card {
    background: #f8f9fa; border-radius: 8px; padding: 10px 12px;
    margin-bottom: 8px; border-left: 3px solid #667eea;
    font-size: 13px;
}
.rtd-candidate-card:last-child { margin-bottom: 0; }
.rtd-candidate-name { font-weight: 700; color: #1a1a1a; margin-bottom: 2px; }
.rtd-candidate-role { color: #888; font-size: 12px; margin-bottom: 6px; }
.rtd-candidate-meta { display: flex; align-items: center; gap: 8px; color: #aaa; font-size: 11px; margin-bottom: 8px; }
.rtd-candidate-actions { display: flex; gap: 5px; }
.rtd-candidate-actions button {
    width: 26px; height: 26px; border-radius: 6px; border: 1px solid #e0e0e0;
    background: #fff; color: #667eea; font-size: 12px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s;
}
.rtd-candidate-actions button:hover { background: #667eea; color: #fff; border-color: #667eea; }
.rtd-loading { text-align: center; padding: 30px; color: #aaa; font-size: 14px; }

/* Activity feed */
.rtd-layout { display: grid; grid-template-columns: 1fr 280px; gap: 24px; }
.rtd-activity-widget {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden;
    position: sticky; top: 20px; max-height: 600px; display: flex; flex-direction: column;
}
.rtd-activity-header {
    padding: 14px 18px;
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff; font-size: 14px; font-weight: 600; flex-shrink: 0;
}
.rtd-activity-body { padding: 12px; overflow-y: auto; flex: 1; }
.rtd-activity-item {
    display: flex; gap: 10px; padding: 8px 0;
    border-bottom: 1px solid #f5f5f5; font-size: 12px;
}
.rtd-activity-item:last-child { border-bottom: none; }
.rtd-activity-icon {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    background: rgba(102,126,234,.1); color: #667eea;
    display: flex; align-items: center; justify-content: center; font-size: 11px;
}
.rtd-activity-text { color: #333; line-height: 1.4; }
.rtd-activity-time { color: #aaa; font-size: 11px; margin-top: 2px; }
.rtd-no-activity { text-align: center; padding: 20px; color: #aaa; font-size: 13px; }

/* Modals */
.rtd-modal {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.5); align-items: center; justify-content: center;
}
.rtd-modal.open { display: flex; }
.rtd-modal-box {
    background: #fff; border-radius: 16px; width: 90%; max-width: 520px;
    box-shadow: 0 20px 60px rgba(0,0,0,.3); overflow: hidden;
}
.rtd-modal-header {
    padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;
    background: linear-gradient(135deg,#667eea,#764ba2); color: #fff;
}
.rtd-modal-header h5 { margin: 0; font-size: 15px; font-weight: 700; }
.rtd-modal-header button { background: none; border: none; color: #fff; font-size: 18px; cursor: pointer; }
.rtd-modal-body { padding: 20px; }

@media (max-width: 992px) {
    .rtd-metrics { grid-template-columns: repeat(2,1fr); }
    .rtd-layout  { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
    .rtd-metrics { grid-template-columns: 1fr 1fr; }
    .rtd-pipeline-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight:700;color:#1a1a1a;">
            <i class="fas fa-chart-line me-2" style="color:#667eea;"></i>Real-Time Hiring Dashboard
            <span class="rtd-live-badge"><span class="pulse"></span>LIVE</span>
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:13px;">
                <li class="breadcrumb-item">
                    <a href="<?= base_url($this->session->userdata('Role') === 'Admin' ? 'A_dashboard' : 'R_dashboard') ?>" style="color:#667eea;">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Real-Time View</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary" onclick="rtDashboard.manualRefresh()" title="Refresh">
            <i class="fas fa-sync-alt me-1"></i>Refresh
        </button>
        <button class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('rtd-settings-modal').classList.add('open')" title="Settings">
            <i class="fas fa-cog"></i>
        </button>
    </div>
</div>

<!-- Metrics Bar -->
<div class="rtd-metrics" id="metrics-container">
    <div class="rtd-metric-card c1">
        <div class="rtd-metric-value" id="metric-total">—</div>
        <div class="rtd-metric-label"><i class="fas fa-users me-1"></i>Total Candidates</div>
    </div>
    <div class="rtd-metric-card c2">
        <div class="rtd-metric-value" id="metric-avg-days">—</div>
        <div class="rtd-metric-label"><i class="fas fa-clock me-1"></i>Avg Days in Pipeline</div>
    </div>
    <div class="rtd-metric-card c3">
        <div class="rtd-metric-value" id="metric-urgent">—</div>
        <div class="rtd-metric-label"><i class="fas fa-exclamation-triangle me-1"></i>Urgent</div>
    </div>
    <div class="rtd-metric-card c4">
        <div class="rtd-metric-value" id="metric-today">—</div>
        <div class="rtd-metric-label"><i class="fas fa-calendar-day me-1"></i>Today's Interviews</div>
    </div>
</div>

<!-- Pipeline + Activity -->
<div class="rtd-layout">
    <!-- Pipeline -->
    <div>
        <div class="rtd-pipeline-header">
            <h5 style="font-weight:700;margin:0;"><i class="fas fa-stream me-2" style="color:#667eea;"></i>Hiring Pipeline</h5>
            <button class="btn btn-sm btn-outline-primary" onclick="rtDashboard.manualRefresh()">
                <i class="fas fa-redo me-1"></i>Refresh
            </button>
        </div>
        <div id="pipeline-container" class="rtd-pipeline-grid">
            <div class="rtd-loading"><i class="fas fa-spinner fa-spin me-2"></i>Loading pipeline...</div>
        </div>
    </div>

    <!-- Activity Feed -->
    <div>
        <div class="rtd-activity-widget">
            <div class="rtd-activity-header">
                <i class="fas fa-history me-2"></i>Recent Activity
            </div>
            <div class="rtd-activity-body" id="activity-feed">
                <div class="rtd-no-activity"><i class="fas fa-spinner fa-spin"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div id="rtd-quickview-modal" class="rtd-modal">
    <div class="rtd-modal-box">
        <div class="rtd-modal-header">
            <h5><i class="fas fa-user me-2"></i>Candidate Quick View</h5>
            <button onclick="document.getElementById('rtd-quickview-modal').classList.remove('open')">&times;</button>
        </div>
        <div class="rtd-modal-body" id="quick-view-content">Loading...</div>
    </div>
</div>

<!-- Settings Modal -->
<div id="rtd-settings-modal" class="rtd-modal">
    <div class="rtd-modal-box">
        <div class="rtd-modal-header">
            <h5><i class="fas fa-cog me-2"></i>Dashboard Settings</h5>
            <button onclick="document.getElementById('rtd-settings-modal').classList.remove('open')">&times;</button>
        </div>
        <div class="rtd-modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fas fa-clock me-1"></i>Auto-Refresh Interval</label>
                <select id="refresh-interval" class="form-select" onchange="rtDashboard.updateRefreshInterval(this.value)">
                    <option value="3000">3 seconds</option>
                    <option value="5000" selected>5 seconds</option>
                    <option value="10000">10 seconds</option>
                    <option value="30000">30 seconds</option>
                    <option value="60000">1 minute</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fas fa-bell me-1"></i>Notifications</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notifications-toggle" checked
                           onchange="rtDashboard.toggleNotifications(this.checked)">
                    <label class="form-check-label" for="notifications-toggle">Enable notifications</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fas fa-volume-up me-1"></i>Sound Alerts</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="sound-toggle"
                           onchange="rtDashboard.toggleSound(this.checked)">
                    <label class="form-check-label" for="sound-toggle">Enable sound alerts</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Voting Modal -->
<div id="rtd-voting-modal" class="rtd-modal">
    <div class="rtd-modal-box">
        <div class="rtd-modal-header">
            <h5><i class="fas fa-vote-yea me-2"></i>Vote on Candidate</h5>
            <button onclick="document.getElementById('rtd-voting-modal').classList.remove('open')">&times;</button>
        </div>
        <div class="rtd-modal-body">
            <div class="d-flex gap-3 mb-3">
                <button class="btn btn-success flex-fill" onclick="submitVote('yes')"><i class="fas fa-thumbs-up me-1"></i>Yes</button>
                <button class="btn btn-danger flex-fill"  onclick="submitVote('no')"><i class="fas fa-thumbs-down me-1"></i>No</button>
                <button class="btn btn-secondary flex-fill" onclick="submitVote('abstain')"><i class="fas fa-minus me-1"></i>Abstain</button>
            </div>
            <div class="mb-3">
                <label class="form-label">Comment (optional)</label>
                <textarea id="vote-comment" class="form-control" rows="3" placeholder="Add your feedback..."></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="vote-anonymous-check">
                <label class="form-check-label" for="vote-anonymous-check">Submit anonymously</label>
            </div>
        </div>
    </div>
</div>

<?php
$base_url    = base_url();
$user_id     = (int)$this->session->userdata('id');
$user_role   = $this->session->userdata('Role');

$custom_script = <<<JAVASCRIPT

// ── Stage colour map ──
var stageColors = {
    'Applied':            '#6b7280',
    'Screening':          '#06b6d4',
    'Phone Interview':    '#f59e0b',
    'Technical Interview':'#f97316',
    'Final Interview':    '#3b82f6',
    'Offer':              '#8b5cf6',
    'Hired':              '#22c55e',
    'Rejected':           '#ef4444'
};

var rtDashboard = {
    baseUrl:        '{$base_url}',
    updateInterval: 5000,
    userId:         {$user_id},
    userRole:       '{$user_role}',
    timer:          null,

    init: function() {
        this.loadMetrics();
        this.loadPipeline();
        this.loadActivity();
        this.startAutoRefresh();
    },

    startAutoRefresh: function() {
        var self = this;
        if (this.timer) clearInterval(this.timer);
        if (this.updateInterval > 0) {
            this.timer = setInterval(function() {
                self.loadMetrics();
                self.loadPipeline();
                self.loadActivity();
            }, this.updateInterval);
        }
    },

    manualRefresh: function() {
        this.loadMetrics();
        this.loadPipeline();
        this.loadActivity();
    },

    updateRefreshInterval: function(val) {
        this.updateInterval = parseInt(val);
        this.startAutoRefresh();
    },

    toggleNotifications: function(v) {},
    toggleSound:         function(v) {},

    loadMetrics: function() {
        $.getJSON(this.baseUrl + 'realtime_dashboard/get_metrics', function(res) {
            if (res.success && res.metrics) {
                var m = res.metrics;
                $('#metric-total').text(m.total_candidates    || 0);
                $('#metric-avg-days').text(m.avg_days_in_pipeline ? parseFloat(m.avg_days_in_pipeline).toFixed(1) : 0);
                $('#metric-urgent').text(m.urgent_count       || 0);
                $('#metric-today').text(m.todays_interviews   || 0);
            }
        });
    },

    loadPipeline: function() {
        $.getJSON(this.baseUrl + 'realtime_dashboard/get_pipeline_data', function(res) {
            if (!res.success) return;
            var stages = res.data;
            if (!stages || !stages.length) {
                $('#pipeline-container').html('<div class="rtd-loading">No pipeline data available.</div>');
                return;
            }
            var html = '';
            stages.forEach(function(stage) {
                var color = stageColors[stage.name] || '#667eea';
                html += '<div class="rtd-stage-col">';
                html += '<div class="rtd-stage-header" style="background:' + color + ';">';
                html += '<span>' + stage.name + '</span>';
                html += '<span class="rtd-stage-count">' + (stage.candidates ? stage.candidates.length : 0) + '</span>';
                html += '</div><div class="rtd-stage-body">';
                if (stage.candidates && stage.candidates.length) {
                    stage.candidates.forEach(function(c) {
                        html += '<div class="rtd-candidate-card">';
                        html += '<div class="rtd-candidate-name">' + (c.name || c.cd_name || 'Unknown') + '</div>';
                        html += '<div class="rtd-candidate-role"><i class="fas fa-briefcase me-1"></i>' + (c.job_title || c.cd_job_title || 'N/A') + '</div>';
                        html += '<div class="rtd-candidate-meta"><i class="fas fa-clock"></i>' + (c.days_in_stage || 0) + ' days</div>';
                        html += '<div class="rtd-candidate-actions">';
                        html += '<button onclick="rtDashboard.quickView(' + c.id + ')" title="View"><i class="fas fa-eye"></i></button>';
                        html += '<button onclick="rtDashboard.editCandidate(' + c.id + ')" title="Edit"><i class="fas fa-edit"></i></button>';
                        html += '<button onclick="rtDashboard.assignCandidate(' + c.id + ')" title="Assign"><i class="fas fa-user-plus"></i></button>';
                        html += '</div></div>';
                    });
                } else {
                    html += '<div style="text-align:center;padding:16px;color:#ccc;font-size:12px;"><i class="fas fa-inbox"></i><br>Empty</div>';
                }
                html += '</div></div>';
            });
            $('#pipeline-container').html(html);
        });
    },

    loadActivity: function() {
        $.getJSON(this.baseUrl + 'realtime_dashboard/get_activity?limit=20', function(res) {
            if (!res.success || !res.activity || !res.activity.length) {
                $('#activity-feed').html('<div class="rtd-no-activity">No recent activity</div>');
                return;
            }
            var html = '';
            res.activity.forEach(function(a) {
                html += '<div class="rtd-activity-item">';
                html += '<div class="rtd-activity-icon"><i class="fas fa-circle-dot"></i></div>';
                html += '<div><div class="rtd-activity-text">' + (a.description || a.action || 'Activity') + '</div>';
                html += '<div class="rtd-activity-time">' + (a.time_ago || a.created_at || '') + '</div></div>';
                html += '</div>';
            });
            $('#activity-feed').html(html);
        });
    },

    quickView: function(id) {
        $('#quick-view-content').html('<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i></div>');
        document.getElementById('rtd-quickview-modal').classList.add('open');
        $.getJSON(this.baseUrl + 'realtime_dashboard/get_candidate/' + id, function(res) {
            if (res.success && res.candidate) {
                var c = res.candidate;
                var html = '<table class="table table-sm">';
                html += '<tr><th>Name</th><td>' + (c.cd_name || 'N/A') + '</td></tr>';
                html += '<tr><th>Email</th><td>' + (c.cd_email || 'N/A') + '</td></tr>';
                html += '<tr><th>Phone</th><td>' + (c.cd_phone || 'N/A') + '</td></tr>';
                html += '<tr><th>Job Title</th><td>' + (c.cd_job_title || 'N/A') + '</td></tr>';
                html += '<tr><th>Status</th><td>' + (c.cd_status || 'N/A') + '</td></tr>';
                html += '</table>';
                $('#quick-view-content').html(html);
            } else {
                $('#quick-view-content').html('<p class="text-danger">Could not load candidate details.</p>');
            }
        });
    },

    editCandidate: function(id) {
        window.location.href = this.baseUrl + 'A_dashboard/Acandidate_users_view';
    },

    assignCandidate: function(id) {
        alert('Assign feature coming soon for candidate #' + id);
    },

    openSettings: function() {
        document.getElementById('rtd-settings-modal').classList.add('open');
    }
};

// Close modals on backdrop click
document.querySelectorAll('.rtd-modal').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target === m) m.classList.remove('open');
    });
});

function submitVote(vote) {
    alert('Vote: ' + vote + ' (feature coming soon)');
    document.getElementById('rtd-voting-modal').classList.remove('open');
}

$(document).ready(function() {
    rtDashboard.init();
});
JAVASCRIPT;

$this->load->view('templates/admin_footer');

// Output the custom script AFTER footer (which loads jQuery)
echo '<script>' . $custom_script . '</script>';
?>
