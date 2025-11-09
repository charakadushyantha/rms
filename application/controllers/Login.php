<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		$this->load->view('login_new'); // Using new modern UI
		// To use old design: $this->load->view('login');
	}

	public function signup()
	{
		$this->load->view('signup_new'); // Using new modern UI
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
		$this->load->view('forgotpassword_new'); // Using new modern UI
		// To use old design: $this->load->view('forgotpassword');
	}

	public function forgot_pass_process()
	{
		if($this->Login_model->email_exists())
		{
	    $subject = "Forgot Password ";
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

	      $this->email->set_newline("\r\n");
	      $this->email->from(SENDER_EMAIL);
				$rec_email = $this->input->post('femail');
	      $this->email->to($rec_email);
	      $this->email->subject($subject);
	      $message = 	"
	            <html>
	            <head>
	            </head>
	            <body>
								 <h3>Click the below link for set new Password</h3>
	              <h4><a href='http://localhost/rms/index.php/Login/reset_password/".$rec_email."'>Reset Password</a></h4>
	            </body>
	            </html>
	            ";
	         $this->email->message($message);
	         if($this->email->send()){
						 // Use new modern success page
						 $this->load->view('forgot_password_success');
					 }
					 else {
						 $data['fmsg'] = "Mail is not sent , Please try again.";
						 $this->load->view('forgotpassword_new',$data);
					 }


		}
		else {
			$data['efailed'] = "There is no Account exists which connected to entered Email.";
			$this->load->view('forgotpassword_new',$data);
		}
	}



	public function reset_password()
	{
		$data['semail'] = $this->uri->segment(3);
		$this->load->view('resetpassword_new',$data); // Using new modern UI
		// To use old design: $this->load->view('resetpassword',$data);
	}

	public function reset_password_process()
	{
		$email = $this->input->post('semail');
		$pass = md5($this->input->post('newpassword'));
		$this->db->where('u_email',$email);
		$result = $this->db->update(TBL_USERS,array('u_password'=> $pass ));
		if($result)
		{
			$this->session->set_flashdata('msgup','Your Password is Changed');
			redirect(LOGIN_URL);
		}
		else {
			echo "Password is not changed";
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
