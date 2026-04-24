<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Get time-based greeting message
	 * @param string $timezone - Timezone identifier (e.g., 'Asia/Kolkata', 'America/New_York')
	 * @return string - Greeting message based on current time
	 */
	private function get_time_based_greeting($timezone = 'Asia/Kolkata')
	{
		try {
			// Create DateTime object with specified timezone
			$date = new DateTime('now', new DateTimeZone($timezone));
			$hour = (int)$date->format('H'); // Get hour in 24-hour format
			
			// Determine greeting based on time of day
			if ($hour >= 5 && $hour < 12) {
				return 'Good Morning';
			} elseif ($hour >= 12 && $hour < 18) {
				return 'Good Afternoon';
			} elseif ($hour >= 18 && $hour < 22) {
				return 'Good Evening';
			} else {
				return 'Good Night';
			}
		} catch (Exception $e) {
			// Fallback to default greeting if timezone is invalid
			log_message('error', 'Timezone error: ' . $e->getMessage());
			return 'Welcome Back';
		}
	}

	public function index()
	{
		// Add dynamic greeting based on time of day
		$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
		
		$this->load->view('login_new', $data); // Using new modern UI
		// To use old design: $this->load->view('login');
	}

	public function signup()
	{
		// Load signup controller model to check if signup is enabled
		$this->load->model('Signup_controller_model');
		$settings = $this->Signup_controller_model->get_signup_settings();
		
		// Add dynamic greeting
		$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
		$data['signup_settings'] = $settings;
		
		// Check if any role signup is enabled (with fallback for missing table)
		try {
			$signup_enabled = $settings->admin_signup_enabled || 
			                 $settings->recruiter_signup_enabled || 
			                 $settings->interviewer_signup_enabled || 
			                 $settings->candidate_signup_enabled;
			
			if (!$signup_enabled) {
				$this->session->set_flashdata('msgad', 'Registration is currently disabled. Please contact administrator.');
				redirect(LOGIN_URL);
				return;
			}
		} catch (Exception $e) {
			// If there's an error (like missing table), allow default signup
			log_message('error', 'Signup settings check failed: ' . $e->getMessage());
		}
		
		$this->load->view('signup_new', $data); // Using new modern UI
		// To use old design: $this->load->view('signup');
	}

	public function signupproc()
	{
		if($this->Signup_model->Check_both()) {
		 $this->session->set_flashdata('emailusername','Following Username and Email both are already existed');
		 redirect(SIGNUP_URL);
	 }

		else if($this->Signup_model->Check_username())
		{
			$this->session->set_flashdata('useralready','Following Username already existed');
			redirect(SIGNUP_URL);
		}

		else if ($this->Signup_model->Check_email()) {
			$this->session->set_flashdata('emailalready','Following Email already existed');
			redirect(SIGNUP_URL);
		}

	else{
			if($this->Signup_model->Create_rec())
			{
				$senddata['Rusername'] = $this->input->post('username');
				$senddata['Remail'] = $this->input->post('useremail');
				if($this->sendmail())
				{
					$this->session->set_flashdata('success_msg','Your Account has been Created and Activation mail sent to Admin<br/> You may now Login');
					redirect(SIGNUP_URL);
				}
				else {
					$this->session->set_flashdata('mail_failed_msg','Your Account has been Created but Activation mail is not sent to Admin due to error<br/> You may now Login');
					redirect(SIGNUP_URL);

				}
			}
			else {
				$this->session->set_flashdata('rec_failed_msg','Recruiter is not created.<br/> You may now Login');
				redirect(SIGNUP_URL);
			}

			}
  }

	public function loginproc()
	{
		if($this->Login_model->username())
		{
			if($this->Login_model->password())
			{
				if($this->Login_model->check_rec_status())
				{
					$username = $this->input->post('username');
            $password =$this->input->post('userpass');

            $user = $this->Login_model->get_data($username, $password);

            if($user){
                $userdata = array(
                    'id' => $user->u_id,
                    'username' => $user->u_username,
                    'email' => $user->u_email,
										'Role' => $user->u_role,
                    'authenticated' => TRUE
                );

          			$this->session->set_userdata($userdata);
								redirect(R_DASHBOARD_URL);
										}
						else {
							echo "data fatch error";
						}
				}
				else if($this->Login_model->check_admin_status())
				{
					$username = $this->input->post('username');
            $password =$this->input->post('userpass');

            $user = $this->Login_model->get_data($username, $password);

            if($user){
                $userdata = array(
                    'id' => $user->u_id,
                    'username' => $user->u_username,
                    'email' => $user->u_email,
										'Role' => $user->u_role,
                    'authenticated' => TRUE
                );

          			$this->session->set_userdata($userdata);
								redirect(A_DASHBOARD_URL);
										}
						else {
							echo "data fatch error";
						}
				}
				else if($this->Login_model->check_interviewer_status())
				{
					$username = $this->input->post('username');
            $password =$this->input->post('userpass');

            $user = $this->Login_model->get_data($username, $password);

            if($user){
                $userdata = array(
                    'id' => $user->u_id,
                    'username' => $user->u_username,
                    'email' => $user->u_email,
										'Role' => $user->u_role,
                    'authenticated' => TRUE
                );

          			$this->session->set_userdata($userdata);
								// Redirect to Interviewer dashboard
								redirect(base_url('I_dashboard'));
										}
						else {
							echo "data fatch error";
						}
				}
				else if($this->Login_model->check_candidate_status())
				{
					$username = $this->input->post('username');
            $password =$this->input->post('userpass');

            $user = $this->Login_model->get_data($username, $password);

            if($user){
                $userdata = array(
                    'id' => $user->u_id,
                    'username' => $user->u_username,
                    'email' => $user->u_email,
										'Role' => $user->u_role,
                    'authenticated' => TRUE
                );

          			$this->session->set_userdata($userdata);
								// Redirect to Candidate dashboard
								redirect(base_url('C_dashboard'));
										}
						else {
							echo "data fatch error";
						}
				}
				else {
					// Account is not activated
					$this->session->set_flashdata('msgad','Account is not activated. Please contact administrator.');
					redirect(LOGIN_URL);
				}

			}
			else {
				// Pass wrong
				$this->session->set_flashdata('msgpw','Wrong Password. Try again or click Forgot password to reset it');
				redirect(LOGIN_URL);

			}

		}
		else {
			$this->session->set_flashdata('msgupw','Invalid Username and Password');
			redirect(LOGIN_URL);

		}
	}


	public function sendmail()
	{
		$rec_username = $this->input->post('username');
		$rec_email   = $this->input->post('useremail');

		try {
			// Load email configuration
			$config = array(
				'protocol'    => 'smtp',
				'smtp_host'   => 'smtp.gmail.com',
				'smtp_port'   => 587,
				'smtp_timeout' => 60,
				'smtp_user'   => SENDER_EMAIL,
				'smtp_pass'   => SENDER_PASSWORD,
				'smtp_crypto' => 'tls',
				'charset'     => 'utf-8',
				'newline'     => "\r\n",
				'mailtype'    => 'html',
				'validation'  => TRUE,
				'crlf'        => "\r\n",
				'wordwrap'    => TRUE
			);
			
			$this->load->library('email', $config);

			$this->email->from(SENDER_EMAIL, 'RMS Admin');
			$this->email->to(SENDER_EMAIL);
			$this->email->subject('Activation of Recruiter Account');
			
			$message = "
				<html>
				<head>
					<title>Activate Recruiter</title>
				</head>
				<body>
					<h3>New Recruiter Registration</h3>
					<p><strong>Username:</strong> ".$rec_username."</p>
					<p><strong>Email:</strong> ".$rec_email."</p>
					<p><a href='".BASE_URL."/index.php/Login/activate_rec/".$rec_username."' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Activate Recruiter Account</a></p>
				</body>
				</html>
			";
			
			$this->email->message($message);
			
			if($this->email->send())
			{
				log_message('info', 'Email sent successfully to: ' . SENDER_EMAIL);
				return TRUE;
			}
			else {
				// Log the error for debugging
				$error = $this->email->print_debugger();
				log_message('error', 'Email sending failed: ' . $error);
				// Also log to a file for easier debugging
				file_put_contents('email_error.log', date('Y-m-d H:i:s') . " - " . $error . "\n\n", FILE_APPEND);
				return FALSE;
			}
		} catch (Exception $e) {
			log_message('error', 'Email exception: ' . $e->getMessage());
			file_put_contents('email_error.log', date('Y-m-d H:i:s') . " - Exception: " . $e->getMessage() . "\n\n", FILE_APPEND);
			return FALSE;
		}
	}


	public function activate_rec()
	{
		$uname = $this->uri->segment(3);
		$this->db->where('u_username',$uname);
		// Use new string status instead of numeric
		$this->db->update(TBL_USERS,array('u_status'=> 'Active'));
		redirect(LOGIN_URL);
	}

	public function forgotpassword()
	{
		// Add dynamic greeting
		$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
		
		$this->load->view('forgotpassword_new', $data); // Using new modern UI
		// To use old design: $this->load->view('forgotpassword');
	}

	public function forgot_pass_process()
	{
		if ($this->Login_model->email_exists())
		{
			$rec_email   = $this->input->post('femail');

			// Generate a secure token and store it in the DB (not session — survives new tabs/requests)
			$reset_token   = bin2hex(random_bytes(32));
			$reset_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

			// Store token on the user record (wrapped in try/catch in case columns don't exist yet)
			try {
				$this->db->where('u_email', $rec_email);
				$this->db->update(TBL_USERS, array(
					'reset_token'   => $reset_token,
					'reset_expires' => $reset_expires
				));
			} catch (Exception $e) {
				log_message('error', 'Could not save reset token (run setup_database.php): ' . $e->getMessage());
			}

			// Build reset link
			$reset_link = base_url('Login/reset_password/' . urlencode($rec_email) . '/' . $reset_token);

			$subject = "Forgot Password - RMS";
			$config  = array(
				'protocol'    => 'smtp',
				'smtp_host'   => 'smtp.gmail.com',
				'smtp_port'   => 587,
				'smtp_timeout' => 60,
				'smtp_user'   => SENDER_EMAIL,
				'smtp_pass'   => SENDER_PASSWORD,
				'smtp_crypto' => 'tls',
				'charset'     => 'utf-8',
				'newline'     => "\r\n",
				'mailtype'    => 'html',
				'validation'  => TRUE,
				'crlf'        => "\r\n",
				'wordwrap'    => TRUE
			);

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from(SENDER_EMAIL, 'RMS System');
			$this->email->to($rec_email);
			$this->email->subject($subject);
			$message = "
				<html>
				<body>
					<h3>Password Reset Request</h3>
					<p>Click the link below to reset your password. This link expires in 1 hour.</p>
					<p><a href='{$reset_link}' style='background:#667eea;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Reset Password</a></p>
					<p>Or copy this link:<br>{$reset_link}</p>
					<p>If you did not request this, ignore this email.</p>
				</body>
				</html>
			";
			$this->email->message($message);

			if ($this->email->send()) {
				$this->load->view('forgot_password_success');
			} else {
				// SMTP failed (common on localhost XAMPP) — show direct link as fallback
				log_message('error', 'Password reset email failed: ' . $this->email->print_debugger());

				$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
				$data['fmsg']     = 'Email could not be sent (SMTP not configured on localhost). '
					. '<a href="' . $reset_link . '" style="color:#667eea;font-weight:bold;">Click here to reset your password directly</a>.';
				$this->load->view('forgotpassword_new', $data);
			}
		}
		else
		{
			$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
			$data['efailed']  = "No account found with that email address.";
			$this->load->view('forgotpassword_new', $data);
		}
	}

	public function reset_password()
	{
		$email = urldecode($this->uri->segment(3));
		$token = $this->uri->segment(4);

		// Validate token against DB
		$this->db->where('u_email', $email);
		$this->db->where('reset_token', $token);
		$this->db->where('reset_expires >=', date('Y-m-d H:i:s'));
		$user = $this->db->get(TBL_USERS)->row();

		if (!$user) {
			$this->session->set_flashdata('msgad', 'Invalid or expired reset link. Please request a new one.');
			redirect(base_url('Login/forgotpassword'));
			return;
		}

		$data['semail']   = $email;
		$data['token']    = $token;
		$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
		$this->load->view('resetpassword_new', $data);
	}

	public function reset_password_process()
	{
		$email   = $this->input->post('semail');
		$token   = $this->input->post('reset_token');
		$newpass = $this->input->post('newpassword');
		$confirm = $this->input->post('confirmpassword');

		// Validate inputs
		if (empty($email) || empty($newpass) || empty($token)) {
			$this->session->set_flashdata('msgad', 'Invalid request. Please try again.');
			redirect(base_url('Login/forgotpassword'));
			return;
		}

		if ($newpass !== $confirm) {
			$data['semail']   = $email;
			$data['token']    = $token;
			$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
			$data['error']    = 'Passwords do not match.';
			$this->load->view('resetpassword_new', $data);
			return;
		}

		// Re-validate token from DB before updating
		$this->db->where('u_email', $email);
		$this->db->where('reset_token', $token);
		$this->db->where('reset_expires >=', date('Y-m-d H:i:s'));
		$user = $this->db->get(TBL_USERS)->row();

		if (!$user) {
			$this->session->set_flashdata('msgad', 'Reset link has expired. Please request a new one.');
			redirect(base_url('Login/forgotpassword'));
			return;
		}

		// Update password and clear the token
		$this->db->where('u_email', $email);
		$this->db->update(TBL_USERS, array(
			'u_password'    => md5($newpass),
			'reset_token'   => NULL,
			'reset_expires' => NULL
		));

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('msgup', 'Your password has been changed successfully. Please log in.');
			redirect(LOGIN_URL);
		} else {
			$data['semail']   = $email;
			$data['token']    = $token;
			$data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
			$data['error']    = 'Password could not be updated. Please try again.';
			$this->load->view('resetpassword_new', $data);
		}
	}

	/**
	 * Google OAuth Login - Initiate
	 * Redirects user to Google OAuth consent screen
	 */
	public function google_login()
	{
		// Get configuration from database
		$config = $this->db->where('provider', 'google')->get('oauth_config')->row();
		
		// Check if Google OAuth is configured and enabled
		if (!$config || empty($config->client_id) || empty($config->client_secret) || !$config->is_enabled) {
			$this->session->set_flashdata('msgad', 'Google login is not configured or enabled. Please contact administrator.');
			redirect(LOGIN_URL);
			return;
		}

		// Build Google OAuth URL
		$params = array(
			'client_id' => $config->client_id,
			'redirect_uri' => base_url('Login/google_callback'),
			'response_type' => 'code',
			'scope' => 'email profile',
			'access_type' => 'online',
			'prompt' => 'select_account'
		);

		$auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
		redirect($auth_url);
	}

	/**
	 * Google OAuth Callback
	 * Handles the response from Google after user authorization
	 */
	public function google_callback()
	{
		// Get configuration from database
		$config = $this->db->where('provider', 'google')->get('oauth_config')->row();
		
		// Check if Google OAuth is configured
		if (!$config || empty($config->client_id) || empty($config->client_secret)) {
			$this->session->set_flashdata('msgad', 'Google login not configured yet');
			redirect(LOGIN_URL);
			return;
		}

		// Get authorization code from Google
		$code = $this->input->get('code');
		
		if (!$code) {
			$this->session->set_flashdata('msgad', 'Google login failed. Please try again.');
			redirect(LOGIN_URL);
			return;
		}

		// Exchange authorization code for access token
		$token_url = 'https://oauth2.googleapis.com/token';
		$token_data = array(
			'code' => $code,
			'client_id' => $config->client_id,
			'client_secret' => $config->client_secret,
			'redirect_uri' => base_url('Login/google_callback'),
			'grant_type' => 'authorization_code'
		);

		// Use cURL to get access token
		$ch = curl_init($token_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);

		$token_info = json_decode($response, true);

		if (!isset($token_info['access_token'])) {
			$this->session->set_flashdata('msgad', 'Failed to get access token from Google');
			redirect(LOGIN_URL);
			return;
		}

		// Get user info from Google
		$user_info_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $token_info['access_token'];
		$ch = curl_init($user_info_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$user_info_response = curl_exec($ch);
		curl_close($ch);

		$user_info = json_decode($user_info_response, true);

		if (!isset($user_info['email'])) {
			$this->session->set_flashdata('msgad', 'Failed to get user information from Google');
			redirect(LOGIN_URL);
			return;
		}

		// Check if user exists in database
		$this->db->where('u_email', $user_info['email']);
		$existing_user = $this->db->get(TBL_USERS)->row();

		if ($existing_user) {
			// User exists - check if account is active
			if ($existing_user->u_status == 'Active') {
				// Update profile picture if available from Google
				if (isset($user_info['picture'])) {
					$this->db->where('u_id', $existing_user->u_id);
					$this->db->update(TBL_USERS, array('profile_picture' => $user_info['picture']));
				}
				
				// Update or create profile_info with Google name
				if (isset($user_info['name'])) {
					$this->db->where('pi_username', $existing_user->u_username);
					$profile_exists = $this->db->get(TBL_PROFILE)->row();
					
					$profile_data = array(
						'pi_username' => $existing_user->u_username,
						'pi_email' => $existing_user->u_email,
						'pi_role' => $existing_user->u_role
					);
					
					// Add name fields if available
					if (isset($user_info['given_name'])) {
						$profile_data['pi_first_name'] = $user_info['given_name'];
					}
					if (isset($user_info['family_name'])) {
						$profile_data['pi_last_name'] = $user_info['family_name'];
					}
					// Store full name
					$profile_data['pi_full_name'] = $user_info['name'];
					
					if ($profile_exists) {
						$this->db->where('pi_username', $existing_user->u_username);
						$this->db->update(TBL_PROFILE, $profile_data);
					} else {
						$this->db->insert(TBL_PROFILE, $profile_data);
					}
				}
				
				// Get the display name (prefer full name from profile, fallback to username)
				$display_name = $existing_user->u_username;
				if (isset($user_info['name'])) {
					$display_name = $user_info['name'];
				}
				
				// Log user in
				$userdata = array(
					'id' => $existing_user->u_id,
					'username' => $existing_user->u_username,
					'email' => $existing_user->u_email,
					'full_name' => $display_name,
					'Role' => $existing_user->u_role,
					'authenticated' => TRUE,
					'google_login' => TRUE
				);

				$this->session->set_userdata($userdata);

				// Redirect based on role
				switch($existing_user->u_role) {
					case 'Admin':
						redirect(A_DASHBOARD_URL);
						break;
					case 'Recruiter':
						redirect(R_DASHBOARD_URL);
						break;
					case 'Interviewer':
						redirect(base_url('I_dashboard'));
						break;
					case 'Candidate':
						redirect(base_url('C_dashboard'));
						break;
					default:
						redirect(R_DASHBOARD_URL);
				}
			} else {
				$this->session->set_flashdata('msgad', 'Your account is not activated. Please contact administrator.');
				redirect(LOGIN_URL);
			}
		} else {
			// User doesn't exist - create new account based on config
			$username = explode('@', $user_info['email'])[0];
			
			// Check if username already exists, if so, append random number
			$this->db->where('u_username', $username);
			if ($this->db->count_all_results(TBL_USERS) > 0) {
				$username = $username . '_' . rand(1000, 9999);
			}

			// Determine status based on config
			$status = $config->auto_activate_users ? 'Active' : 'Pending';
			
			// Create new user account
			$new_user_data = array(
				'u_username' => $username,
				'u_email' => $user_info['email'],
				'u_password' => md5(uniqid()), // Random password since they'll use Google login
				'u_role' => $config->default_role, // Use role from config
				'u_status' => $status, // Use status from config
				'profile_picture' => isset($user_info['picture']) ? $user_info['picture'] : NULL
			);

			$this->db->insert(TBL_USERS, $new_user_data);
			$new_user_id = $this->db->insert_id();

			// Create profile_info with Google name
			if (isset($user_info['name'])) {
				$profile_data = array(
					'pi_username' => $username,
					'pi_email' => $user_info['email'],
					'pi_role' => $config->default_role,
					'pi_full_name' => $user_info['name']
				);
				
				// Add name fields if available
				if (isset($user_info['given_name'])) {
					$profile_data['pi_first_name'] = $user_info['given_name'];
				}
				if (isset($user_info['family_name'])) {
					$profile_data['pi_last_name'] = $user_info['family_name'];
				}
				
				$this->db->insert(TBL_PROFILE, $profile_data);
			}

			// Create candidate profile if role is Candidate
			if ($config->default_role == 'Candidate' && isset($user_info['name'])) {
				$candidate_data = array(
					'cd_rec_username' => 'system',
					'cd_name' => $user_info['name'],
					'cd_email' => $user_info['email'],
					'cd_phone' => 0,
					'cd_gender' => 'Not Specified',
					'cd_job_title' => 'Not Specified',
					'cd_source' => 'Google OAuth',
					'cd_description' => 'Registered via Google Sign-In',
					'cd_status' => 'New',
					'cd_interview_status' => 0
				);
				$this->db->insert('candidate_details', $candidate_data);
			}

			// Get display name
			$display_name = isset($user_info['name']) ? $user_info['name'] : $username;

			// Log the new user in
			$userdata = array(
				'id' => $new_user_id,
				'username' => $username,
				'email' => $user_info['email'],
				'full_name' => $display_name,
				'Role' => $config->default_role,
				'authenticated' => TRUE,
				'google_login' => TRUE
			);

			$this->session->set_userdata($userdata);
			
			// Redirect to candidate dashboard
			redirect(base_url('C_dashboard'));
		}
	}

	public function logout()
	{
		// Destroy session
		$this->session->sess_destroy();
		
		// Redirect to login page
		redirect(LOGIN_URL);
	}

}
