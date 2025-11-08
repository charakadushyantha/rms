<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Email Sent - RMS</title>
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
      animation: gradientShift 10s ease infinite;
      background-size: 200% 200%;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .success-container {
      max-width: 550px;
      width: 100%;
      background: white;
      border-radius: 24px;
      padding: 60px 50px;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
      text-align: center;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .success-icon {
      width: 100px;
      height: 100px;
      background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 35px;
      animation: scaleIn 0.5s ease-out 0.2s both;
      position: relative;
    }

    @keyframes scaleIn {
      from {
        transform: scale(0);
      }
      to {
        transform: scale(1);
      }
    }

    .success-icon::before {
      content: '';
      position: absolute;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: rgba(74, 222, 128, 0.2);
      animation: pulse 2s ease-out infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        opacity: 1;
      }
      100% {
        transform: scale(1.3);
        opacity: 0;
      }
    }

    .success-icon i {
      font-size: 48px;
      color: white;
      z-index: 1;
    }

    .logo {
      margin-bottom: 30px;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.4s forwards;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    .logo img {
      max-width: 180px;
      height: auto;
    }

    h1 {
      font-size: 32px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 15px;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.5s forwards;
    }

    .message {
      color: #666;
      margin-bottom: 35px;
      font-size: 16px;
      line-height: 1.7;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.6s forwards;
    }

    .email-info {
      background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 4px solid #667eea;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.7s forwards;
    }

    .email-info i {
      color: #667eea;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .email-info p {
      color: #555;
      font-size: 14px;
      margin: 0;
    }

    .email-info strong {
      color: #667eea;
      font-weight: 600;
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.8s forwards;
    }

    .btn {
      flex: 1;
      padding: 14px 24px;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      border: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
      background: white;
      color: #667eea;
      border: 2px solid #667eea;
    }

    .btn-secondary:hover {
      background: #f8f9ff;
      transform: translateY(-2px);
    }

    .help-text {
      color: #999;
      font-size: 13px;
      margin-top: 25px;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 0.9s forwards;
    }

    .help-text a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
    }

    .help-text a:hover {
      text-decoration: underline;
    }

    .steps {
      text-align: left;
      background: #f8f9fa;
      padding: 20px;
      border-radius: 12px;
      margin: 25px 0;
      opacity: 0;
      animation: fadeIn 0.5s ease-out 1s forwards;
    }

    .steps h3 {
      font-size: 16px;
      color: #333;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .steps ol {
      margin-left: 20px;
      color: #666;
      font-size: 14px;
      line-height: 1.8;
    }

    .steps li {
      margin-bottom: 8px;
    }

    @media (max-width: 480px) {
      .success-container {
        padding: 50px 30px;
      }

      h1 {
        font-size: 26px;
      }

      .action-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="success-container">
    <div class="success-icon">
      <i class="fas fa-check"></i>
    </div>

    <?php if(defined('COMPANY_LOGO')): ?>
    <div class="logo">
      <img src="<?php echo COMPANY_LOGO; ?>" alt="Company Logo">
    </div>
    <?php endif; ?>

    <h1>Check Your Email!</h1>
    <p class="message">
      We've sent a password reset link to your email address. Please check your inbox and follow the instructions to reset your password.
    </p>

    <div class="email-info">
      <i class="fas fa-envelope-open-text"></i>
      <p>
        <strong>Didn't receive the email?</strong><br>
        Check your spam folder or wait a few minutes for the email to arrive.
      </p>
    </div>

    <div class="steps">
      <h3><i class="fas fa-list-check"></i> Next Steps:</h3>
      <ol>
        <li>Open the email we sent you</li>
        <li>Click on the "Reset Password" link</li>
        <li>Enter your new password</li>
        <li>Login with your new credentials</li>
      </ol>
    </div>

    <div class="action-buttons">
      <a href="<?php echo base_url('login'); ?>" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Back to Login
      </a>
      <a href="<?php echo base_url('Login/forgotpassword'); ?>" class="btn btn-secondary">
        <i class="fas fa-redo"></i> Resend Email
      </a>
    </div>

    <div class="help-text">
      <i class="fas fa-question-circle"></i> Need help? 
      <a href="mailto:support@yourcompany.com">Contact Support</a>
    </div>
  </div>
</body>
</html>
