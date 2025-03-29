<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Forgot Password</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/2f33c29c83.js"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background-color: #f8f9fa;
      overflow-x: hidden;
    }
    
    .forgot-container {
      height: 100vh;
      display: flex;
      align-items: stretch;
    }
    
    .forgot-form-container {
      background-color: white;
      border-radius: 20px 0 0 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .form-control {
      border-radius: 10px;
      padding: 12px 20px;
      border: 1px solid #e1e1e1;
      background-color: #f8f9fa;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: #0095e8;
      box-shadow: 0 0 0 0.2rem rgba(0, 149, 232, 0.25);
      background-color: white;
    }
    
    .btn-forgot {
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      background-color: #0095e8;
      border: none;
    }
    
    .btn-forgot:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 149, 232, 0.4);
    }
    
    .logo-container {
      margin-bottom: 2rem;
    }
    
    .forgot-text {
      margin-bottom: 2rem;
    }
    
    .forgot-text h3 {
      font-weight: 600;
      color: #212529;
    }
    
    .forgot-text p {
      color: #6c757d;
    }
    
    .login-link {
      text-align: center;
      margin-top: 2rem;
      color: #6c757d;
    }
    
    .login-link a {
      color: #0095e8;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .login-link a:hover {
      text-decoration: underline;
    }
    
    .alert {
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }
    
    /* Feature side styling */
    .feature-slider {
      background-color: #0095e8;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0 20px 20px 0;
      overflow: hidden;
      position: relative;
    }
    
    .feature-content {
      padding: 3rem;
      text-align: center;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    
    .feature-image {
      max-width: 70%;
      margin-bottom: 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .feature-text h3 {
      color: white;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    
    .feature-text p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.1rem;
    }
    
    /* Email sent indicator */
    .email-sent-box {
      background-color: #f8f9fa;
      border-left: 4px solid #0095e8;
      border-radius: 5px;
      padding: 1rem;
      margin-top: 1rem;
      display: none;
    }
    
    .email-sent-box i {
      color: #0095e8;
      font-size: 1.2rem;
      margin-right: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      .feature-slider {
        display: none;
      }
      
      .forgot-form-container {
        border-radius: 20px;
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0 forgot-container">
      <!-- Forgot Password Form Section (Left side) -->
      <div class="col-lg-4 forgot-form-container">
        <!-- Logo Container -->
        <div class="logo-container text-center">
          <img class="img-fluid mb-3" src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo" style="max-height: 60px;">
          <img class="img-fluid" src="<?php echo COMPANY_NAME; ?>" alt="Company Name" style="max-width: 200px;">
        </div>

        <!-- Forgot Password Text -->
        <div class="forgot-text">
          <h3>Forgot Password?</h3>
          <p>Don't worry! Enter your email address and we'll send you a link to reset your password.</p>
        </div>

        <!-- Alert Messages -->
        <?php if ($this->session->tempdata('error')): ?>
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo $this->session->tempdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->tempdata('success')): ?>
          <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo $this->session->tempdata('success'); ?>
          </div>
        <?php endif; ?>

        <?php if (isset($error) && !empty($error)): ?>
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <!-- Forgot Password Form -->
        <form method="post" action="<?php echo site_url('Password/forgotpassword_proc'); ?>" id="forgot-form">
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-envelope text-muted"></i>
              </span>
              <input type="email" name="email" id="email" class="form-control border-start-0" placeholder="Enter your registered email">
            </div>
          </div>
          
          <!-- Email Sent Notification (initially hidden) -->
          <div class="email-sent-box" id="email-sent-box">
            <i class="fas fa-paper-plane"></i>
            <span>Email sent! Please check your inbox for the password reset link.</span>
          </div>
          
          <button type="submit" class="btn btn-primary btn-forgot w-100 mt-3" id="submit-btn">
            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
          </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
          <i class="fas fa-arrow-left me-1"></i> Remember your password? <a href="<?php echo site_url('Login'); ?>">Back to Sign in</a>
        </div>
      </div>
      
      <!-- Features Section (Right side) -->
      <div class="col-lg-8 feature-slider">
        <div class="feature-content" style="background-color: #7288E0;">
          <img src="<?php echo SIGN_LOGIN_ASSETS_PATH; ?>/Image/forgot_password.png" class="feature-image" alt="Forgot Password">
          <div class="feature-text">
            <h3>Password Recovery</h3>
            <p>We'll email you instructions on how to reset your password securely.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script type="text/javascript">
    $(document).ready(function() {
      // Form submission with AJAX
      $('#forgot-form').on('submit', function(e) {
        const email = $('#email').val();
        
        // Basic email validation
        if (!email || !isValidEmail(email)) {
          e.preventDefault();
          showError('Please enter a valid email address');
          return false;
        }
        
        // If not using AJAX, comment out the below block
        /*
        e.preventDefault();
        
        // Show loading state
        $('#submit-btn').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...').prop('disabled', true);
        
        // Simulate API call
        setTimeout(function() {
          // Hide any existing alerts
          $('.alert').fadeOut();
          
          // Show success message
          $('#email-sent-box').fadeIn();
          
          // Reset button
          $('#submit-btn').html('<i class="fas fa-paper-plane me-2"></i>Send Reset Link').prop('disabled', false);
          
          // Clear the form
          $('#email').val('');
        }, 1500);
        */
      });
      
      // Show error message
      function showError(message) {
        // Remove any existing alerts
        $('.alert').remove();
        
        // Create and show the new alert
        const alertHtml = '<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle me-2"></i>' + message + '</div>';
        $(alertHtml).insertBefore('#forgot-form');
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
          $('.alert').fadeOut('slow');
        }, 5000);
      }
      
      // Email validation helper
      function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }
      
      // Setup input placeholder behavior
      $("#email").focusin(function() {
        $(this).attr('placeholder', '');
      });

      $("#email").focusout(function() {
        $(this).attr('placeholder', 'Enter your registered email');
      });
      
      // Auto-hide messages after 5 seconds
      setTimeout(function() {
        $('.alert').fadeOut('slow');
      }, 5000);
      
      // Mark session tempdata as read once displayed to prevent persisting
      <?php 
      if ($this->session->tempdata('error')) $this->session->unset_tempdata('error'); 
      if ($this->session->tempdata('success')) $this->session->unset_tempdata('success');
      ?>
    });
  </script>
</body>

</html>