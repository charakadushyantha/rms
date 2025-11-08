<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Forgot Password - RMS</title>
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

    .forgot-container {
      max-width: 480px;
      width: 100%;
      background: white;
      border-radius: 20px;
      padding: 50px 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    .icon-wrapper {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 30px;
    }

    .icon-wrapper i {
      font-size: 36px;
      color: white;
    }

    .logo {
      margin-bottom: 30px;
    }

    .logo img {
      max-width: 150px;
      height: auto;
    }

    h1 {
      font-size: 28px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #666;
      margin-bottom: 30px;
      font-size: 15px;
      line-height: 1.6;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-align: left;
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
      text-align: left;
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

    input[type="email"] {
      width: 100%;
      padding: 14px 16px 14px 45px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    input[type="email"]:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .btn-reset {
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

    .btn-reset:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-reset:active {
      transform: translateY(0);
    }

    .back-link {
      text-align: center;
      margin-top: 25px;
      color: #666;
      font-size: 14px;
    }

    .back-link a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      margin-left: 5px;
    }

    .back-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .forgot-container {
        padding: 40px 30px;
      }

      h1 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="forgot-container">
    <div class="icon-wrapper">
      <i class="fas fa-key"></i>
    </div>

    <h1>Forgot Password?</h1>
    <p class="subtitle">No worries! Enter your email address and we'll send you a link to reset your password.</p>

    <?php
      if(isset($smsg)) {
        echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i>'.$smsg.'</div>';
      }
      if(isset($fmsg)) {
        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$fmsg.'</div>';
      }
      if(isset($efailed)) {
        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>'.$efailed.'</div>';
      }
    ?>

    <form action="forgot_pass_process" method="post">
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-wrapper">
          <i class="fas fa-envelope"></i>
          <input type="email" name="femail" id="email" placeholder="Enter your registered email" required>
        </div>
      </div>

      <button type="submit" class="btn-reset">
        <i class="fas fa-paper-plane"></i> Send Reset Link
      </button>
    </form>

    <div class="back-link">
      <i class="fas fa-arrow-left"></i> Remember your password?<a href="<?php echo LOGIN_URL; ?>">Back to Login</a>
    </div>
  </div>
</body>
</html>
