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
    /* [Modern styling moved here in original request] */
    [INSERT UPDATED CSS HERE AS PER USER'S MODERN UI]
  </style>
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0 forgot-container">
      <!-- Forgot Password Form Section -->
      <div class="col-lg-4 forgot-form-container">
        <div class="logo-container text-center">
          <img class="img-fluid mb-3" src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo" style="max-height: 60px;">
          <img class="img-fluid" src="<?php echo COMPANY_NAME; ?>" alt="Company Name" style="max-width: 200px;">
        </div>
        <div class="forgot-text">
          <h3>Forgot Password?</h3>
          <p>Don't worry! Enter your email address and we'll send you a link to reset your password.</p>
        </div>

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

          <div class="email-sent-box" id="email-sent-box">
            <i class="fas fa-paper-plane"></i>
            <span>Email sent! Please check your inbox for the password reset link.</span>
          </div>

          <button type="submit" class="btn btn-primary btn-forgot w-100 mt-3" id="submit-btn">
            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
          </button>
        </form>

        <div class="login-link">
          <i class="fas fa-arrow-left me-1"></i> Remember your password? <a href="<?php echo site_url('Login'); ?>">Back to Sign in</a>
        </div>
      </div>

      <!-- Feature Section -->
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#forgot-form').on('submit', function (e) {
        const email = $('#email').val();
        if (!email || !isValidEmail(email)) {
          e.preventDefault();
          showError('Please enter a valid email address');
          return false;
        }
      });

      function showError(message) {
        $('.alert').remove();
        const alertHtml = '<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle me-2"></i>' + message + '</div>';
        $(alertHtml).insertBefore('#forgot-form');
        setTimeout(function () {
          $('.alert').fadeOut('slow');
        }, 5000);
      }

      function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }

      $("#email").focusin(function () {
        $(this).attr('placeholder', '');
      }).focusout(function () {
        $(this).attr('placeholder', 'Enter your registered email');
      });

      setTimeout(function () {
        $('.alert').fadeOut('slow');
      }, 5000);

      <?php 
      if ($this->session->tempdata('error')) $this->session->unset_tempdata('error'); 
      if ($this->session->tempdata('success')) $this->session->unset_tempdata('success');
      ?>
    });
  </script>
</body>

</html>
