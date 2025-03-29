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
      background-color: #f0f4f8;
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
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px 16px;
      border: 1px solid #dee2e6;
      background-color: #fdfdfd;
      margin-bottom: 1.25rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #0095e8;
      box-shadow: 0 0 0 0.2rem rgba(0, 149, 232, 0.25);
      background-color: white;
    }

    .btn-forgot {
      border-radius: 8px;
      padding: 12px;
      font-weight: 600;
      background-color: #0095e8;
      border: none;
      transition: all 0.3s ease;
      color: white;
    }

    .btn-forgot:hover {
      background-color: #007dc1;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(0, 149, 232, 0.3);
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
      font-size: 0.95rem;
    }

    .login-link {
      text-align: center;
      margin-top: 2rem;
      color: #6c757d;
      font-size: 0.9rem;
    }

    .login-link a {
      color: #0095e8;
      text-decoration: none;
      font-weight: 500;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 8px;
      padding: 1rem;
      font-size: 0.9rem;
    }

    .feature-slider {
      background-color: #7288E0;
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
      max-width: 75%;
      margin-bottom: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .feature-text h3 {
      color: white;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .feature-text p {
      color: rgba(255, 255, 255, 0.95);
      font-size: 1rem;
    }

    .email-sent-box {
      background-color: #e9f7fe;
      border-left: 4px solid #0095e8;
      border-radius: 6px;
      padding: 1rem;
      margin-top: 1rem;
      display: none;
    }

    .email-sent-box i {
      color: #0095e8;
      font-size: 1.1rem;
      margin-right: 0.5rem;
    }

    .fpblock {
      margin: 0 auto;
    }

    .fpdiv {
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      padding: 3rem;
    }

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
  <div class="row fpblock container">
    <div class="fpdiv col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center rounded-lg">
      <div class="companylogo mt-4">
        <img src="<?php echo COMPANY_NAME; ?>" alt="RMS System UCSC MIT 2024 by Charaka Dushyantha" class="img-fluid" />
      </div>
      <div class="fptitle text-center mt-2 container">
        <h2>Forgot Password</h2>
        <h6>Don't worry! Resetting your password is easy. Just type in the email you registered to this system.</h6>
      </div>
      <div class="inputgroup text-center container">
        <form action="forgot_pass_process" method="post">
          <input name="femail" type="email" class="form-control d-block p-4 rounded my-4 resetmail" placeholder="Email Address" required>
          <button type="submit" class="btn btn-lg btn-block btn-info p-2 rounded mb-4 resetbtn">Get Reset Link</button>
        </form>
      </div>
      <?php
      if(isset($smsg)) {
        echo '<div class="row col-12 container resetnotice alert alert-info text-center">
          <span>' . $smsg . '<br/> <a href="' . base_url() . 'index.php/login/forgotpassword">Click to go back</a></span>
        </div>';
      }
      else if(isset($fmsg)) {
        echo '<div class="row col-12 container resetnotice alert alert-danger text-center">
          <span>' . $fmsg . '<br/> <a href="' . base_url() . 'index.php/login/forgotpassword">Click to go Back</a></span>
        </div>';
      }
      else if(isset($efailed)) {
        echo '<div class="row col-12 container resetnotice alert alert-danger text-center">
          <span>' . $efailed . '<br/> <a href="' . base_url() . 'index.php/login/forgotpassword">Click to go Back</a></span>
        </div>';
      }
      ?>
      <div class="remPass mb-5">
        <h6>Did you remember your password? <a href="<?php echo LOGIN_URL; ?>">Try logging in</a></h6>
      </div>
    </div>
  </div>

  <!-- Bootstrap Script -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>