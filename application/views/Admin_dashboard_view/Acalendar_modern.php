<?php
// Set page-specific variables
$data['page_title'] = 'Interview Calendar';
$data['use_calendar'] = true;

// Load the header template
$this->load->view('templates/admin_header', $data);
?>

<style>
/* Modern Calendar Dashboard Styles */
.calendar-dashboard {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
    margin-bottom: 24px;
}

.calendar-main {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.calendar-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.mini-calendar {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.mini-calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.mini-calendar-month {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
}

.mini-calendar-nav {
    display: flex;
    gap: 8px;
}

.mini-calendar-nav button {
    width: 32px;
    height: 32px;
    border: none;
    background: #f7fafc;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.mini-calendar-nav button:hover {
    background: #667eea;
    color: white;
}

.mini-calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
}

.mini-calendar-day-header {
    text-align: center;
    font-size: 11px;
    font-weight: 600;
    color: #a0aec0;
    padding: 8px 0;
}

.mini-calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    color: #4a5568;
}

.mini-calendar-day:hover {
    background: #f7fafc;
}

.mini-calendar-day.today {
    background: #667eea;
    color: white;
    font-weight: 600;
}

.mini-calendar-day.has-event {
    background: #e6fffa;
    color: #234e52;
    font-weight: 600;
}

.mini-calendar-day.other-month {
    color: #cbd5e0;
}

/* Event Tooltip */
.event-tooltip {
    position: absolute;
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    z-index: 1000;
    min-width: 280px;
    max-width: 350px;
    display: none;
    pointer-events: none;
}

.event-tooltip.show {
    display: block;
    animation: tooltipFadeIn 0.2s ease;
}

@keyframes tooltipFadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.tooltip-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
}

.tooltip-date {
    font-size: 14px;
    font-weight: 700;
    color: #667eea;
}

.tooltip-count {
    background: #667eea;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.tooltip-events {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
}

.tooltip-event-item {
    padding: 10px;
    background: #f7fafc;
    border-radius: 8px;
    border-left: 3px solid #667eea;
}

.tooltip-event-time {
    font-size: 12px;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 4px;
}

.tooltip-event-title {
    font-size: 13px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 2px;
}

.tooltip-event-meta {
    font-size: 11px;
    color: #718096;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tooltip-event-meta i {
    font-size: 10px;
}

.mini-calendar-day.has-event {
    position: relative;
}

.mini-calendar-day.has-event::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    background: #667eea;
    border-radius: 50%;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.stat-mini-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
}

.stat-mini-number {
    font-size: 28px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 4px;
}

.stat-mini-label {
    font-size: 12px;
    color: #718096;
}

.upcoming-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.upcoming-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.upcoming-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
}

.upcoming-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 400px;
    overflow-y: auto;
}

.upcoming-item {
    padding: 12px;
    background: #f7fafc;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    transition: all 0.2s;
    cursor: pointer;
}

.upcoming-item:hover {
    background: #edf2f7;
    transform: translateX(4px);
}

.upcoming-item-time {
    font-size: 12px;
    color: #667eea;
    font-weight: 600;
    margin-bottom: 4px;
}

.upcoming-item-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.upcoming-item-details {
    font-size: 12px;
    color: #718096;
}

.interview-list-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 24px;
}

.interview-filters {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 16px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-btn:hover {
    border-color: #667eea;
    color: #667eea;
}

.filter-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.interview-card {
    background: #f7fafc;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    display: grid;
    grid-template-columns: 80px 1fr auto;
    gap: 16px;
    align-items: center;
    transition: all 0.2s;
}

.interview-card:hover {
    background: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.interview-date-box {
    background: white;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    border: 2px solid #667eea;
}

.interview-date-day {
    font-size: 24px;
    font-weight: 700;
    color: #667eea;
    line-height: 1;
}

.interview-date-month {
    font-size: 12px;
    color: #718096;
    margin-top: 4px;
}

.interview-info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.interview-meta {
    display: flex;
    gap: 16px;
    font-size: 13px;
    color: #718096;
}

.interview-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.interview-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.action-btn.edit {
    background: #e6fffa;
    color: #234e52;
}

.action-btn.delete {
    background: #fff5f5;
    color: #c53030;
}

.action-btn:hover {
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #a0aec0;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    opacity: 0.3;
}

@media (max-width: 1200px) {
    .calendar-dashboard {
        grid-template-columns: 1fr;
    }
    
    .calendar-sidebar {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .calendar-sidebar {
        grid-template-columns: 1fr;
    }
    
    .interview-card {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .interview-date-box {
        margin: 0 auto;
        width: fit-content;
    }
}
</style>

<!-- Calendar Dashboard -->
<div class="calendar-dashboard">
    <!-- Main Calendar Area -->
    <div class="calendar-main">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Interview Schedule</h3>
                <p class="text-muted mb-0">Manage and track all interview appointments</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="fas fa-plus me-2"></i>Schedule Interview
            </button>
        </div>

        <!-- Filter Buttons -->
        <div class="interview-filters">
            <button class="filter-btn active" onclick="filterInterviews('all')">
                <i class="fas fa-calendar me-1"></i>All
            </button>
            <button class="filter-btn" onclick="filterInterviews('today')">
                <i class="fas fa-calendar-day me-1"></i>Today
            </button>
            <button class="filter-btn" onclick="filterInterviews('week')">
                <i class="fas fa-calendar-week me-1"></i>This Week
            </button>
            <button class="filter-btn" onclick="filterInterviews('month')">
                <i class="fas fa-calendar-alt me-1"></i>This Month
            </button>
        </div>

        <!-- Interview List -->
        <div id="interviewList">
            <!-- Sample Interview Cards - Replace with dynamic data -->
            <div class="interview-card" data-interview-id="1">
                <div class="interview-date-box">
                    <div class="interview-date-day">18</div>
                    <div class="interview-date-month">NOV</div>
                </div>
                <div class="interview-info">
                    <h4>John Doe - Software Engineer</h4>
                    <div class="interview-meta">
                        <span><i class="fas fa-clock"></i> 10:00 AM - 11:00 AM</span>
                        <span><i class="fas fa-user-tie"></i> Sarah Johnson</span>
                        <span><i class="fas fa-video"></i> Round 2</span>
                    </div>
                </div>
                <div class="interview-actions">
                    <button class="action-btn edit" onclick="editInterview(1)" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete" onclick="deleteInterview(1)" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <div class="interview-card" data-interview-id="2">
                <div class="interview-date-box">
                    <div class="interview-date-day">19</div>
                    <div class="interview-date-month">NOV</div>
                </div>
                <div class="interview-info">
                    <h4>Jane Smith - Product Manager</h4>
                    <div class="interview-meta">
                        <span><i class="fas fa-clock"></i> 2:00 PM - 3:00 PM</span>
                        <span><i class="fas fa-user-tie"></i> Mike Wilson</span>
                        <span><i class="fas fa-video"></i> Round 1</span>
                    </div>
                </div>
                <div class="interview-actions">
                    <button class="action-btn edit" onclick="editInterview(2)" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete" onclick="deleteInterview(2)" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Empty State (show when no interviews) -->
            <!-- <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h5>No Interviews Scheduled</h5>
                <p>Click "Schedule Interview" to add a new interview</p>
            </div> -->
        </div>
    </div>

    <!-- Sidebar -->
    <div class="calendar-sidebar">
        <!-- Mini Calendar -->
        <div class="mini-calendar" style="position: relative;">
            <div class="mini-calendar-header">
                <div class="mini-calendar-month">November 2025</div>
                <div class="mini-calendar-nav">
                    <button><i class="fas fa-chevron-left"></i></button>
                    <button><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="mini-calendar-grid">
                <div class="mini-calendar-day-header">S</div>
                <div class="mini-calendar-day-header">M</div>
                <div class="mini-calendar-day-header">T</div>
                <div class="mini-calendar-day-header">W</div>
                <div class="mini-calendar-day-header">T</div>
                <div class="mini-calendar-day-header">F</div>
                <div class="mini-calendar-day-header">S</div>
                
                <!-- Days -->
                <div class="mini-calendar-day other-month">26</div>
                <div class="mini-calendar-day other-month">27</div>
                <div class="mini-calendar-day other-month">28</div>
                <div class="mini-calendar-day other-month">29</div>
                <div class="mini-calendar-day other-month">30</div>
                <div class="mini-calendar-day">1</div>
                <div class="mini-calendar-day">2</div>
                <div class="mini-calendar-day">3</div>
                <div class="mini-calendar-day">4</div>
                <div class="mini-calendar-day">5</div>
                <div class="mini-calendar-day">6</div>
                <div class="mini-calendar-day">7</div>
                <div class="mini-calendar-day">8</div>
                <div class="mini-calendar-day">9</div>
                <div class="mini-calendar-day">10</div>
                <div class="mini-calendar-day">11</div>
                <div class="mini-calendar-day">12</div>
                <div class="mini-calendar-day">13</div>
                <div class="mini-calendar-day">14</div>
                <div class="mini-calendar-day">15</div>
                <div class="mini-calendar-day">16</div>
                <div class="mini-calendar-day today">17</div>
                <div class="mini-calendar-day has-event">18</div>
                <div class="mini-calendar-day has-event">19</div>
                <div class="mini-calendar-day">20</div>
                <div class="mini-calendar-day">21</div>
                <div class="mini-calendar-day">22</div>
                <div class="mini-calendar-day">23</div>
                <div class="mini-calendar-day">24</div>
                <div class="mini-calendar-day">25</div>
                <div class="mini-calendar-day">26</div>
                <div class="mini-calendar-day">27</div>
                <div class="mini-calendar-day">28</div>
                <div class="mini-calendar-day">29</div>
                <div class="mini-calendar-day">30</div>
            </div>
            
            <!-- Event Tooltip -->
            <div class="event-tooltip" id="eventTooltip"></div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-mini-card">
                <div class="stat-mini-number">12</div>
                <div class="stat-mini-label">Today</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number">45</div>
                <div class="stat-mini-label">This Week</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number">128</div>
                <div class="stat-mini-label">This Month</div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-number">8</div>
                <div class="stat-mini-label">Pending</div>
            </div>
        </div>

        <!-- Upcoming Interviews -->
        <div class="upcoming-section">
            <div class="upcoming-header">
                <div class="upcoming-title">Upcoming Today</div>
                <span class="badge bg-primary">3</span>
            </div>
            <div class="upcoming-list">
                <div class="upcoming-item">
                    <div class="upcoming-item-time">
                        <i class="fas fa-clock me-1"></i>10:00 AM
                    </div>
                    <div class="upcoming-item-title">John Doe</div>
                    <div class="upcoming-item-details">
                        Software Engineer • Sarah Johnson
                    </div>
                </div>
                <div class="upcoming-item">
                    <div class="upcoming-item-time">
                        <i class="fas fa-clock me-1"></i>2:00 PM
                    </div>
                    <div class="upcoming-item-title">Jane Smith</div>
                    <div class="upcoming-item-details">
                        Product Manager • Mike Wilson
                    </div>
                </div>
                <div class="upcoming-item">
                    <div class="upcoming-item-time">
                        <i class="fas fa-clock me-1"></i>4:30 PM
                    </div>
                    <div class="upcoming-item-title">Bob Johnson</div>
                    <div class="upcoming-item-details">
                        Data Analyst • Emily Davis
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Interview Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <input type="hidden" id="edit_interview_id" name="interview_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Candidate Name</label>
                        <input type="text" class="form-control" id="edit_candidate_name" name="candidate_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" id="edit_position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interviewer</label>
                        <select class="form-select" id="edit_interviewer" name="interviewer" required>
                            <option value="">Select Interviewer</option>
                            <option value="Sarah Johnson">Sarah Johnson</option>
                            <option value="Mike Wilson">Mike Wilson</option>
                            <option value="Emily Davis">Emily Davis</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_interview_date" name="interview_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" id="edit_interview_time" name="interview_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration (minutes)</label>
                        <select class="form-select" id="edit_duration" name="duration">
                            <option value="30">30 minutes</option>
                            <option value="60">1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interview Round</label>
                        <select class="form-select" id="edit_round" name="round">
                            <option value="1">Round 1 - Screening</option>
                            <option value="2">Round 2 - Technical</option>
                            <option value="3">Round 3 - HR</option>
                            <option value="4">Round 4 - Final</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateInterview()">
                    <i class="fas fa-save me-2"></i>Update Interview
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm">
                    <div class="mb-3">
                        <label class="form-label">Candidate Name</label>
                        <input type="text" class="form-control" name="candidate_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interviewer</label>
                        <select class="form-select" name="interviewer" required>
                            <option value="">Select Interviewer</option>
                            <option value="Sarah Johnson">Sarah Johnson</option>
                            <option value="Mike Wilson">Mike Wilson</option>
                            <option value="Emily Davis">Emily Davis</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="interview_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="interview_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration (minutes)</label>
                        <select class="form-select" name="duration">
                            <option value="30">30 minutes</option>
                            <option value="60" selected>1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Interview Round</label>
                        <select class="form-select" name="round">
                            <option value="1">Round 1 - Screening</option>
                            <option value="2">Round 2 - Technical</option>
                            <option value="3">Round 3 - HR</option>
                            <option value="4">Round 4 - Final</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveInterview()">
                    <i class="fas fa-save me-2"></i>Schedule Interview
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Calendar Navigation
let currentDate = new Date();
const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];

// Sample event data - Replace with actual data from your database
const eventData = {
    '2025-11-18': [
        { time: '10:00 AM', title: 'John Doe', position: 'Software Engineer', interviewer: 'Sarah Johnson', round: 'Round 2' },
        { time: '2:00 PM', title: 'Alice Brown', position: 'UX Designer', interviewer: 'Mike Wilson', round: 'Round 1' }
    ],
    '2025-11-19': [
        { time: '2:00 PM', title: 'Jane Smith', position: 'Product Manager', interviewer: 'Mike Wilson', round: 'Round 1' },
        { time: '4:30 PM', title: 'Bob Johnson', position: 'Data Analyst', interviewer: 'Emily Davis', round: 'Round 3' }
    ]
};

function getEventsForDate(year, month, day) {
    const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    return eventData[dateKey] || [];
}

function showEventTooltip(element, year, month, day) {
    const events = getEventsForDate(year, month, day);
    
    if (events.length === 0) return;
    
    const tooltip = document.getElementById('eventTooltip');
    const rect = element.getBoundingClientRect();
    const calendarRect = document.querySelector('.mini-calendar').getBoundingClientRect();
    
    // Build tooltip content
    let tooltipHTML = `
        <div class="tooltip-header">
            <div class="tooltip-date">${monthNames[month]} ${day}, ${year}</div>
            <div class="tooltip-count">${events.length} Interview${events.length > 1 ? 's' : ''}</div>
        </div>
        <div class="tooltip-events">
    `;
    
    events.forEach(event => {
        tooltipHTML += `
            <div class="tooltip-event-item">
                <div class="tooltip-event-time">
                    <i class="fas fa-clock"></i> ${event.time}
                </div>
                <div class="tooltip-event-title">${event.title}</div>
                <div class="tooltip-event-meta">
                    <span><i class="fas fa-briefcase"></i> ${event.position}</span>
                    <span><i class="fas fa-user-tie"></i> ${event.interviewer}</span>
                </div>
                <div class="tooltip-event-meta">
                    <span><i class="fas fa-video"></i> ${event.round}</span>
                </div>
            </div>
        `;
    });
    
    tooltipHTML += '</div>';
    
    tooltip.innerHTML = tooltipHTML;
    tooltip.classList.add('show');
    
    // Position tooltip
    const tooltipWidth = 280;
    let left = rect.left - calendarRect.left + (rect.width / 2) - (tooltipWidth / 2);
    let top = rect.bottom - calendarRect.top + 10;
    
    // Adjust if tooltip goes off screen
    if (left < 0) left = 10;
    if (left + tooltipWidth > calendarRect.width) {
        left = calendarRect.width - tooltipWidth - 10;
    }
    
    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
}

function hideEventTooltip() {
    const tooltip = document.getElementById('eventTooltip');
    tooltip.classList.remove('show');
}

function renderMiniCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update month display
    document.querySelector('.mini-calendar-month').textContent = `${monthNames[month]} ${year}`;
    
    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    // Clear existing days
    const calendarGrid = document.querySelector('.mini-calendar-grid');
    const dayHeaders = calendarGrid.querySelectorAll('.mini-calendar-day-header');
    calendarGrid.innerHTML = '';
    
    // Re-add day headers
    dayHeaders.forEach(header => calendarGrid.appendChild(header));
    
    // Add previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const dayEl = document.createElement('div');
        dayEl.className = 'mini-calendar-day other-month';
        dayEl.textContent = day;
        calendarGrid.appendChild(dayEl);
    }
    
    // Add current month days
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const dayEl = document.createElement('div');
        dayEl.className = 'mini-calendar-day';
        
        // Highlight today
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            dayEl.classList.add('today');
        }
        
        // Check if day has events
        const events = getEventsForDate(year, month, day);
        if (events.length > 0) {
            dayEl.classList.add('has-event');
            
            // Add hover event listeners
            dayEl.addEventListener('mouseenter', function(e) {
                showEventTooltip(this, year, month, day);
            });
            
            dayEl.addEventListener('mouseleave', function() {
                hideEventTooltip();
            });
        }
        
        dayEl.textContent = day;
        dayEl.onclick = () => selectDate(year, month, day);
        calendarGrid.appendChild(dayEl);
    }
    
    // Add next month days to fill grid
    const totalCells = calendarGrid.children.length - 7; // Subtract day headers
    const remainingCells = 42 - totalCells - 7; // 6 rows * 7 days - headers
    for (let day = 1; day <= remainingCells; day++) {
        const dayEl = document.createElement('div');
        dayEl.className = 'mini-calendar-day other-month';
        dayEl.textContent = day;
        calendarGrid.appendChild(dayEl);
    }
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderMiniCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderMiniCalendar();
}

function selectDate(year, month, day) {
    const selectedDate = new Date(year, month, day);
    console.log('Selected date:', selectedDate.toDateString());
    
    // Show selected date with SweetAlert
    Swal.fire({
        title: 'Date Selected',
        html: `<p>You selected: <strong>${monthNames[month]} ${day}, ${year}</strong></p>
               <p>Filter interviews for this date?</p>`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes, filter',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#667eea'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add filter logic here
            console.log('Filtering interviews for:', selectedDate);
        }
    });
}

// Initialize calendar on page load
document.addEventListener('DOMContentLoaded', function() {
    renderMiniCalendar();
    
    // Add event listeners to navigation buttons
    const navButtons = document.querySelectorAll('.mini-calendar-nav button');
    navButtons[0].onclick = previousMonth;
    navButtons[1].onclick = nextMonth;
});

function filterInterviews(filter) {
    // Remove active class from all buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    event.target.closest('.filter-btn').classList.add('active');
    
    // Filter logic here
    console.log('Filtering by:', filter);
    
    // Example: Show/hide interview cards based on filter
    const interviewCards = document.querySelectorAll('.interview-card');
    const today = new Date();
    
    interviewCards.forEach(card => {
        // You can add date comparison logic here
        card.style.display = 'grid'; // Show all for now
    });
}

function saveInterview() {
    const form = document.getElementById('addEventForm');
    
    if (form.checkValidity()) {
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        console.log('Saving interview:', data);
        
        // Show loading
        Swal.fire({
            title: 'Scheduling Interview...',
            html: 'Please wait while we schedule the interview',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Simulate API call
        setTimeout(() => {
            // Here you would typically send data to server via AJAX
            // $.ajax({ url: '...', method: 'POST', data: data, ... })
            
            Swal.fire({
                title: 'Success!',
                text: 'Interview scheduled successfully!',
                icon: 'success',
                confirmButtonColor: '#667eea',
                timer: 2000
            }).then(() => {
                // Close modal and reset form
                $('#addEventModal').modal('hide');
                form.reset();
                
                // Optionally reload the interview list
                // location.reload();
            });
        }, 1000);
    } else {
        form.reportValidity();
    }
}

// Edit interview
function editInterview(id) {
    console.log('Editing interview:', id);
    
    // Sample data - Replace with actual data from your database
    const interviewData = {
        1: {
            candidate_name: 'John Doe',
            position: 'Software Engineer',
            interviewer: 'Sarah Johnson',
            interview_date: '2025-11-18',
            interview_time: '10:00',
            duration: '60',
            round: '2',
            notes: 'Technical round focusing on algorithms'
        },
        2: {
            candidate_name: 'Jane Smith',
            position: 'Product Manager',
            interviewer: 'Mike Wilson',
            interview_date: '2025-11-19',
            interview_time: '14:00',
            duration: '60',
            round: '1',
            notes: 'Initial screening'
        }
    };
    
    const data = interviewData[id];
    
    if (data) {
        // Populate form fields
        document.getElementById('edit_interview_id').value = id;
        document.getElementById('edit_candidate_name').value = data.candidate_name;
        document.getElementById('edit_position').value = data.position;
        document.getElementById('edit_interviewer').value = data.interviewer;
        document.getElementById('edit_interview_date').value = data.interview_date;
        document.getElementById('edit_interview_time').value = data.interview_time;
        document.getElementById('edit_duration').value = data.duration;
        document.getElementById('edit_round').value = data.round;
        document.getElementById('edit_notes').value = data.notes || '';
        
        // Show edit modal
        $('#editEventModal').modal('show');
    }
}

// Update interview
function updateInterview() {
    const form = document.getElementById('editEventForm');
    
    if (form.checkValidity()) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        console.log('Updating interview:', data);
        
        // Show loading
        Swal.fire({
            title: 'Updating Interview...',
            html: 'Please wait while we update the interview',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Simulate API call
        setTimeout(() => {
            // Here you would send data to server via AJAX
            
            Swal.fire({
                title: 'Updated!',
                text: 'Interview updated successfully!',
                icon: 'success',
                confirmButtonColor: '#667eea',
                timer: 2000
            }).then(() => {
                $('#editEventModal').modal('hide');
                // Reload to show updated data
                // location.reload();
            });
        }, 1000);
    } else {
        form.reportValidity();
    }
}

// Delete interview
function deleteInterview(id) {
    Swal.fire({
        title: 'Delete Interview?',
        text: 'Are you sure you want to delete this interview? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74a3b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Deleting interview:', id);
            
            // Show loading
            Swal.fire({
                title: 'Deleting...',
                html: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Simulate API call
            setTimeout(() => {
                // Here you would send delete request to server
                // $.ajax({ url: '...', method: 'DELETE', ... })
                
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Interview has been deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#667eea',
                    timer: 2000
                }).then(() => {
                    // Remove the card from DOM
                    const card = document.querySelector(`[data-interview-id="${id}"]`);
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(-20px)';
                        setTimeout(() => card.remove(), 300);
                    }
                });
            }, 1000);
        }
    });
}
</script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php $this->load->view('templates/admin_footer'); ?>