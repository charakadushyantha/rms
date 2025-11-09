<?php
$data['page_title'] = 'My Interviews';
$data['use_calendar'] = true;
$this->load->view('templates/candidate_header', $data);
?>

<style>
.interviews-container {
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

.interview-pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    color: #78350f !important;
}

.interview-confirmed {
    background: linear-gradient(135deg, #34d399 0%, #10b981 100%) !important;
    color: #065f46 !important;
}

.interview-declined {
    background: linear-gradient(135deg, #f87171 0%, #ef4444 100%) !important;
    color: #7f1d1d !important;
}
</style>

<div class="interviews-container">
    <div class="calendar-wrapper">
        <div class="calendar-header">
            <h1 class="calendar-title">
                <i class="fas fa-calendar-alt me-2"></i>My Interview Schedule
            </h1>
        </div>

        <div class="calendar-legend">
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);"></div>
                <span>Pending Confirmation</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%);"></div>
                <span>Confirmed</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);"></div>
                <span>Declined</span>
            </div>
        </div>

        <div id="calendar"></div>
    </div>
</div>

<?php
$custom_script = "
let calendar;

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: 'auto',
        events: function(info, successCallback, failureCallback) {
            fetch('" . base_url('C_dashboard/get_interview_events') . "')
                .then(response => response.json())
                .then(data => {
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    failureCallback(error);
                });
        },
        eventClick: function(info) {
            Swal.fire({
                title: info.event.title,
                html: '<p><strong>Date:</strong> ' + info.event.start.toLocaleString() + '</p>' +
                      '<p><strong>Status:</strong> ' + info.event.extendedProps.status + '</p>',
                showCancelButton: true,
                confirmButtonText: 'Confirm Attendance',
                cancelButtonText: 'Close',
                showDenyButton: true,
                denyButtonText: 'Decline'
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmInterview(info.event.extendedProps.interview_id, 'confirmed');
                } else if (result.isDenied) {
                    confirmInterview(info.event.extendedProps.interview_id, 'declined');
                }
            });
        }
    });
    
    calendar.render();
});

function confirmInterview(interviewId, status) {
    fetch('" . base_url('C_dashboard/confirm_interview') . "', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'interview_id=' + interviewId + '&status=' + status
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000
            }).then(() => {
                calendar.refetchEvents();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    });
}
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
