// Pipeline Page JavaScript Functions

// Search functionality
function initializeSearch() {
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const searchTerm = this.value.toLowerCase();
      const table = document.getElementById('candidateTable');
      if (table) {
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for(let row of rows) {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
      }
    });
  }
}

// Schedule Interview
function scheduleInterview(candidateId) {
  const baseUrl = document.querySelector('base')?.href || window.location.origin + '/rms/';
  
  fetch(baseUrl + 'R_dashboard/get_candidate_details/' + candidateId)
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        document.getElementById('schedule_candidate_id').value = data.candidate.cd_id;
        document.getElementById('schedule_candidate_name').value = data.candidate.cd_name;
        document.getElementById('schedule_position').value = data.candidate.cd_job_title;
        
        const modal = new bootstrap.Modal(document.getElementById('scheduleInterviewModal'));
        modal.show();
      }
    });
}

// View Interview Details
function viewInterviewDetails(candidateId) {
  const baseUrl = document.querySelector('base')?.href || window.location.origin + '/rms/';
  
  fetch(baseUrl + 'R_dashboard/get_interview_details/' + candidateId)
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        document.getElementById('view_candidate_name').textContent = data.interview.cd_name;
        document.getElementById('view_position').textContent = data.interview.cd_job_title;
        document.getElementById('view_interview_date').textContent = new Date(data.interview.ce_start_date).toLocaleDateString('en-US', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        document.getElementById('view_interview_time').textContent = new Date(data.interview.ce_start_date).toLocaleTimeString('en-US', {
          hour: '2-digit',
          minute: '2-digit'
        }) + ' - ' + new Date(data.interview.ce_end_date).toLocaleTimeString('en-US', {
          hour: '2-digit',
          minute: '2-digit'
        });
        document.getElementById('view_interviewer').textContent = data.interview.ce_interviewer;
        document.getElementById('view_round').textContent = 'Round ' + Math.round(data.interview.ce_interview_round * 4);
        
        const modal = new bootstrap.Modal(document.getElementById('viewInterviewModal'));
        modal.show();
      }
    });
}

// Reschedule Interview
function rescheduleInterview(candidateId) {
  const baseUrl = document.querySelector('base')?.href || window.location.origin + '/rms/';
  
  fetch(baseUrl + 'R_dashboard/get_interview_details/' + candidateId)
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        document.getElementById('reschedule_candidate_id').value = candidateId;
        document.getElementById('reschedule_candidate_name').value = data.interview.cd_name;
        document.getElementById('reschedule_position').value = data.interview.cd_job_title;
        
        const startDate = new Date(data.interview.ce_start_date);
        document.getElementById('reschedule_date').value = startDate.toISOString().split('T')[0];
        document.getElementById('reschedule_time').value = startDate.toTimeString().split(' ')[0].substring(0, 5) + ':00';
        
        const roundSelect = document.getElementById('reschedule_round');
        for(let option of roundSelect.options) {
          if(option.value == data.interview.ce_interview_round) {
            option.selected = true;
            break;
          }
        }
        
        const interviewerSelect = document.getElementById('reschedule_interviewer');
        for(let option of interviewerSelect.options) {
          if(option.value == data.interview.ce_interviewer) {
            option.selected = true;
            break;
          }
        }
        
        const modal = new bootstrap.Modal(document.getElementById('rescheduleInterviewModal'));
        modal.show();
      }
    });
}

// Cancel Interview
function cancelInterview(candidateId) {
  if (typeof Swal === 'undefined') {
    if (confirm('Are you sure you want to cancel this interview?')) {
      proceedWithCancellation(candidateId);
    }
    return;
  }
  
  Swal.fire({
    title: 'Cancel Interview?',
    text: "This will remove the scheduled interview and update the candidate status. This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: '<i class="fas fa-times me-2"></i>Yes, Cancel Interview',
    cancelButtonText: 'Keep Interview',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Cancelling...',
        text: 'Please wait while we cancel the interview',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      
      proceedWithCancellation(candidateId);
    }
  });
}

function proceedWithCancellation(candidateId) {
  const baseUrl = document.querySelector('base')?.href || window.location.origin + '/rms/';
  
  fetch(baseUrl + 'R_dashboard/cancel_interview', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'candidate_id=' + candidateId
  })
  .then(response => response.json())
  .then(data => {
    if(data.success) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'success',
          title: 'Interview Cancelled!',
          text: 'The interview has been successfully cancelled',
          confirmButtonColor: '#667eea',
          timer: 2000,
          timerProgressBar: true
        }).then(() => {
          location.reload();
        });
      } else {
        alert('Interview cancelled successfully');
        location.reload();
      }
    } else {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Cancellation Failed',
          text: data.message || 'Failed to cancel the interview. Please try again.',
          confirmButtonColor: '#667eea'
        });
      } else {
        alert('Failed to cancel interview: ' + (data.message || 'Unknown error'));
      }
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'An error occurred while cancelling the interview',
        confirmButtonColor: '#667eea'
      });
    } else {
      alert('Error cancelling interview');
    }
  });
}

// Edit Candidate
function editCandidate(candidateId) {
  const baseUrl = document.querySelector('base')?.href || window.location.origin + '/rms/';
  
  fetch(baseUrl + 'R_dashboard/get_candidate_details/' + candidateId)
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        document.getElementById('edit_candidate_id').value = data.candidate.cd_id;
        document.getElementById('edit_candidate_name').value = data.candidate.cd_name;
        document.getElementById('edit_candidate_email').value = data.candidate.cd_email;
        document.getElementById('edit_candidate_phone').value = data.candidate.cd_phone;
        document.getElementById('edit_job_title').value = data.candidate.cd_job_title;
        document.getElementById('edit_source').value = data.candidate.cd_source;
        document.getElementById('edit_candidate_status').value = data.candidate.cd_status;
        
        const modal = new bootstrap.Modal(document.getElementById('editCandidateModal'));
        modal.show();
      } else {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'error',
            title: 'Failed to Load',
            text: 'Could not load candidate details. Please try again.',
            confirmButtonColor: '#667eea'
          });
        } else {
          alert('Failed to load candidate details');
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while loading candidate details',
          confirmButtonColor: '#667eea'
        });
      } else {
        alert('Error loading candidate details');
      }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  initializeSearch();
  
  // Form submission confirmations
  const scheduleForm = document.getElementById('scheduleInterviewForm');
  if(scheduleForm && typeof Swal !== 'undefined') {
    scheduleForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Schedule Interview?',
        text: "This will schedule an interview with the selected candidate.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-calendar-check me-2"></i>Yes, Schedule',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Scheduling...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          scheduleForm.submit();
        }
      });
    });
  }
  
  const rescheduleForm = document.getElementById('rescheduleInterviewForm');
  if(rescheduleForm && typeof Swal !== 'undefined') {
    rescheduleForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Reschedule Interview?',
        text: "This will update the interview schedule. The previous schedule will be replaced.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-calendar-alt me-2"></i>Yes, Reschedule',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Rescheduling...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          rescheduleForm.submit();
        }
      });
    });
  }
  
  const editForm = document.getElementById('editCandidateForm');
  if(editForm && typeof Swal !== 'undefined') {
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Update Candidate?',
        text: "This will update the candidate information.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-save me-2"></i>Yes, Update',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Updating...',
            text: 'Please wait',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          editForm.submit();
        }
      });
    });
  }
});
