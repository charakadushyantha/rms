<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Login - RMS</title>
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

    .login-container {
      display: flex;
      max-width: 1000px;
      width: 100%;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .login-left {
      flex: 1;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-right {
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

    .login-right::before {
      content: '';
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -100px;
      right: -100px;
    }

    .login-right::after {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      bottom: -50px;
      left: -50px;
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
      margin-bottom: 24px;
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
    input[type="password"] {
      width: 100%;
      padding: 14px 16px 14px 45px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .forgot-password {
      text-align: right;
      margin-top: -16px;
      margin-bottom: 24px;
    }

    .forgot-password a {
      color: #667eea;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.3s;
    }

    .forgot-password a:hover {
      color: #764ba2;
    }

    .btn-login {
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
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 30px 0;
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

    .signup-link {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 14px;
    }

    .signup-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      margin-left: 5px;
    }

    .signup-link a:hover {
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

    .right-title {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .right-subtitle {
      font-size: 16px;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
      }

      .login-right {
        display: none;
      }

      .login-left {
        padding: 40px 30px;
      }

      h1 {
        font-size: 26px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- Left Side - Login Form -->
    <div class="login-left">
      <div class="logo">
        <img src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo">
      </div>

      <h1>Welcome Back</h1>
      <p class="subtitle">Please enter your credentials to continue</p>

      <?php
        if($this->session->flashdata('msgad')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('msgad').'</div>';
        }
        if($this->session->flashdata('msgup')) {
          echo '<div class="alert alert-info"><i class="fas fa-info-circle"></i>'.$this->session->flashdata('msgup').'</div>';
        }
        if($this->session->flashdata('msgpw')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('msgpw').'</div>';
        }
        if($this->session->flashdata('msgupw')) {
          echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$this->session->flashdata('msgupw').'</div>';
        }
      ?>

      <form method="post" action="<?php echo base_url('Login/loginproc'); ?>">
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-wrapper">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="userpass" id="password" placeholder="Enter your password" required>
          </div>
        </div>

        <div class="forgot-password">
          <a href="<?php echo FORGOT_PASSWORD_URL; ?>">Forgot password?</a>
        </div>

        <button type="submit" class="btn-login">
          <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
      </form>

      <div class="divider">
        <span>or</span>
      </div>

      <button class="btn-google" onclick="alert('Google login not configured yet')">
        <i class="fab fa-google"></i>
        Continue with Google
      </button>

      <div class="signup-link">
        Don't have an account?<a href="<?php echo SIGNUP_URL; ?>">Sign up now</a>
      </div>
    </div>

    <!-- Right Side - Features -->
    <div class="login-right">
      <h2 class="right-title">Recruitment Made Simple</h2>
      <p class="right-subtitle">Streamline your hiring process with our powerful tools</p>
      
      <ul class="feature-list">
        <li>
          <i class="fas fa-users"></i>
          <span>Manage candidates efficiently</span>
        </li>
        <li>
          <i class="fas fa-calendar-check"></i>
          <span>Schedule interviews seamlessly</span>
        </li>
        <li>
          <i class="fas fa-chart-line"></i>
          <span>Track recruitment progress</span>
        </li>
        <li>
          <i class="fas fa-shield-alt"></i>
          <span>Secure and reliable platform</span>
        </li>
      </ul>
    </div>
  </div>
</body>
</html>
