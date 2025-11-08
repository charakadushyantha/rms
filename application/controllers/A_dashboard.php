<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A_dashboard extends CI_Controller
{
  public function __construct()
    {
        parent::__construct();
        $this->logged_in();
    }

  private function logged_in() {
      if(! $this->session->userdata('authenticated')) {
          redirect(LOGIN_URL);
      }
  }

  public function index()
  {
    $data['uname'] = $this->session->userdata('username');
    $data['can_details']=$this->Candidate_model->get_selected_all_candidate($data);
    $data['sel_can']=$this->Calendar_model->get_selected_all_can();
    $data['can_selected'] = $this->Calendar_model->count_can_admin();
    $data['int_not_selected'] = $this->Calendar_model->int_not_sel_can();
    $data['interested_can'] = $this->Candidate_model->only_interested_can();
    $data['rtotal'] = $data['can_selected'] + $data['int_not_selected'] + $data['interested_can'];
    //print_r($data);
     $this->load->view('Admin_dashboard_view/Adashboard_new',$data); // Using new modern UI
     // To use old design: $this->load->view('Admin_dashboard_view/Adashboard',$data);
  }

  public function Acalendar_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $this->load->view('Admin_dashboard_view/Acalendar_new',$data); // Using new modern UI
    // To use old design: $this->load->view('Admin_dashboard_view/Acalendar',$data);
  }

  public function Arecruiter_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $this->load->view('Admin_dashboard_view/Arecruiter_new',$data); // Using new modern UI
    // To use old design: $this->load->view('Admin_dashboard_view/Arecruiter',$data);
  }

  public function Aaccount_details_view()
  {
    $data['uname'] = $this->session->userdata('username');
    
    // Get user details including profile picture from users table
    $user_data = $this->db->select('u_email, profile_picture')
                          ->where('u_username', $data['uname'])
                          ->get(TBL_USERS)
                          ->row();
    
    // Get additional profile details if exists
    if($this->profile_record_model->check_admin_details($data))
    {
      $profile_details = $this->profile_record_model->check_admin_details($data);
      if(!empty($profile_details)) {
        $profile_details = $profile_details[0];
        $data['admin_details'] = (object) array_merge((array)$user_data, $profile_details);
      } else {
        $data['admin_details'] = $user_data;
      }
    } else {
      $data['admin_details'] = $user_data;
    }
    
    $this->load->view('Admin_dashboard_view/Aaccount_details_new',$data); // Using new modern UI
    // To use old design: $this->load->view('Admin_dashboard_view/Aaccount_details',$data);
  }

  public function Ascandidate_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $data['can_details']=$this->Candidate_model->get_selected_all_candidate($data);
    $this->load->view('Admin_dashboard_view/Asele_candidate_new',$data); // Using new modern UI
    // To use old design: $this->load->view('Admin_dashboard_view/Asele_candidate',$data);
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(LOGIN_URL);
  }

  public function admin_profile_upload()
  {
    $admin_username = $this->session->userdata('username');
    if($this->profile_record_model->admin_exists($admin_username))
    {
      echo "Hello";
    //  redirect(A_DASHBOARD_URL);
    }
    else
    {
      $this->profile_record_model->admin_profile();
      redirect(A_DASHBOARD_URL);
    }

  }

  public function get_events()
  {
    $data = array();
    $uname = $this->session->userdata('username');
    $result = $this->Calendar_model->get_event_admin($uname);
    foreach($result->result_array() as $row)
    {
      $data[]=array(
        'Recruiter_username' => $row['ce_rec_username'],
        'id' => $row['ce_id'],
        'Can_name' => $row['ce_can_name'],
        'Interviewer'=>$row['ce_interviewer'],
        'start' => $row['ce_start_date'],
        'end'=>$row['ce_end_date'],
        'interview_round' => $row['ce_interview_round']
      );
    }
    echo json_encode($data);

  }

  public function add_rec()
  {
    if($this->Signup_model->Check_rec_username())
    {
      $this->Signup_model->add_rec();
      $this->profile_record_model->add_rec_profile();
      $this->session->set_flashdata('recsuccess',"Recruiter Added");
      redirect(A_RECRUITER_URL);
    }
    else {
      $this->session->set_flashdata('usernamenot',"Entered Username is already taken. Please try different Username");
      redirect(A_RECRUITER_URL);
    }
  }

  public function update_profile()
  {
    // Check if user is logged in
    if(!$this->session->userdata('authenticated')) {
      redirect(LOGIN_URL);
    }

    $username = $this->session->userdata('username');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');
    $gender = $this->input->post('gender');

    // Update user email in users table
    $this->db->where('u_username', $username);
    $this->db->update(TBL_USERS, array('u_email' => $email));

    // Check if profile exists
    $this->db->where('pi_username', $username);
    $query = $this->db->get(TBL_PROFILE);

    if($query->num_rows() > 0) {
      // Update existing profile
      $this->db->where('pi_username', $username);
      $this->db->update(TBL_PROFILE, array(
        'pi_phone' => $phone,
        'pi_gender' => $gender
      ));
    } else {
      // Create new profile
      $this->db->insert(TBL_PROFILE, array(
        'pi_username' => $username,
        'pi_phone' => $phone,
        'pi_gender' => $gender
      ));
    }

    // Update session email
    $this->session->set_userdata('email', $email);

    $this->session->set_flashdata('success_msg', 'Profile updated successfully!');
    redirect(A_AC_DETAILS_URL);
  }

  public function change_password()
  {
    // Check if user is logged in
    if(!$this->session->userdata('authenticated')) {
      redirect(LOGIN_URL);
    }

    $username = $this->session->userdata('username');
    $current_password = md5($this->input->post('current_password'));
    $new_password = $this->input->post('new_password');
    $confirm_password = $this->input->post('confirm_password');

    // Verify passwords match
    if($new_password !== $confirm_password) {
      $this->session->set_flashdata('error_msg', 'New passwords do not match!');
      redirect(A_AC_DETAILS_URL);
      return;
    }

    // Verify password length
    if(strlen($new_password) < 6) {
      $this->session->set_flashdata('error_msg', 'Password must be at least 6 characters!');
      redirect(A_AC_DETAILS_URL);
      return;
    }

    // Verify current password
    $this->db->where('u_username', $username);
    $this->db->where('u_password', $current_password);
    $query = $this->db->get(TBL_USERS);

    if($query->num_rows() == 0) {
      $this->session->set_flashdata('error_msg', 'Current password is incorrect!');
      redirect(A_AC_DETAILS_URL);
      return;
    }

    // Update password
    $this->db->where('u_username', $username);
    $this->db->update(TBL_USERS, array('u_password' => md5($new_password)));

    $this->session->set_flashdata('success_msg', 'Password changed successfully!');
    redirect(A_AC_DETAILS_URL);
  }

  public function upload_profile_picture()
  {
      if (!$this->session->userdata('authenticated')) {
          redirect(LOGIN_URL);
      }

      $config['upload_path'] = './uploads/profiles/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 2048; // 2MB
      $config['encrypt_name'] = TRUE;

      // Create directory if it doesn't exist
      if (!is_dir($config['upload_path'])) {
          mkdir($config['upload_path'], 0777, TRUE);
      }

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('profile_picture')) {
          $upload_data = $this->upload->data();
          $filename = $upload_data['file_name'];

          // Update database with profile picture filename
          $username = $this->session->userdata('username');
          $this->db->where('u_username', $username);
          
          // Get old profile picture before update
          $old_pic = $this->db->select('profile_picture')
                              ->where('u_username', $username)
                              ->get(TBL_USERS)
                              ->row();
          
          // Update with new picture
          $this->db->where('u_username', $username);
          $this->db->update(TBL_USERS, array('profile_picture' => $filename));

          // Delete old profile picture if exists
          if ($old_pic && isset($old_pic->profile_picture) && $old_pic->profile_picture && $old_pic->profile_picture != $filename) {
              $old_file = './uploads/profiles/' . $old_pic->profile_picture;
              if (file_exists($old_file)) {
                  unlink($old_file);
              }
          }

          $this->session->set_flashdata('success_msg', 'Profile picture updated successfully!');
      } else {
          $this->session->set_flashdata('error_msg', $this->upload->display_errors());
      }

      redirect(A_AC_DETAILS_URL);
  }

}
?>
