<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo TAB_LOGO; ?>">
  <title>Reset Password - RMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    .reset-container {
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
    }

    .form-group {
      margin-bottom: 20px;
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

    .toggle-password {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      cursor: pointer;
      font-size: 16px;
    }

    .toggle-password:hover {
      color: #667eea;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      padding: 14px 45px 14px 45px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .password-match {
      font-size: 13px;
      margin-top: 8px;
      display: none;
    }

    .password-match.match {
      color: #2e7d32;
      display: block;
    }

    .password-match.no-match {
      color: #c33;
      display: block;
    }

    .btn-group {
      display: flex;
      gap: 12px;
      margin-top: 24px;
    }

    .btn-reset,
    .btn-cancel {
      flex: 1;
      padding: 14px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-reset {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .btn-reset:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-reset:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .btn-cancel {
      background: #f5f5f5;
      color: #666;
    }

    .btn-cancel:hover {
      background: #e0e0e0;
    }

    @media (max-width: 480px) {
      .reset-container {
        padding: 40px 30px;
      }

      h1 {
        font-size: 24px;
      }

      .btn-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <div class="icon-wrapper">
      <i class="fas fa-lock"></i>
    </div>

    <h1>Reset Password</h1>
    <p class="subtitle">Create a strong new password for your account</p>

    <form action="<?php echo LOGIN_URL; ?>/reset_password_process" method="post">
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-wrapper">
          <i class="fas fa-envelope"></i>
          <input type="email" name="semail" id="email" value="<?php echo $semail; ?>" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="newpassword">New Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock"></i>
          <input type="password" name="newpassword" id="newpassword" placeholder="Enter new password" required>
          <i class="fas fa-eye toggle-password" data-target="newpassword"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="confirmpassword">Confirm Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock"></i>
          <input type="password" id="confirmpassword" placeholder="Re-enter new password" required>
          <i class="fas fa-eye toggle-password" data-target="confirmpassword"></i>
        </div>
        <div class="password-match" id="matchMessage"></div>
      </div>

      <div class="btn-group">
        <button type="submit" class="btn-reset" id="submitBtn" disabled>
          <i class="fas fa-check"></i> Reset Password
        </button>
        <button type="button" class="btn-cancel" onclick="window.location.href='<?php echo LOGIN_URL; ?>'">
          <i class="fas fa-times"></i> Cancel
        </button>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(function() {
      // Toggle password visibility
      $('.toggle-password').click(function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this);
        
        if (input.attr('type') === 'password') {
          input.attr('type', 'text');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          input.attr('type', 'password');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });

      // Password match validation
      function checkPasswordMatch() {
        const newPass = $('#newpassword').val();
        const confirmPass = $('#confirmpassword').val();
        const matchMessage = $('#matchMessage');
        const submitBtn = $('#submitBtn');

        if (confirmPass === '') {
          matchMessage.hide();
          submitBtn.prop('disabled', true);
          return;
        }

        if (newPass === confirmPass && newPass !== '') {
          matchMessage.removeClass('no-match').addClass('match');
          matchMessage.html('<i class="fas fa-check-circle"></i> Passwords match');
          matchMessage.show();
          submitBtn.prop('disabled', false);
        } else {
          matchMessage.removeClass('match').addClass('no-match');
          matchMessage.html('<i class="fas fa-times-circle"></i> Passwords do not match');
          matchMessage.show();
          submitBtn.prop('disabled', true);
        }
      }

      $('#newpassword, #confirmpassword').on('input', checkPasswordMatch);
    });
  </script>
</body>
</html>
