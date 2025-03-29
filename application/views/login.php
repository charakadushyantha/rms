<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Login</title>
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
    
    .login-container {
      height: 100vh;
      display: flex;
      align-items: stretch;
    }
    
    .login-form-container {
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
    
    .btn-login {
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      background-color: #0095e8;
      border: none;
    }
    
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 149, 232, 0.4);
    }
    
    .btn-google {
      border-radius: 50px;
      background-color: white;
      color: #DB4437;
      border: 1px solid #DB4437;
      padding: 10px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-block;
      text-decoration: none;
      text-align: center;
      width: 100%;
    }
    
    .btn-google:hover {
      background-color: #DB4437;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(219, 68, 55, 0.3);
    }
    
    .or-divider {
      display: flex;
      align-items: center;
      color: #6c757d;
      margin: 1.5rem 0;
    }
    
    .or-divider::before,
    .or-divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #e1e1e1;
    }
    
    .or-divider::before {
      margin-right: 1rem;
    }
    
    .or-divider::after {
      margin-left: 1rem;
    }
    
    .logo-container {
      margin-bottom: 2rem;
    }
    
    .welcome-text {
      margin-bottom: 2rem;
    }
    
    .welcome-text h3 {
      font-weight: 600;
      color: #212529;
    }
    
    .welcome-text p {
      color: #6c757d;
    }
    
    .forgot-password {
      text-align: right;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }
    
    .forgot-password a {
      color: #0095e8;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .forgot-password a:hover {
      text-decoration: underline;
    }
    
    .signup-link {
      text-align: center;
      margin-top: 2rem;
      color: #6c757d;
    }
    
    .signup-link a {
      color: #0095e8;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .signup-link a:hover {
      text-decoration: underline;
    }
    
    /* Carousel/Feature side styling */
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
    
    .carousel-item {
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
      transition: all 0.5s ease;
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
    
    .carousel-indicators {
      bottom: 20px;
    }
    
    .carousel-indicators button {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background-color: rgba(255, 255, 255, 0.5);
      margin: 0 5px;
    }
    
    .carousel-indicators .active {
      background-color: white;
    }
    
    .alert {
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      .feature-slider {
        display: none;
      }
      
      .login-form-container {
        border-radius: 20px;
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0 login-container">
      <!-- Login Form Section (Left side) -->
      <div class="col-lg-4 login-form-container">
        <!-- Logo Container -->
        <div class="logo-container text-center">
          <img class="img-fluid mb-3" src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo" style="max-height: 60px;">
          <img class="img-fluid" src="<?php echo COMPANY_NAME; ?>" alt="Company Name" style="max-width: 200px;">
        </div>

        <!-- Welcome Text - Will be updated by JS with correct time -->
        <div class="welcome-text">
          <h3 id="welcomeGreeting">Welcome...</h3>
          <p>Enter your details below here</p>
        </div>

        <!-- Alert Messages using tempdata to prevent persistence after refresh -->
        <?php if ($this->session->tempdata('msgad')): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $this->session->tempdata('msgad'); ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->tempdata('msgup')): ?>
          <div class="alert alert-info" role="alert">
            <?php echo $this->session->tempdata('msgup'); ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->tempdata('msgpw')): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $this->session->tempdata('msgpw'); ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->tempdata('msgupw')): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $this->session->tempdata('msgupw'); ?>
          </div>
        <?php endif; ?>

        <?php if (isset($error) && !empty($error)): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" action="Login/loginproc">
          <div class="mb-3">
            <input type="text" name="username" id="userid" class="form-control" placeholder="Username">
          </div>
          <div class="mb-3">
            <input type="password" name="userpass" id="userpass" class="form-control" placeholder="Password">
          </div>
          <div class="forgot-password">
            <a href="<?php echo FORGOT_PASSWORD_URL; ?>">Forgot password?</a>
          </div>
          <button type="submit" class="btn btn-primary btn-login w-100">Sign In</button>
        </form>

        <!-- OR Divider -->
        <div class="or-divider">or</div>

        <!-- Google Login Button -->
        <a href="<?php echo site_url('OAuth/googleLogin'); ?>" class="btn btn-google">
          <i class="fab fa-google me-2"></i>
          Sign in with Google
        </a>

        <!-- Sign Up Link -->
        <div class="signup-link">
          Don't have an account? <a href="<?php echo SIGNUP_URL; ?>">Sign up</a>
        </div>
      </div>
      
      <!-- Features Slider Section (Right side) -->
      <div class="col-lg-8 feature-slider">
        <div id="featureCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="3"></button>
          </div>
          <div class="carousel-inner">
            <!-- Feature 1 -->
            <div class="carousel-item active" style="background-color: #7288E0;">
              <img src="<?php echo SIGN_LOGIN_ASSETS_PATH; ?>/Image/Image1.png" class="feature-image" alt="Candidate Handling">
              <div class="feature-text">
                <h3>Candidate Handling</h3>
                <p>Simple and smart way to handle all the candidates through this application.</p>
              </div>
            </div>
            <!-- Feature 2 -->
            <div class="carousel-item" style="background-color: #F57E82;">
              <img src="<?php echo SIGN_LOGIN_ASSETS_PATH; ?>/Image/Image2.png" class="feature-image" alt="Interview Scheduling">
              <div class="feature-text">
                <h3>Interview Scheduling</h3>
                <p>Easy to make a schedule for particular candidates using a simple form.</p>
              </div>
            </div>
            <!-- Feature 3 -->
            <div class="carousel-item" style="background-color: #72DDE0;">
              <img src="<?php echo SIGN_LOGIN_ASSETS_PATH; ?>/Image/Image3.png" class="feature-image" alt="Calendar View">
              <div class="feature-text">
                <h3>Calendar View</h3>
                <p>Get or update all candidate's interview schedules in the form of a calendar.</p>
              </div>
            </div>
            <!-- Feature 4 -->
            <div class="carousel-item" style="background-color: #4a89dc;">
              <img src="<?php echo SIGN_LOGIN_ASSETS_PATH; ?>/Image/Image4.png" class="feature-image" alt="Select Recruiter">
              <div class="feature-text">
                <h3>Select Recruiter</h3>
                <p>Admin is authorized to choose a recruiter for the recruitment process.</p>
              </div>
            </div>
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
      // Set greeting based on client's local time
      function setGreeting() {
        const hour = new Date().getHours();
        let greeting = '';
        
        if (hour >= 5 && hour < 12) {
          greeting = 'Good Morning!';
        } else if (hour >= 12 && hour < 18) {
          greeting = 'Good Afternoon!';
        } else {
          greeting = 'Good Evening!';
        }
        
        document.getElementById('welcomeGreeting').textContent = greeting + ' Welcome Back';
      }
      
      // Call immediately to set greeting
      setGreeting();
      
      // Setup input placeholder behavior
      $("#userid").focusin(function() {
        $(this).attr('placeholder', '');
      });

      $("#userid").focusout(function() {
        $(this).attr('placeholder', 'Username');
      });

      $("#userpass").focusin(function() {
        $(this).attr('placeholder', '');
      });

      $("#userpass").focusout(function() {
        $(this).attr('placeholder', 'Password');
      });
      
      // Auto-hide messages after 5 seconds
      setTimeout(function() {
        $('.alert').fadeOut('slow');
      }, 5000);
      
      // Mark session tempdata as read once displayed to prevent persisting
      <?php 
      if ($this->session->tempdata('msgad')) $this->session->unset_tempdata('msgad'); 
      if ($this->session->tempdata('msgup')) $this->session->unset_tempdata('msgup');
      if ($this->session->tempdata('msgpw')) $this->session->unset_tempdata('msgpw');
      if ($this->session->tempdata('msgupw')) $this->session->unset_tempdata('msgupw');
      ?>
    });
  </script>
</body>

</html>