/**
 * Enhanced Login Script
 * JavaScript functionality for the modern RMS login page
 */

$(document).ready(function() {
  // Initialize components
  initFormBehavior();
  initThemeToggle();
  initGoogleLogin();
  initAlertHandling();
  clearSessionMessages();
});

/**
 * Initialize form field behaviors
 */
function initFormBehavior() {
  // Username placeholder behavior
  $("#userid").focusin(function() {
    $(this).attr('placeholder', '');
  });

  $("#userid").focusout(function() {
    $(this).attr('placeholder', 'Enter your username');
  });

  // Password placeholder behavior
  $("#userpass").focusin(function() {
    $(this).attr('placeholder', '');
  });

  $("#userpass").focusout(function() {
    $(this).attr('placeholder', 'Enter your password');
  });
  
  // Form validation enhancement
  $("#login-form").on('submit', function(e) {
    const username = $("#userid").val().trim();
    const password = $("#userpass").val().trim();
    
    // Simple client-side validation
    if (username === '' || password === '') {
      e.preventDefault();
      showTemporaryAlert('Please enter both username and password', 'danger');
      return false;
    }
    
    return true;
  });
}

/**
 * Initialize theme toggle functionality
 */
function initThemeToggle() {
  const themeToggle = document.getElementById('theme-toggle');
  const htmlElement = document.documentElement;
  
  // Check for saved theme preference
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    htmlElement.setAttribute('data-theme', 'dark');
    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
  }
  
  // Theme toggle click handler
  themeToggle.addEventListener('click', function() {
    if (htmlElement.getAttribute('data-theme') === 'dark') {
      htmlElement.removeAttribute('data-theme');
      localStorage.setItem('theme', 'light');
      themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    } else {
      htmlElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark');
      themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
  });
}

/**
 * Initialize Google login
 */
function initGoogleLogin() {
  // Make Google login button OAuth ready
  $('.btn-google').attr('href', site_url + 'OAuth/googleLogin');
}

/**
 * Initialize alert message handling
 */
function initAlertHandling() {
  // Auto-hide existing alerts after 5 seconds
  if ($('.alert').length > 0) {
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
  }
}

/**
 * Show a temporary alert message
 * @param {string} message - The message to display
 * @param {string} type - The alert type (success, info, danger)
 */
function showTemporaryAlert(message, type = 'info') {
  // Remove any existing temporary alerts
  $('.temp-alert').remove();
  
  // Create new alert
  const alertHtml = `<div class="alert alert-${type} temp-alert" role="alert">${message}</div>`;
  
  // Insert after welcome text and before form
  $('.welcome-text').after(alertHtml);
  
  // Auto-hide after 5 seconds
  setTimeout(function() {
    $('.temp-alert').fadeOut('slow', function() {
      $(this).remove();
    });
  }, 5000);
}

/**
 * Clear session messages to prevent duplication
 */
function clearSessionMessages() {
  // This function is empty as the PHP code handles unsetting the session data
  // It's included here for organizational purposes
}