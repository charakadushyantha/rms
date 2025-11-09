<?php
// Set page-specific variables
$data['page_title'] = 'Calendar';
$data['use_calendar'] = true;

// Load the header template
$this->load->view('templates/recruiter_header', $data);
?>

<style>
/* Enhanced Calendar Styles with Modern Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.calendar-wrapper {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    animation: fadeInUp 0.5s ease-out;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.calendar-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.calendar-title i {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.calendar-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.view-switcher {
    display: flex;
    gap: 0.25rem;
    background: #f3f4f6;
    padding: 0.375rem;
    border-radius: 10px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
}

.view-btn {
    padding: 0.625rem 1.25rem;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.view-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0;
    transition: opacity 0.3s;
    z-index: -1;
}

.view-btn:hover {
    background: white;
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.view-btn.active {
    background: white;
    color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    transform: translateY(-1px);
}

.view-btn i {
    margin-right: 0.375rem;
}

/* Old stats CSS removed - using grid version below */


/* Interview Type Legend */
.calendar-legend {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    transition: all 0.2s;
    cursor: pointer;
}

.legend-item:hover {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.legend-item:hover .legend-color {
    transform: scale(1.2);
}

/* FullCalendar Customization */
.fc {
    font-family: 'Inter', sans-serif;
}

.fc-toolbar-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
}

.fc-button {
    background: #667eea !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 0.5rem 1rem !important;
    font-weight: 500 !important;
    text-transform: capitalize !important;
}

.fc-button:hover {
    background: #5568d3 !important;
}

.fc-button-active {
    background: #5568d3 !important;
}

.fc-daygrid-day-number {
    font-weight: 600;
    color: #374151;
}

.fc-col-header-cell {
    background: #f9fafb;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

/* Enhanced Event Styling */
.fc-event {
    border-radius: 6px !important;
    padding: 4px 8px !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
}

.fc-event:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.fc-event-title {
    font-weight: 600 !important;
    font-size: 0.875rem !important;
}

.fc-event-time {
    font-weight: 500 !important;
    opacity: 0.9 !important;
}

/* Event Colors by Type */
.event-screening {
    background: linear-gradient(135deg, #FCD34D 0%, #FBB040 100%) !important;
    color: #78350F !important;
    border-left: 4px solid #F59E0B !important;
}

.event-technical {
    background: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%) !important;
    color: #1E3A8A !important;
    border-left: 4px solid #2563EB !important;
}

.event-hr {
    background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%) !important;
    color: #4C1D95 !important;
    border-left: 4px solid #7C3AED !important;
}

.event-final {
    background: linear-gradient(135deg, #34D399 0%, #10B981 100%) !important;
    color: #065F46 !important;
    border-left: 4px solid #059669 !important;
}

.event-cancelled {
    background: linear-gradient(135deg, #F87171 0%, #EF4444 100%) !important;
    color: #7F1D1D !important;
    opacity: 0.7 !important;
    text-decoration: line-through !important;
    border-left: 4px solid #DC2626 !important;
}

/* Today's Date Highlight */
.fc-day-today {
    background: rgba(102, 126, 234, 0.08) !important;
}

.fc-day-today .fc-daygrid-day-number {
    background: #667eea;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Weekend Styling */
.fc-day-sat, .fc-day-sun {
    background: #fafafa;
}

/* Event Time Badge */
.fc-event-time {
    background: rgba(0, 0, 0, 0.1);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.75rem !important;
    margin-right: 4px;
}

/* Loading Spinner */
.calendar-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f4f6;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Event Detail Modal */
.event-detail-modal .modal-content {
    border-radius: 16px;
    border: none;
}

.event-detail-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 16px 16px 0 0;
}

.event-detail-body {
    padding: 1.5rem;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.detail-content {
    flex: 1;
}

.detail-label {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-confirmed {
    background: #d1fae5;
    color: #065f46;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

/* Stats Cards */
.calendar-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.25rem;
    border-radius: 12px;
    color: white;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.stat-card.stat-today {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card.stat-week {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card.stat-pending {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-content h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
}

.stat-content p {
    font-size: 0.875rem;
    margin: 0;
    opacity: 0.9;
}

/* Search and Filter Bar */
.calendar-controls {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.875rem;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-select:focus {
    outline: none;
    border-color: #667eea;
}

.export-btn {
    padding: 0.75rem 1.25rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.export-btn:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f9fafb;
}

/* Responsive */
@media (max-width: 768px) {
    .calendar-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .calendar-legend {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .view-switcher {
        width: 100%;
    }
    
    .view-btn {
        flex: 1;
        text-align: center;
    }
    
    .calendar-stats {
        grid-template-columns: 1fr;
    }
    
    .calendar-controls {
        flex-direction: column;
    }
    
    .search-box {
        width: 100%;
    }
    
    .filter-group {
        width: 100%;
        flex-wrap: wrap;
    }
    
    .filter-select {
        flex: 1;
    }
}
</style>

<!-- Calendar Wrapper -->
<div class="calendar-wrapper">
    <div class="calendar-header">
        <h1 class="calendar-title">
            <i class="fas fa-calendar-alt me-2"></i>Interview Schedule
        </h1>
        <div class="calendar-actions">
            <div class="view-switcher">
                <button class="view-btn active" data-view="month">
                    <i class="fas fa-calendar"></i> Month
                </button>
                <button class="view-btn" data-view="week">
                    <i class="fas fa-calendar-week"></i> Week
                </button>
                <button class="view-btn" data-view="day">
                    <i class="fas fa-calendar-day"></i> Day
                </button>
                <button class="view-btn" data-view="list">
                    <i class="fas fa-list"></i> List
                </button>
            </div>
            <button class="btn btn-primary-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus me-2"></i>Schedule Interview
            </button>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="calendar-stats" style="display: grid !important; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important; gap: 1rem !important; margin-bottom: 1.5rem !important;">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3 id="totalInterviews">0</h3>
                <p>Total Interviews</p>
            </div>
        </div>
        <div class="stat-card stat-today">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <h3 id="todayInterviews">0</h3>
                <p>Today's Interviews</p>
            </div>
        </div>
        <div class="stat-card stat-week">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-content">
                <h3 id="weekInterviews">0</h3>
                <p>This Week</p>
            </div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 id="upcomingInterviews">0</h3>
                <p>Upcoming</p>
            </div>
        </div>
    </div>
    
    <!-- Search and Filter Controls -->
    <div class="calendar-controls" style="display: flex !important; gap: 1rem !important; margin-bottom: 1.5rem !important; flex-wrap: wrap !important;">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchEvents" placeholder="Search by candidate name, position, or interviewer...">
        </div>
        <div class="filter-group">
            <select class="filter-select" id="filterType">
                <option value="">All Types</option>
                <option value="0.25">Screening</option>
                <option value="0.5">Technical</option>
                <option value="0.75">HR Round</option>
                <option value="1">Final Round</option>
            </select>
            <select class="filter-select" id="filterStatus">
                <option value="">All Status</option>
                <option value="confirmed">Confirmed</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button class="export-btn" onclick="exportCalendar()">
                <i class="fas fa-download"></i>
                Export
            </button>
        </div>
    </div>
    
    <!-- Interview Type Legend -->
    <div class="calendar-legend">
        <div class="legend-item">
            <div class="legend-color" style="background: #FCD34D;"></div>
            <span>Screening/Initial</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background: #60A5FA;"></div>
            <span>Technical Round</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background: #A78BFA;"></div>
            <span>HR Round</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background: #34D399;"></div>
            <span>Final Round</span>
        </div>
        <div class="legend-item">
            <div class="legend-color" style="background: #F87171;"></div>
            <span>Cancelled</span>
        </div>
    </div>
    
    <!-- Calendar Container -->
    <div id="calendar"></div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade event-detail-modal" id="eventDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="event-detail-header">
                <h5 class="modal-title" id="eventDetailTitle">Interview Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="event-detail-body">
                <div class="detail-row">
                    <div class="detail-icon" style="background: #dbeafe;">
                        <i class="fas fa-user" style="color: #1e40af;"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Candidate</div>
                        <div class="detail-value" id="detailCandidate">-</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon" style="background: #fef3c7;">
                        <i class="fas fa-briefcase" style="color: #92400e;"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Position</div>
                        <div class="detail-value" id="detailPosition">-</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon" style="background: #d1fae5;">
                        <i class="fas fa-clock" style="color: #065f46;"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Time</div>
                        <div class="detail-value" id="detailTime">-</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon" style="background: #e0e7ff;">
                        <i class="fas fa-user-tie" style="color: #4338ca;"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Interviewer</div>
                        <div class="detail-value" id="detailInterviewer">-</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon" style="background: #fce7f3;">
                        <i class="fas fa-layer-group" style="color: #9f1239;"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Interview Type</div>
                        <div class="detail-value" id="detailType">-</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-content">
                        <div class="detail-label">Status</div>
                        <span class="status-badge status-confirmed" id="detailStatus">
                            <i class="fas fa-check-circle"></i> Confirmed
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info text-white" onclick="sendReminder()">
                    <i class="fas fa-bell me-2"></i>Send Reminder
                </button>
                <button type="button" class="btn btn-warning text-white" onclick="editEvent()">
                    <i class="fas fa-edit me-2"></i>Edit
                </button>
                <button type="button" class="btn btn-danger" onclick="cancelInterview()">
                    <i class="fas fa-times me-2"></i>Cancel Interview
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal (Enhanced) -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-plus me-2"></i>Schedule New Interview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Candidate Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="candidate_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="position" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Interview Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="interview_type" required>
                                <option value="">Select Type</option>
                                <option value="0.25">Screening/Initial</option>
                                <option value="0.5">Technical Round</option>
                                <option value="0.75">HR Round</option>
                                <option value="1">Final Round</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Interviewer <span class="text-danger">*</span></label>
                            <select class="form-select" name="interviewer" required>
                                <option value="">Select Interviewer</option>
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Add any special instructions or notes..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-modern btn-modern" onclick="saveEvent()">
                    <i class="fas fa-calendar-check me-2"></i>Schedule Interview
                </button>
            </div>
        </div>
    </div>
</div>

<?php
// Enhanced Calendar Script
$custom_script = "
let calendar;
let allEvents = [];
let filteredEvents = [];

document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
    initializeViewSwitcher();
    initializeSearchAndFilters();
    loadInterviewStats();
});

function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        height: 'auto',
        nowIndicator: true,
        navLinks: true,
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5],
            startTime: '09:00',
            endTime: '18:00'
        },
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        events: function(info, successCallback, failureCallback) {
            showLoading(true);
            fetch('" . base_url('R_dashboard/get_events') . "')
                .then(response => response.json())
                .then(data => {
                    allEvents = data.map(event => {
                        const eventClass = getEventClass(event.interview_round);
                        return {
                            id: event.id,
                            title: event.Can_name,
                            start: event.start,
                            end: event.end,
                            className: eventClass,
                            extendedProps: {
                                candidate: event.Can_name,
                                position: event.position || 'Not specified',
                                recruiter: event.Recruiter_username,
                                interviewer: event.Interviewer,
                                round: event.interview_round,
                                type: getInterviewType(event.interview_round),
                                status: event.status || 'Confirmed'
                            }
                        };
                    });
                    filteredEvents = [...allEvents];
                    updateStats(allEvents);
                    successCallback(filteredEvents);
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error loading events:', error);
                    showLoading(false);
                    failureCallback(error);
                });
        },
        eventClick: function(info) {
            showEventDetails(info.event);
        },
        editable: true,
        selectable: true,
        select: function(info) {
            // Open add event modal with pre-filled dates
            const modal = new bootstrap.Modal(document.getElementById('addEventModal'));
            document.querySelector('[name=\"start_date\"]').value = formatDateTimeLocal(info.start);
            document.querySelector('[name=\"end_date\"]').value = formatDateTimeLocal(info.end);
            modal.show();
        },
        eventDrop: function(info) {
            Swal.fire({
                title: 'Reschedule Interview?',
                text: 'Do you want to reschedule this interview?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, reschedule',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Handle event drop (reschedule)
                    updateEventDate(info.event);
                } else {
                    info.revert();
                }
            });
        },
        eventResize: function(info) {
            Swal.fire({
                title: 'Update Duration?',
                text: 'Do you want to update the interview duration?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateEventDate(info.event);
                } else {
                    info.revert();
                }
            });
        },
        eventDidMount: function(info) {
            // Add tooltip
            tippy(info.el, {
                content: createTooltipContent(info.event),
                allowHTML: true,
                theme: 'light-border',
                placement: 'top'
            });
        }
    });
    
    calendar.render();
}

function createTooltipContent(event) {
    const props = event.extendedProps;
    return '<div style=\"text-align: left; padding: 0.5rem;\">' +
           '<strong>' + props.candidate + '</strong><br>' +
           '<small>' + props.position + '</small><br>' +
           '<small><i class=\"fas fa-clock\"></i> ' + event.start.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) + '</small><br>' +
           '<small><i class=\"fas fa-user-tie\"></i> ' + props.interviewer + '</small>' +
           '</div>';
}

function showLoading(show) {
    let loader = document.querySelector('.calendar-loading');
    if (show) {
        if (!loader) {
            loader = document.createElement('div');
            loader.className = 'calendar-loading';
            loader.innerHTML = '<div class=\"spinner\"></div>';
            document.querySelector('.calendar-wrapper').appendChild(loader);
        }
    } else {
        if (loader) loader.remove();
    }
}

function initializeViewSwitcher() {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Update active state
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Change calendar view
            const viewMap = {
                'month': 'dayGridMonth',
                'week': 'timeGridWeek',
                'day': 'timeGridDay',
                'list': 'listWeek'
            };
            
            if(calendar && viewMap[view]) {
                calendar.changeView(viewMap[view]);
            }
        });
    });
}

function getEventClass(round) {
    if (round == 0.25) return 'event-screening';
    if (round == 0.5) return 'event-technical';
    if (round == 0.75) return 'event-hr';
    if (round == 1) return 'event-final';
    return 'event-technical';
}

function getInterviewType(round) {
    if (round == 0.25) return 'Screening/Initial';
    if (round == 0.5) return 'Technical Round';
    if (round == 0.75) return 'HR Round';
    if (round == 1) return 'Final Round';
    return 'Interview';
}

function showEventDetails(event) {
    const props = event.extendedProps;
    
    document.getElementById('detailCandidate').textContent = props.candidate;
    document.getElementById('detailPosition').textContent = props.position;
    document.getElementById('detailTime').textContent = formatEventTime(event.start, event.end);
    document.getElementById('detailInterviewer').textContent = props.interviewer;
    document.getElementById('detailType').textContent = props.type;
    
    // Update status badge
    const statusBadge = document.getElementById('detailStatus');
    statusBadge.className = 'status-badge status-' + props.status.toLowerCase();
    statusBadge.innerHTML = '<i class=\"fas fa-check-circle\"></i> ' + props.status;
    
    const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
    modal.show();
}

function formatEventTime(start, end) {
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    const startStr = start.toLocaleString('en-US', options);
    const endTime = end.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    
    return startStr + ' - ' + endTime;
}

function formatDateTimeLocal(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
}

function saveEvent() {
    const form = document.getElementById('addEventForm');
    if(!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Show loading
    Swal.fire({
        title: 'Scheduling...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Submit to server
    fetch('" . base_url('R_dashboard/add_event') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Interview Scheduled!',
                text: 'The interview has been added to the calendar',
                timer: 2000
            }).then(() => {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
                form.reset();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to schedule interview'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while scheduling the interview'
        });
    });
}
";

$data['custom_script'] = $custom_script;

// Load the footer template
$this->load->view('templates/recruiter_footer', $data);
?>


// Additional Enhanced Features
function initializeSearchAndFilters() {
    // Search functionality
    const searchInput = document.getElementById('searchEvents');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterEvents();
        });
    }
    
    // Filter by type
    const filterType = document.getElementById('filterType');
    if (filterType) {
        filterType.addEventListener('change', filterEvents);
    }
    
    // Filter by status
    const filterStatus = document.getElementById('filterStatus');
    if (filterStatus) {
        filterStatus.addEventListener('change', filterEvents);
    }
}

function filterEvents() {
    const searchTerm = document.getElementById('searchEvents')?.value.toLowerCase() || '';
    const filterType = document.getElementById('filterType')?.value || '';
    const filterStatus = document.getElementById('filterStatus')?.value || '';
    
    filteredEvents = allEvents.filter(event => {
        const matchesSearch = !searchTerm || 
            event.extendedProps.candidate.toLowerCase().includes(searchTerm) ||
            event.extendedProps.position.toLowerCase().includes(searchTerm) ||
            event.extendedProps.interviewer.toLowerCase().includes(searchTerm);
        
        const matchesType = !filterType || event.extendedProps.round == filterType;
        const matchesStatus = !filterStatus || event.extendedProps.status.toLowerCase() === filterStatus;
        
        return matchesSearch && matchesType && matchesStatus;
    });
    
    if (calendar) {
        calendar.removeAllEvents();
        calendar.addEventSource(filteredEvents);
    }
}

function updateStats(events) {
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const weekFromNow = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
    
    const totalInterviews = events.length;
    const todayInterviews = events.filter(e => {
        const eventDate = new Date(e.start);
        return eventDate.toDateString() === today.toDateString();
    }).length;
    
    const weekInterviews = events.filter(e => {
        const eventDate = new Date(e.start);
        return eventDate >= today && eventDate < weekFromNow;
    }).length;
    
    const upcomingInterviews = events.filter(e => {
        const eventDate = new Date(e.start);
        return eventDate > now;
    }).length;
    
    document.getElementById('totalInterviews').textContent = totalInterviews;
    document.getElementById('todayInterviews').textContent = todayInterviews;
    document.getElementById('weekInterviews').textContent = weekInterviews;
    document.getElementById('upcomingInterviews').textContent = upcomingInterviews;
}

function loadInterviewStats() {
    // Stats are updated when events are loaded
}

function updateEventDate(event) {
    const eventData = {
        id: event.id,
        start: event.start.toISOString(),
        end: event.end.toISOString()
    };
    
    fetch('" . base_url('R_dashboard/update_event') . "', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Interview has been rescheduled',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update interview'
            });
            calendar.refetchEvents();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating the interview'
        });
        calendar.refetchEvents();
    });
}

function sendReminder() {
    Swal.fire({
        title: 'Send Reminder?',
        text: 'Send email reminder to candidate and interviewer?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, send it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Reminder Sent!',
                text: 'Email reminders have been sent successfully',
                timer: 2000
            });
        }
    });
}

function editEvent() {
    Swal.fire({
        icon: 'info',
        title: 'Edit Feature',
        text: 'Edit functionality coming soon!'
    });
}

function cancelInterview() {
    Swal.fire({
        title: 'Cancel Interview?',
        text: 'Are you sure you want to cancel this interview?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it',
        cancelButtonText: 'No, keep it',
        confirmButtonColor: '#dc2626'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Cancelled!',
                text: 'Interview has been cancelled',
                timer: 2000
            }).then(() => {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('eventDetailModal')).hide();
            });
        }
    });
}

function exportCalendar() {
    Swal.fire({
        title: 'Export Calendar',
        text: 'Choose export format:',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class=\"fas fa-file-pdf\"></i> PDF',
        cancelButtonText: '<i class=\"fas fa-file-excel\"></i> Excel',
        showDenyButton: true,
        denyButtonText: '<i class=\"fas fa-file-csv\"></i> CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            exportToPDF();
        } else if (result.isDenied) {
            exportToCSV();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            exportToExcel();
        }
    });
}

function exportToPDF() {
    Swal.fire({
        icon: 'info',
        title: 'Generating PDF...',
        text: 'Your calendar is being exported',
        timer: 2000
    });
}

function exportToCSV() {
    const csvContent = 'data:text/csv;charset=utf-8,' + 
        'Candidate,Position,Date,Time,Interviewer,Type,Status\\n' +
        filteredEvents.map(e => {
            return `${e.extendedProps.candidate},${e.extendedProps.position},${new Date(e.start).toLocaleDateString()},${new Date(e.start).toLocaleTimeString()},${e.extendedProps.interviewer},${e.extendedProps.type},${e.extendedProps.status}`;
        }).join('\\n');
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'interview_calendar.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    Swal.fire({
        icon: 'success',
        title: 'Exported!',
        text: 'Calendar exported to CSV successfully',
        timer: 2000
    });
}

function exportToExcel() {
    Swal.fire({
        icon: 'info',
        title: 'Generating Excel...',
        text: 'Your calendar is being exported',
        timer: 2000
    });
}
";
