<?php
$data['page_title'] = 'My Interview Schedule';
$data['use_calendar'] = true;
$this->load->view('templates/interviewer_header', $data);
?>

<style>
.schedule-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.calendar-wrapper {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.calendar-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.calendar-actions {
    display: flex;
    gap: 1rem;
}

.view-switcher {
    display: flex;
    gap: 0.25rem;
    background: #f3f4f6;
    padding: 0.375rem;
    border-radius: 10px;
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
    transition: all 0.2s;
}

.view-btn:hover {
    background: white;
    color: #667eea;
}

.view-btn.active {
    background: white;
    color: #667eea;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Calendar Event Styling */
.fc-event {
    border-radius: 6px !important;
    padding: 4px 8px !important;
    border: none !important;
    cursor: pointer !important;
}

.interview-pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    color: #78350f !important;
    border-left: 4px solid #d97706 !important;
}

.interview-accepted {
    background: linear-gradient(135deg, #34d399 0%, #10b981 100%) !important;
    color: #065f46 !important;
    border-left: 4px solid #059669 !important;
}

.interview-completed {
    background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%) !important;
    color: #1e3a8a !important;
    border-left: 4px solid #2563eb !important;
}

.interview-declined {
    background: linear-gradient(135deg, #f87171 0%, #ef4444 100%) !important;
    color: #7f1d1d !important;
    border-left: 4px solid #dc2626 !important;
    opacity: 0.7 !important;
}

/* Legend */
.calendar-legend {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}

/* Candidate Details Modal */
.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px 16px 0 0;
}

.detail-section {
    margin-bottom: 1.5rem;
}

.detail-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.detail-value {
    font-size: 1rem;
    color: #1f2937;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-accept {
    background: #10b981;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.btn-decline {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.btn-feedback {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>

<div class="schedule-container">
    <div class="calendar-wrapper">
        <div class="calendar-header">
            <h1 class="calendar-title">
                <i class="fas fa-calendar-alt me-2"></i>My Interview Schedule
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
            </div>
        </div>

        <!-- Legend -->
        <div class="calendar-legend">
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);"></div>
                <span>Pending</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);"></div>
                <span>Accepted</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);"></div>
                <span>Completed</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);"></div>
                <span>Declined</span>
            </div>
        </div>

        <!-- Calendar -->
        <div id="calendar"></div>
    </div>
</div>

<!-- Interview Details Modal -->
<div class="modal fade" id="interviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie me-2"></i>Interview Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-label">Candidate Name</div>
                            <div class="detail-value" id="candidateName">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-label">Position</div>
                            <div class="detail-value" id="candidatePosition">-</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-label">Email</div>
                            <div class="detail-value" id="candidateEmail">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-section">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value" id="candidatePhone">-</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-label">Interview Date & Time</div>
                    <div class="detail-value" id="interviewDateTime">-</div>
                </div>

                <div class="detail-section">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="badge" id="interviewStatus">-</span>
                    </div>
                </div>

                <div class="detail-section" id="resumeSection" style="display: none;">
                    <div class="detail-label">Resume</div>
                    <button class="btn btn-sm btn-primary" id="downloadResume">
                        <i class="fas fa-download me-2"></i>Download Resume
                    </button>
                </div>

                <div class="action-buttons" id="actionButtons">
                    <!-- Buttons will be added dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$custom_script = "
let calendar;
let currentInterview = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
    initializeViewSwitcher();
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
        events: function(info, successCallback, failureCallback) {
            fetch('" . base_url('I_dashboard/get_events') . "')
                .then(response => response.json())
                .then(data => {
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Error loading events:', error);
                    failureCallback(error);
                });
        },
        eventClick: function(info) {
            showInterviewDetails(info.event);
        }
    });
    
    calendar.render();
}

function initializeViewSwitcher() {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
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

function showInterviewDetails(event) {
    currentInterview = event;
    
    // Fetch full candidate details
    fetch('" . base_url('I_dashboard/get_candidate_details') . "', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'candidate_id=' + event.extendedProps.candidate_id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const candidate = data.candidate;
            
            document.getElementById('candidateName').textContent = candidate.Can_name || '-';
            document.getElementById('candidatePosition').textContent = candidate.Can_position || '-';
            document.getElementById('candidateEmail').textContent = candidate.Can_email || '-';
            document.getElementById('candidatePhone').textContent = candidate.Can_phone || '-';
            document.getElementById('interviewDateTime').textContent = formatDateTime(event.start);
            
            const statusBadge = document.getElementById('interviewStatus');
            statusBadge.textContent = event.extendedProps.status.toUpperCase();
            statusBadge.className = 'badge bg-' + getStatusColor(event.extendedProps.status);
            
            // Show action buttons based on status
            updateActionButtons(event.extendedProps.status, event.id);
            
            const modal = new bootstrap.Modal(document.getElementById('interviewModal'));
            modal.show();
        }
    });
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'accepted': 'success',
        'completed': 'info',
        'declined': 'danger'
    };
    return colors[status] || 'secondary';
}

function updateActionButtons(status, interviewId) {
    const buttonsDiv = document.getElementById('actionButtons');
    buttonsDiv.innerHTML = '';
    
    if (status === 'pending') {
        buttonsDiv.innerHTML = `
            <button class=\"btn-accept\" onclick=\"respondToInterview(${interviewId}, 'accepted')\">
                <i class=\"fas fa-check me-2\"></i>Accept
            </button>
            <button class=\"btn-decline\" onclick=\"respondToInterview(${interviewId}, 'declined')\">
                <i class=\"fas fa-times me-2\"></i>Decline
            </button>
        `;
    } else if (status === 'accepted' || status === 'completed') {
        buttonsDiv.innerHTML = `
            <a href=\"" . base_url('I_dashboard/feedback/') . "${interviewId}\" class=\"btn-feedback\">
                <i class=\"fas fa-clipboard-list me-2\"></i>Submit Feedback
            </a>
        `;
    }
}

function respondToInterview(interviewId, status) {
    Swal.fire({
        title: status === 'accepted' ? 'Accept Interview?' : 'Decline Interview?',
        text: 'Are you sure you want to ' + status + ' this interview?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + status,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('" . base_url('I_dashboard/respond_to_assignment') . "', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'assignment_id=' + interviewId + '&status=' + status
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Interview ' + status + ' successfully',
                        timer: 2000
                    }).then(() => {
                        calendar.refetchEvents();
                        bootstrap.Modal.getInstance(document.getElementById('interviewModal')).hide();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update status'
                    });
                }
            });
        }
    });
}

function formatDateTime(date) {
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleString('en-US', options);
}
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/interviewer_footer', $data);
?>
