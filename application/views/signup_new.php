<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Sign Up - RMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .signup-container {
      display: flex;
      max-width: 1000px;
      width: 100%;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .signup-left {
      flex: 1;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .signup-left::before {
      content: '';
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -100px;
      left: -100px;
    }

    .signup-left::after {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      bottom: -50px;
      right: -50px;
    }

    .signup-right {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo {
      margin-bottom: 40px;
    }

    .logo img {
      max-width: 150px;
      height: auto;
    }

    h1 {
      font-size: 32px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #666;
      margin-bottom: 40px;
      font-size: 15px;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-danger {
      background: #fee;
      color: #c33;
      border: 1px solid #fcc;
    }

    .alert-info {
      background: #e7f3ff;
      color: #0066cc;
      border: 1px solid #b3d9ff;
    }

    .alert-success {
      background: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #a5d6a7;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 500;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper i {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      font-size: 16px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 14px 16px 14px 45px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    select {
      cursor: pointer;
      background: white;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      padding-right: 40px;
    }

    .btn-signup {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 10px;
    }

    .btn-signup:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-signup:active {
      transform: translateY(0);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 25px 0;
      color: #999;
      font-size: 14px;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e0e0e0;
    }

    .divider span {
      padding: 0 15px;
    }

    .btn-google {
      width: 100%;
      padding: 14px;
      background: white;
      color: #333;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.3s;
    }

    .btn-google:hover {
      border-color: #667eea;
      background: #f8f9ff;
    }

    .btn-google i {
      font-size: 18px;
      color: #ea4335;
    }

    .login-link {
      text-align: center;
      margin-top: 25px;
      color: #666;
      font-size: 14px;
    }

    .login-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      margin-left: 5px;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .feature-list {
      list-style: none;
      margin-top: 40px;
      position: relative;
      z-index: 1;
    }

    .feature-list li {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
      font-size: 16px;
    }

    .feature-list i {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .left-title {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
      color: white;
    }

    .left-subtitle {
      font-size: 16px;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    @media (max-width: 768px) {
      .signup-container {
        flex-direction: column;
      }

      .signup-left {
        display: none;
      }

      .signup-right {
        padding: 40px 30px;
      }

      h1 {
        font-size: 26px;
      }
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <!-- Left Side - Features -->
    <div class="signup-left">
      <h2 class="left-title">Join Our Platform</h2>
      <p class="left-subtitle">Start managing your recruitment process efficiently</p>
      
      <ul class="feature-list">
        <li>
          <i class="fas fa-check-circle"></i>
          <span>Free account activation</span>
        </li>
        <li>
          <i class="fas fa-users"></i>
          <span>Unlimited candidate management</span>
        </li>
        <li>
          <i class="fas fa-calendar-alt"></i>
          <span>Smart interview scheduling</span>
        </li>
        <li>
          <i class="fas fa-lock"></i>
          <span>Secure and private data</span>
        </li>
      </ul>
    </div>

    <!-- Right Side - Signup Form -->
    <div class="signup-right">
      <div class="logo">
        <img src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo">
      </div>

      <h1>Create Account</h1>
      <p class="subtitle">Fill in your details to get started</p>

      <?php
        if($this->session->flashdata('success_msg')) {
          echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i>'.$this->session->flashdata('success_msg').'</div>';
        }
        if($this->session->flashdata('emailusername')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('emailusername').'</div>';
        }
        if($this->session->flashdata('mail_failed_msg')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('mail_failed_msg').'</div>';
        }
        if($this->session->flashdata('rec_failed_msg')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('rec_failed_msg').'</div>';
        }
      ?>

      <form method="post" action="signupproc">
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-wrapper">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Choose a username" required>
          </div>
          <?php
            if($this->session->flashdata('useralready')) {
              echo '<div class="alert alert-danger" style="margin-top: 10px;"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('useralready').'</div>';
            }
          ?>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" name="useremail" id="email" placeholder="Enter your email" required>
          </div>
          <?php
            if($this->session->flashdata('emailalready')) {
              echo '<div class="alert alert-danger" style="margin-top: 10px;"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('emailalready').'</div>';
            }
          ?>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="userpass" id="password" placeholder="Create a strong password" required>
          </div>
        </div>

        <?php if (isset($signup_settings)): ?>
        <div class="form-group">
          <label for="role">I am a</label>
          <div class="input-wrapper">
            <i class="fas fa-user-tag"></i>
            <select name="role" id="role" style="width: 100%; padding: 14px 16px 14px 45px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; font-family: 'Inter', sans-serif; background: white; cursor: pointer;">
              <?php if ($signup_settings->recruiter_signup_enabled): ?>
              <option value="Recruiter" <?php echo ($signup_settings->default_signup_role == 'Recruiter') ? 'selected' : ''; ?>>Recruiter</option>
              <?php endif; ?>
              <?php if ($signup_settings->candidate_signup_enabled): ?>
              <option value="Candidate" <?php echo ($signup_settings->default_signup_role == 'Candidate') ? 'selected' : ''; ?>>Candidate</option>
              <?php endif; ?>
              <?php if ($signup_settings->interviewer_signup_enabled): ?>
              <option value="Interviewer" <?php echo ($signup_settings->default_signup_role == 'Interviewer') ? 'selected' : ''; ?>>Interviewer</option>
              <?php endif; ?>
              <?php if ($signup_settings->admin_signup_enabled): ?>
              <option value="Admin" <?php echo ($signup_settings->default_signup_role == 'Admin') ? 'selected' : ''; ?>>Administrator</option>
              <?php endif; ?>
            </select>
          </div>
          <small style="color: #666; font-size: 12px; margin-top: 5px; display: block;">
            <?php 
            // Show approval message based on role
            if (isset($signup_settings)) {
              echo '<i class="fas fa-info-circle"></i> ';
              if ($signup_settings->auto_approve_recruiter && $signup_settings->recruiter_signup_enabled) {
                echo 'Recruiter accounts are activated immediately.';
              } elseif ($signup_settings->auto_approve_candidate && $signup_settings->candidate_signup_enabled) {
                echo 'Candidate accounts are activated immediately.';
              } else {
                echo 'Your account will be reviewed by an administrator.';
              }
            }
            ?>
          </small>
        </div>
        <?php endif; ?>

        <button type="submit" class="btn-signup">
          <i class="fas fa-user-plus"></i> Create Account
        </button>
      </form>

      <div class="divider">
        <span>or</span>
      </div>

      <button class="btn-google" onclick="alert('Google signup not configured yet')">
        <i class="fab fa-google"></i>
        Sign up with Google
      </button>

      <div class="login-link">
        Already have an account?<a href="<?php echo LOGIN_URL; ?>">Sign in</a>
      </div>
    </div>
  </div>
</body>
</html>
