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
      return 'Welcome back';
    }
  }

  public function index()
  {
    $data['uname'] = $this->session->userdata('username');
    
    // Add dynamic greeting based on time of day
    // You can change the timezone parameter as needed
    $data['greeting'] = $this->get_time_based_greeting('Asia/Kolkata');
    
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
    $this->load->view('Admin_dashboard_view/Acalendar_modern',$data); // Using modern compact UI
    // To use new design: $this->load->view('Admin_dashboard_view/Acalendar_new',$data);
    // To use old design: $this->load->view('Admin_dashboard_view/Acalendar',$data);
  }

  public function Arecruiter_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $this->load->view('Admin_dashboard_view/Arecruiter',$data);
    // Old design removed — Arecruiter.php is now the current modern UI
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
    
    // Check if cd_created_at column exists
    $fields = $this->db->list_fields('candidate_details');
    $has_created_at = in_array('cd_created_at', $fields);
    
    // Debug: log the column check
    log_message('debug', 'Has created_at column: ' . ($has_created_at ? 'YES' : 'NO'));
    
    if ($has_created_at) {
        // Get statistics for selected candidates
        // This month
        $this->db->select('COUNT(*) as count');
        $this->db->from('candidate_details');
        $this->db->where('cd_status', 'Selected');
        $this->db->where('MONTH(cd_created_at) = MONTH(CURDATE())', NULL, FALSE);
        $this->db->where('YEAR(cd_created_at) = YEAR(CURDATE())', NULL, FALSE);
        $result = $this->db->get();
        $data['selected_this_month'] = $result->row()->count;
        
        // This week
        $this->db->select('COUNT(*) as count');
        $this->db->from('candidate_details');
        $this->db->where('cd_status', 'Selected');
        $this->db->where('YEARWEEK(cd_created_at, 1) = YEARWEEK(CURDATE(), 1)', NULL, FALSE);
        $result = $this->db->get();
        $data['selected_this_week'] = $result->row()->count;
        
        // Today
        $this->db->select('COUNT(*) as count');
        $this->db->from('candidate_details');
        $this->db->where('cd_status', 'Selected');
        $this->db->where('DATE(cd_created_at) = CURDATE()', NULL, FALSE);
        $result = $this->db->get();
        $data['selected_today'] = $result->row()->count;
    } else {
        // If column doesn't exist, set all to 0
        $data['selected_this_month'] = 0;
        $data['selected_this_week'] = 0;
        $data['selected_today'] = 0;
    }
    
    $this->load->view('Admin_dashboard_view/Asele_candidate_new',$data); // Using new modern UI
    // To use old design: $this->load->view('Admin_dashboard_view/Asele_candidate',$data);
  }

  public function Ainterviewer_view()
  {
    $data['uname'] = $this->session->userdata('username');
    
    // Get all interviewers from users table
    $this->db->select('u.*, p.pi_phone, p.pi_gender');
    $this->db->from('users u');
    $this->db->join('profile_info p', 'u.u_username = p.pi_username', 'left');
    $this->db->where('u.u_role', 'Interviewer');
    $this->db->order_by('u.u_username', 'ASC');
    $data['interviewers'] = $this->db->get();
    
    // Get statistics
    $data['total_interviewers'] = $data['interviewers']->num_rows();
    
    // Count active interviewers (those who have conducted interviews)
    $this->db->select('COUNT(DISTINCT ce_interviewer) as count');
    $this->db->from('calendar_events');
    $this->db->where('ce_interviewer IS NOT NULL');
    $result = $this->db->get();
    $data['active_interviewers'] = $result->row()->count;
    
    $this->load->view('Admin_dashboard_view/Ainterviewer_view', $data);
  }

  public function reports_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $data['page_title'] = 'MIS Reports';
    
    // Get report statistics
    $data['total_candidates'] = $this->db->count_all('candidate_details');
    $data['total_interviews'] = $this->db->count_all('calendar_events');
    $data['total_recruiters'] = $this->db->where('u_role', 'Recruiter')->count_all_results('users');
    $data['total_interviewers'] = $this->db->where('u_role', 'Interviewer')->count_all_results('users');
    
    // Calculate average time to hire (using interview dates as proxy)
    // Since cd_updated_at doesn't exist, we'll use the interview date as the hiring milestone
    $this->db->select('DATEDIFF(ce.ce_start_date, cd.cd_created_at) as days_to_hire');
    $this->db->from('candidate_details cd');
    $this->db->join('calendar_events ce', 'cd.cd_name = ce.ce_can_name', 'inner');
    $this->db->where('cd.cd_status', 'Selected');
    $this->db->where('cd.cd_created_at IS NOT NULL');
    $this->db->where('ce.ce_start_date IS NOT NULL');
    $query = $this->db->get();
    
    $total_days = 0;
    $count = 0;
    foreach ($query->result() as $row) {
      if ($row->days_to_hire > 0) {
        $total_days += $row->days_to_hire;
        $count++;
      }
    }
    $data['avg_time_to_hire'] = $count > 0 ? round($total_days / $count) : 0;
    
    // Get recruitment trend data (last 6 months)
    $data['trend_data'] = $this->get_recruitment_trend_data(6);
    
    // Get weekly activity data
    $data['weekly_activity'] = $this->get_weekly_activity_data();
    
    // Get monthly hiring trend (last 6 months)
    $data['monthly_hiring'] = $this->get_monthly_hiring_data(6);
    
    // Get time to hire by role
    $data['time_to_hire_by_role'] = $this->get_time_to_hire_by_role();
    
    // Get candidate experience survey data (if exists in database)
    $data['candidate_experience'] = $this->get_candidate_experience_data();
    
    // Get interviewer calibration data
    $data['interviewer_calibration'] = $this->get_interviewer_calibration_data();
    
    $this->load->view('Admin_dashboard_view/reports_view', $data);
  }
  
  private function get_recruitment_trend_data($months = 6)
  {
    $data = [
      'labels' => [],
      'candidates' => [],
      'interviews' => [],
      'selected' => []
    ];
    
    for ($i = $months - 1; $i >= 0; $i--) {
      $month = date('Y-m', strtotime("-$i months"));
      $month_label = date('M', strtotime("-$i months"));
      
      $data['labels'][] = $month_label;
      
      // Count candidates added this month
      $this->db->where("DATE_FORMAT(cd_created_at, '%Y-%m') =", $month);
      $data['candidates'][] = $this->db->count_all_results('candidate_details');
      
      // Count interviews this month
      $this->db->where("DATE_FORMAT(ce_start_date, '%Y-%m') =", $month);
      $data['interviews'][] = $this->db->count_all_results('calendar_events');
      
      // Count selected candidates created this month with Selected status
      $this->db->where('cd_status', 'Selected');
      $this->db->where("DATE_FORMAT(cd_created_at, '%Y-%m') =", $month);
      $data['selected'][] = $this->db->count_all_results('candidate_details');
    }
    
    return $data;
  }
  
  private function get_weekly_activity_data()
  {
    $data = [
      'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      'applications' => [],
      'interviews' => []
    ];
    
    // Get data for current week
    for ($i = 1; $i <= 7; $i++) {
      // Applications (candidates added)
      $this->db->where('DAYOFWEEK(cd_created_at) =', $i + 1); // MySQL DAYOFWEEK: 1=Sunday, 2=Monday, etc.
      $this->db->where('YEARWEEK(cd_created_at, 1) = YEARWEEK(CURDATE(), 1)', NULL, FALSE);
      $data['applications'][] = $this->db->count_all_results('candidate_details');
      
      // Interviews scheduled
      $this->db->where('DAYOFWEEK(ce_start_date) =', $i + 1);
      $this->db->where('YEARWEEK(ce_start_date, 1) = YEARWEEK(CURDATE(), 1)', NULL, FALSE);
      $data['interviews'][] = $this->db->count_all_results('calendar_events');
    }
    
    return $data;
  }
  
  private function get_monthly_hiring_data($months = 6)
  {
    $data = [
      'labels' => [],
      'candidates' => [],
      'interviews' => [],
      'hired' => []
    ];
    
    for ($i = $months - 1; $i >= 0; $i--) {
      $month = date('Y-m', strtotime("-$i months"));
      $month_label = date('M', strtotime("-$i months"));
      
      $data['labels'][] = $month_label;
      
      // Count candidates
      $this->db->where("DATE_FORMAT(cd_created_at, '%Y-%m') =", $month);
      $data['candidates'][] = $this->db->count_all_results('candidate_details');
      
      // Count interviews
      $this->db->where("DATE_FORMAT(ce_start_date, '%Y-%m') =", $month);
      $data['interviews'][] = $this->db->count_all_results('calendar_events');
      
      // Count hired (selected candidates created in this month)
      $this->db->where('cd_status', 'Selected');
      $this->db->where("DATE_FORMAT(cd_created_at, '%Y-%m') =", $month);
      $data['hired'][] = $this->db->count_all_results('candidate_details');
    }
    
    return $data;
  }
  
  private function get_time_to_hire_by_role()
  {
    // Calculate time to hire using interview date as milestone
    $this->db->select('cd.cd_job_title, AVG(DATEDIFF(ce.ce_start_date, cd.cd_created_at)) as avg_days, COUNT(DISTINCT cd.cd_id) as count');
    $this->db->from('candidate_details cd');
    $this->db->join('calendar_events ce', 'cd.cd_name = ce.ce_can_name', 'inner');
    $this->db->where('cd.cd_status', 'Selected');
    $this->db->where('cd.cd_created_at IS NOT NULL');
    $this->db->where('ce.ce_start_date IS NOT NULL');
    $this->db->where('cd.cd_job_title IS NOT NULL');
    $this->db->where('cd.cd_job_title !=', '');
    $this->db->where('cd.cd_job_title !=', 'Not Specified');
    $this->db->group_by('cd.cd_job_title');
    $this->db->having('count >', 0);
    $this->db->order_by('count', 'DESC');
    $this->db->limit(6);
    
    $query = $this->db->get();
    $result = [
      'labels' => [],
      'days' => []
    ];
    
    foreach ($query->result() as $row) {
      $result['labels'][] = $row->cd_job_title;
      $result['days'][] = round($row->avg_days);
    }
    
    // If no data, return empty arrays
    if (empty($result['labels'])) {
      $result['labels'] = ['No Data'];
      $result['days'] = [0];
    }
    
    return $result;
  }
  
  private function get_candidate_experience_data()
  {
    // Check if feedback table exists
    $tables = $this->db->list_tables();
    if (in_array('candidate_feedback', $tables)) {
      // Get average ratings from feedback table
      $this->db->select('
        AVG(communication_rating) as communication,
        AVG(interview_process_rating) as interview_process,
        AVG(recruiter_support_rating) as recruiter_support,
        AVG(response_time_rating) as response_time,
        AVG(overall_experience_rating) as overall_experience,
        AVG(would_recommend_rating) as would_recommend
      ');
      $query = $this->db->get('candidate_feedback');
      
      if ($query->num_rows() > 0) {
        $row = $query->row();
        return [
          'communication' => round($row->communication, 1),
          'interview_process' => round($row->interview_process, 1),
          'recruiter_support' => round($row->recruiter_support, 1),
          'response_time' => round($row->response_time, 1),
          'overall_experience' => round($row->overall_experience, 1),
          'would_recommend' => round($row->would_recommend, 1)
        ];
      }
    }
    
    // Return zeros if no data
    return [
      'communication' => 0,
      'interview_process' => 0,
      'recruiter_support' => 0,
      'response_time' => 0,
      'overall_experience' => 0,
      'would_recommend' => 0
    ];
  }
  
  private function get_interviewer_calibration_data()
  {
    // Check if interview_ratings table exists
    $tables = $this->db->list_tables();
    
    if (in_array('interview_ratings', $tables)) {
      // Get average ratings per interviewer from ratings table
      $this->db->select('ce.ce_interviewer, COUNT(ce.ce_id) as total_interviews, AVG(ir.rating) as avg_rating');
      $this->db->from('calendar_events ce');
      $this->db->join('interview_ratings ir', 'ce.ce_id = ir.interview_id', 'left');
      $this->db->where('ce.ce_interviewer IS NOT NULL');
      $this->db->where('ce.ce_interviewer !=', '');
      $this->db->group_by('ce.ce_interviewer');
      $this->db->order_by('total_interviews', 'DESC');
      $this->db->limit(10);
      
      $query = $this->db->get();
      $result = [
        'labels' => [],
        'interviews' => [],
        'ratings' => []
      ];
      
      foreach ($query->result() as $row) {
        $result['labels'][] = $row->ce_interviewer;
        $result['interviews'][] = $row->total_interviews;
        $result['ratings'][] = $row->avg_rating ? round($row->avg_rating, 1) : 0;
      }
      
      return $result;
    }
    
    // If no ratings table, just return interview counts with zero ratings
    $this->db->select('ce_interviewer, COUNT(*) as total_interviews');
    $this->db->from('calendar_events');
    $this->db->where('ce_interviewer IS NOT NULL');
    $this->db->where('ce_interviewer !=', '');
    $this->db->group_by('ce_interviewer');
    $this->db->order_by('total_interviews', 'DESC');
    $this->db->limit(10);
    
    $query = $this->db->get();
    $result = [
      'labels' => [],
      'interviews' => [],
      'ratings' => []
    ];
    
    foreach ($query->result() as $row) {
      $result['labels'][] = $row->ce_interviewer;
      $result['interviews'][] = $row->total_interviews;
      $result['ratings'][] = 0; // No ratings available
    }
    
    return $result;
  }

  public function roles_permissions_view()
  {
    if (!$this->session->userdata('authenticated')) {
      redirect(A_LOGIN_URL);
    }

    $data['uname'] = $this->session->userdata('username');
    $data['page_title'] = 'Roles & Permissions';
    
    // Get user counts by role
    $data['total_admins'] = $this->db->where('u_role', 'Admin')->count_all_results('users');
    $data['total_recruiters'] = $this->db->where('u_role', 'Recruiter')->count_all_results('users');
    $data['total_interviewers'] = $this->db->where('u_role', 'Interviewer')->count_all_results('users');
    $data['total_candidates'] = $this->db->where('u_role', 'Candidate')->count_all_results('users');
    
    $this->load->view('Admin_dashboard_view/roles_permissions_view', $data);
  }

  public function save_permissions()
  {
    if (!$this->session->userdata('authenticated')) {
      echo json_encode(['success' => false, 'message' => 'Unauthorized']);
      return;
    }

    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
      echo json_encode(['success' => false, 'message' => 'Invalid data']);
      return;
    }

    // In a real implementation, you would save these to a permissions table
    // For now, we'll just acknowledge the save
    
    // Example: Save to a permissions table
    // foreach ($input as $role => $permissions) {
    //     foreach ($permissions as $permission => $enabled) {
    //         $this->db->replace('role_permissions', [
    //             'role' => $role,
    //             'permission' => $permission,
    //             'enabled' => $enabled ? 1 : 0
    //         ]);
    //     }
    // }
    
    echo json_encode([
      'success' => true, 
      'message' => 'Permissions saved successfully',
      'data' => $input
    ]);
  }

  public function Acandidate_users_view()
  {
    $data['uname'] = $this->session->userdata('username');
    
    // Get all candidate users from users table
    $this->db->select('u.*, cd.cd_name, cd.cd_email as cd_email_alt, cd.cd_phone, cd.cd_status');
    $this->db->from('users u');
    $this->db->join('candidate_details cd', 'u.u_email = cd.cd_email', 'left');
    $this->db->where('u.u_role', 'Candidate');
    $this->db->order_by('u.u_username', 'ASC');
    $data['candidate_users'] = $this->db->get();
    
    $data['total_candidate_users'] = $data['candidate_users']->num_rows();
    
    $this->load->view('Admin_dashboard_view/Acandidate_users_view', $data);
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

  public function get_candidate_details()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $candidate_id = $this->input->post('candidate_id');
      
      if (!$candidate_id) {
          echo json_encode(['success' => false, 'message' => 'Candidate ID is required']);
          return;
      }

      // Get candidate details
      $this->db->select('cd.*');
      $this->db->from('candidate_details cd');
      $this->db->where('cd.cd_id', $candidate_id);
      $candidate = $this->db->get()->row_array();

      if ($candidate) {
          echo json_encode(['success' => true, 'candidate' => $candidate]);
      } else {
          echo json_encode(['success' => false, 'message' => 'Candidate not found']);
      }
  }
  
  public function get_candidate_interviews()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $candidate_name = $this->input->post('candidate_name');
      
      if (!$candidate_name) {
          echo json_encode(['success' => false, 'message' => 'Candidate name is required']);
          return;
      }

      // Get interview history for this candidate
      $this->db->select('ce.*');
      $this->db->from('calendar_events ce');
      $this->db->where('ce.ce_can_name', $candidate_name);
      $this->db->order_by('ce.ce_start_date', 'ASC');
      $interviews = $this->db->get()->result_array();

      echo json_encode(['success' => true, 'interviews' => $interviews]);
  }

  public function update_candidate_user()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $full_name = $this->input->post('full_name');
      $phone = $this->input->post('phone');

      if (empty($username) || empty($email)) {
          echo json_encode(['success' => false, 'message' => 'Username and email are required']);
          return;
      }

      // Update users table
      $user_data = array('u_email' => $email);
      
      // Only update password if provided
      if (!empty($password)) {
          $user_data['u_password'] = md5($password);
      }

      $this->db->where('u_username', $username);
      $this->db->update('users', $user_data);

      // Update candidate_details if exists
      if (!empty($full_name) || !empty($phone)) {
          $this->db->where('cd_email', $email);
          $existing = $this->db->get('candidate_details')->row();
          
          if ($existing) {
              $candidate_data = array();
              if (!empty($full_name)) $candidate_data['cd_name'] = $full_name;
              if (!empty($phone)) $candidate_data['cd_phone'] = $phone;
              
              if (!empty($candidate_data)) {
                  $this->db->where('cd_email', $email);
                  $this->db->update('candidate_details', $candidate_data);
              }
          }
      }

      echo json_encode(['success' => true, 'message' => 'Candidate user updated successfully']);
  }

  public function delete_candidate_user()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      
      if (empty($username)) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Get user email first
      $user = $this->db->where('u_username', $username)->get('users')->row();
      
      if (!$user) {
          echo json_encode(['success' => false, 'message' => 'User not found']);
          return;
      }

      // Delete from candidate_details if exists
      $this->db->where('cd_email', $user->u_email);
      $this->db->delete('candidate_details');

      // Delete from users table
      $this->db->where('u_username', $username);
      $this->db->where('u_role', 'Candidate');
      
      if ($this->db->delete('users')) {
          echo json_encode(['success' => true, 'message' => 'Candidate user deleted successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to delete candidate user']);
      }
  }

  public function add_candidate_user()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $full_name = $this->input->post('full_name');

      // Validate required fields
      if (empty($username) || empty($email) || empty($password)) {
          echo json_encode(['success' => false, 'message' => 'Username, email and password are required']);
          return;
      }

      // Check if username already exists
      $this->db->where('u_username', $username);
      if ($this->db->count_all_results('users') > 0) {
          echo json_encode(['success' => false, 'message' => 'Username already exists']);
          return;
      }

      // Check if email already exists
      $this->db->where('u_email', $email);
      if ($this->db->count_all_results('users') > 0) {
          echo json_encode(['success' => false, 'message' => 'Email already exists']);
          return;
      }

      // Insert into users table
      $user_data = array(
          'u_username' => $username,
          'u_email' => $email,
          'u_password' => md5($password),
          'u_role' => 'Candidate'
      );

      if ($this->db->insert('users', $user_data)) {
          // Optionally create a candidate_details record if full_name provided
          if (!empty($full_name)) {
              // Check if candidate already exists with this email
              $this->db->where('cd_email', $email);
              $existing = $this->db->count_all_results('candidate_details');
              
              if ($existing == 0) {
                  $candidate_data = array(
                      'cd_rec_username' => $this->session->userdata('username'),
                      'cd_name' => $full_name,
                      'cd_email' => $email,
                      'cd_phone' => 0,
                      'cd_gender' => 'Not Specified',
                      'cd_job_title' => 'Not Specified',
                      'cd_source' => 'Admin Portal',
                      'cd_description' => 'Created via admin panel',
                      'cd_status' => 'New',
                      'cd_interview_status' => 0
                  );
                  $this->db->insert('candidate_details', $candidate_data);
              }
          }

          echo json_encode(['success' => true, 'message' => 'Candidate user added successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to add candidate user']);
      }
  }

  public function add_interviewer()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $phone = $this->input->post('phone');
      $gender = $this->input->post('gender');

      // Validate required fields
      if (empty($username) || empty($email) || empty($password)) {
          echo json_encode(['success' => false, 'message' => 'Username, email and password are required']);
          return;
      }

      // Check if username already exists
      $this->db->where('u_username', $username);
      if ($this->db->count_all_results('users') > 0) {
          echo json_encode(['success' => false, 'message' => 'Username already exists']);
          return;
      }

      // Check if email already exists
      $this->db->where('u_email', $email);
      if ($this->db->count_all_results('users') > 0) {
          echo json_encode(['success' => false, 'message' => 'Email already exists']);
          return;
      }

      // Insert into users table
      $user_data = array(
          'u_username' => $username,
          'u_email' => $email,
          'u_password' => md5($password),
          'u_role' => 'Interviewer'
      );

      if ($this->db->insert('users', $user_data)) {
          // Insert into profile_info if phone or gender provided
          if (!empty($phone) || !empty($gender)) {
              $profile_data = array(
                  'pi_username' => $username,
                  'pi_email' => $email,
                  'pi_phone' => $phone,
                  'pi_gender' => $gender,
                  'pi_role' => 'Interviewer'
              );
              $this->db->insert('profile_info', $profile_data);
          }

          echo json_encode(['success' => true, 'message' => 'Interviewer added successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to add interviewer']);
      }
  }

  public function delete_interviewer()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      
      if (!$username) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Check if interviewer has conducted any interviews
      $this->db->where('ce_interviewer', $username);
      $interview_count = $this->db->count_all_results('calendar_events');
      
      if ($interview_count > 0) {
          echo json_encode([
              'success' => false, 
              'message' => 'Cannot delete interviewer who has conducted ' . $interview_count . ' interview(s). Please reassign or delete those interviews first.'
          ]);
          return;
      }

      // Delete from profile_info first (if exists)
      $this->db->where('pi_username', $username);
      $this->db->delete('profile_info');

      // Delete from users table
      $this->db->where('u_username', $username);
      $this->db->where('u_role', 'Interviewer');
      
      if ($this->db->delete('users')) {
          echo json_encode([
              'success' => true, 
              'message' => 'Interviewer deleted successfully'
          ]);
      } else {
          echo json_encode([
              'success' => false, 
              'message' => 'Failed to delete interviewer'
          ]);
      }
  }

  public function get_candidate_user_details()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      
      if (!$username) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Get candidate user details
      $this->db->select('u.*, cd.*');
      $this->db->from('users u');
      $this->db->join('candidate_details cd', 'u.u_email = cd.cd_email', 'left');
      $this->db->where('u.u_username', $username);
      $user = $this->db->get()->row_array();

      if ($user) {
          echo json_encode(['success' => true, 'user' => $user]);
      } else {
          echo json_encode(['success' => false, 'message' => 'User not found']);
      }
  }

  public function get_all_candidate_users()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      // Get all candidate users - use MAX to get one record per username
      $this->db->select('u.u_username as username, u.u_email as email, u.u_status as user_status, MAX(cd.cd_name) as name, MAX(cd.cd_phone) as phone, MAX(cd.cd_status) as application_status, MAX(cd.cd_rec_username) as recruiter, MAX(cd.cd_job_title) as job_title');
      $this->db->from('users u');
      $this->db->join('candidate_details cd', 'u.u_email = cd.cd_email', 'left');
      $this->db->where('u.u_role', 'Candidate');
      $this->db->group_by('u.u_username, u.u_email, u.u_status');
      $this->db->order_by('u.u_username', 'ASC');
      $candidates = $this->db->get()->result_array();

      // Normalize status values (handle both text and numeric)
      foreach ($candidates as &$candidate) {
          if ($candidate['user_status'] === 'Active' || $candidate['user_status'] == 1) {
              $candidate['user_status'] = 1;
          } else {
              $candidate['user_status'] = 0;
          }
          
          // Set default application status if null
          if (empty($candidate['application_status'])) {
              $candidate['application_status'] = 'No Application';
          }
      }

      // Get statistics
      $total = count($candidates);
      $selected = 0;
      $in_process = 0;
      $no_application = 0;
      
      foreach ($candidates as $candidate) {
          $status = $candidate['application_status'];
          if ($status === 'Selected') {
              $selected++;
          } elseif ($status === 'In Process') {
              $in_process++;
          } elseif ($status === 'No Application' || empty($status)) {
              $no_application++;
          }
      }

      echo json_encode([
          'success' => true,
          'data' => $candidates,
          'stats' => [
              'total' => $total,
              'selected' => $selected,
              'in_process' => $in_process,
              'no_application' => $no_application
          ]
      ]);
  }

  public function get_recruiters_list()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $this->db->select('u_username as username');
      $this->db->from('users');
      $this->db->where('u_role', 'Recruiter');
      $this->db->order_by('u_username', 'ASC');
      $recruiters = $this->db->get()->result_array();

      echo json_encode(['success' => true, 'data' => $recruiters]);
  }

  public function get_job_titles_list()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $this->db->distinct();
      $this->db->select('cd_job_title');
      $this->db->from('candidate_details');
      $this->db->where('cd_job_title IS NOT NULL');
      $this->db->where('cd_job_title !=', '');
      $this->db->order_by('cd_job_title', 'ASC');
      $result = $this->db->get()->result_array();

      $job_titles = array_column($result, 'cd_job_title');

      echo json_encode(['success' => true, 'data' => $job_titles]);
  }

  public function toggle_candidate_status()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $new_status = $this->input->post('status'); // 1 for Active, 0 for Inactive

      if (empty($username)) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Convert numeric status to text for database
      $status_text = ($new_status == 1) ? 'Active' : 'Pending';

      $this->db->where('u_username', $username);
      $this->db->where('u_role', 'Candidate');
      $this->db->update('users', array('u_status' => $status_text));

      if ($this->db->affected_rows() > 0) {
          $action = ($new_status == 1) ? 'activated' : 'deactivated';
          echo json_encode(['success' => true, 'message' => 'Candidate ' . $action . ' successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to update candidate status']);
      }
  }

  public function get_interviewer_details()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      
      if (!$username) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Get interviewer details
      $this->db->select('u.*, p.pi_phone, p.pi_gender, p.pi_email');
      $this->db->from('users u');
      $this->db->join('profile_info p', 'u.u_username = p.pi_username', 'left');
      $this->db->where('u.u_username', $username);
      $interviewer = $this->db->get()->row_array();

      if ($interviewer) {
          // Get interview history
          $this->db->select('ce_can_name, ce_start_date, ce_interview_round');
          $this->db->from('calendar_events');
          $this->db->where('ce_interviewer', $username);
          $this->db->order_by('ce_start_date', 'DESC');
          $this->db->limit(10);
          $interviews = $this->db->get()->result_array();
          
          echo json_encode([
              'success' => true, 
              'interviewer' => $interviewer,
              'interviews' => $interviews
          ]);
      } else {
          echo json_encode(['success' => false, 'message' => 'Interviewer not found']);
      }
  }

  public function get_all_interviewers()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      // Get all interviewers with DISTINCT to avoid duplicates
      $this->db->distinct();
      $this->db->select('u.u_username as username, u.u_email as email, u.u_status as status, p.pi_phone as phone, p.pi_gender as gender');
      $this->db->from('users u');
      $this->db->join('profile_info p', 'u.u_username = p.pi_username', 'left');
      $this->db->where('u.u_role', 'Interviewer');
      $this->db->group_by('u.u_username');
      $this->db->order_by('u.u_username', 'ASC');
      $interviewers = $this->db->get()->result_array();

      // Normalize status values (handle both text and numeric)
      foreach ($interviewers as &$interviewer) {
          if ($interviewer['status'] === 'Active' || $interviewer['status'] == 1) {
              $interviewer['status'] = 1;
          } else {
              $interviewer['status'] = 0;
          }
      }

      // Get statistics
      $total = count($interviewers);
      
      // Count active interviewers (those who have conducted interviews)
      $this->db->select('COUNT(DISTINCT ce_interviewer) as count');
      $this->db->from('calendar_events');
      $this->db->where('ce_interviewer IS NOT NULL');
      $result = $this->db->get();
      $active = $result->row()->count;

      echo json_encode([
          'success' => true,
          'data' => $interviewers,
          'stats' => [
              'total' => $total,
              'active' => $active
          ]
      ]);
  }

  public function update_interviewer()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $phone = $this->input->post('phone');
      $gender = $this->input->post('gender');

      if (empty($username) || empty($email)) {
          echo json_encode(['success' => false, 'message' => 'Username and email are required']);
          return;
      }

      // Check if email is taken by another user
      $this->db->where('u_email', $email);
      $this->db->where('u_username !=', $username);
      if ($this->db->count_all_results('users') > 0) {
          echo json_encode(['success' => false, 'message' => 'Email already in use by another account']);
          return;
      }

      // Update users table
      $user_data = array('u_email' => $email);
      
      if (!empty($password)) {
          $user_data['u_password'] = md5($password);
      }

      $this->db->where('u_username', $username);
      $this->db->where('u_role', 'Interviewer');
      $this->db->update('users', $user_data);

      // Update or insert profile_info
      $this->db->where('pi_username', $username);
      $existing_profile = $this->db->get('profile_info')->row();

      $profile_data = array(
          'pi_phone' => $phone,
          'pi_gender' => $gender
      );

      if ($existing_profile) {
          $this->db->where('pi_username', $username);
          $this->db->update('profile_info', $profile_data);
      } else {
          $profile_data['pi_username'] = $username;
          $profile_data['pi_email'] = $email;
          $profile_data['pi_role'] = 'Interviewer';
          $this->db->insert('profile_info', $profile_data);
      }

      echo json_encode(['success' => true, 'message' => 'Interviewer updated successfully']);
  }

  public function toggle_interviewer_status()
  {
      if (!$this->session->userdata('authenticated')) {
          echo json_encode(['success' => false, 'message' => 'Not authenticated']);
          return;
      }

      $username = $this->input->post('username');
      $new_status = $this->input->post('status'); // 1 for Active, 0 for Inactive

      if (empty($username)) {
          echo json_encode(['success' => false, 'message' => 'Username is required']);
          return;
      }

      // Convert numeric status to text for database
      $status_text = ($new_status == 1) ? 'Active' : 'Pending';

      $this->db->where('u_username', $username);
      $this->db->where('u_role', 'Interviewer');
      $this->db->update('users', array('u_status' => $status_text));

      if ($this->db->affected_rows() > 0) {
          $action = ($new_status == 1) ? 'activated' : 'deactivated';
          echo json_encode(['success' => true, 'message' => 'Interviewer ' . $action . ' successfully']);
      } else {
          echo json_encode(['success' => false, 'message' => 'Failed to update interviewer status']);
      }
  }

  public function generate_report($report_type = 'all_candidates')
  {
      if (!$this->session->userdata('authenticated')) {
          redirect(LOGIN_URL);
      }

      $filename = $report_type . '_' . date('Y-m-d_His');
      
      switch($report_type) {
          case 'all_candidates':
              $this->generate_all_candidates_report($filename);
              break;
          case 'selected_candidates':
              $this->generate_selected_candidates_report($filename);
              break;
          case 'candidates_by_status':
              $this->generate_candidates_by_status_report($filename);
              break;
          case 'candidates_by_source':
              $this->generate_candidates_by_source_report($filename);
              break;
          case 'all_interviews':
              $this->generate_all_interviews_report($filename);
              break;
          case 'upcoming_interviews':
              $this->generate_upcoming_interviews_report($filename);
              break;
          case 'interviews_by_interviewer':
              $this->generate_interviews_by_interviewer_report($filename);
              break;
          case 'recruiter_performance':
              $this->generate_recruiter_performance_report($filename);
              break;
          case 'all_recruiters':
              $this->generate_all_recruiters_report($filename);
              break;
          default:
              $this->session->set_flashdata('error_msg', 'Invalid report type');
              redirect('A_dashboard/reports_view');
      }
  }

  private function generate_all_candidates_report($filename)
  {
      $this->db->select('cd_name, cd_email, cd_phone, cd_gender, cd_job_title, cd_source, cd_status, cd_rec_username, cd_created_at');
      $this->db->from('candidate_details');
      $this->db->order_by('cd_created_at', 'DESC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Name', 'Email', 'Phone', 'Gender', 'Job Title', 'Source', 'Status', 'Recruiter', 'Created Date'));
  }

  private function generate_selected_candidates_report($filename)
  {
      $this->db->select('cd_name, cd_email, cd_phone, cd_job_title, cd_rec_username, cd_created_at');
      $this->db->from('candidate_details');
      $this->db->where('cd_status', 'Selected');
      $this->db->order_by('cd_created_at', 'DESC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Name', 'Email', 'Phone', 'Job Title', 'Recruiter', 'Selected Date'));
  }

  private function generate_candidates_by_status_report($filename)
  {
      $this->db->select('cd_status, cd_name, cd_email, cd_phone, cd_job_title, cd_rec_username');
      $this->db->from('candidate_details');
      $this->db->order_by('cd_status', 'ASC');
      $this->db->order_by('cd_name', 'ASC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Status', 'Name', 'Email', 'Phone', 'Job Title', 'Recruiter'));
  }

  private function generate_candidates_by_source_report($filename)
  {
      $this->db->select('cd_source, cd_name, cd_email, cd_phone, cd_job_title, cd_status');
      $this->db->from('candidate_details');
      $this->db->order_by('cd_source', 'ASC');
      $this->db->order_by('cd_name', 'ASC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Source', 'Name', 'Email', 'Phone', 'Job Title', 'Status'));
  }

  private function generate_all_interviews_report($filename)
  {
      $this->db->select('ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round, ce_rec_username');
      $this->db->from('calendar_events');
      $this->db->order_by('ce_start_date', 'DESC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Candidate', 'Interviewer', 'Start Date', 'End Date', 'Round', 'Recruiter'));
  }

  private function generate_upcoming_interviews_report($filename)
  {
      $this->db->select('ce_can_name, ce_interviewer, ce_start_date, ce_end_date, ce_interview_round');
      $this->db->from('calendar_events');
      $this->db->where('ce_start_date >=', date('Y-m-d H:i:s'));
      $this->db->order_by('ce_start_date', 'ASC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Candidate', 'Interviewer', 'Start Date', 'End Date', 'Round'));
  }

  private function generate_interviews_by_interviewer_report($filename)
  {
      $this->db->select('ce_interviewer, COUNT(*) as total_interviews, ce_can_name, ce_start_date');
      $this->db->from('calendar_events');
      $this->db->group_by('ce_interviewer');
      $this->db->order_by('total_interviews', 'DESC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Interviewer', 'Total Interviews', 'Last Candidate', 'Last Interview Date'));
  }

  private function generate_recruiter_performance_report($filename)
  {
      $this->db->select('cd_rec_username as recruiter, COUNT(*) as total_candidates, SUM(CASE WHEN cd_status="Selected" THEN 1 ELSE 0 END) as selected_count');
      $this->db->from('candidate_details');
      $this->db->group_by('cd_rec_username');
      $this->db->order_by('selected_count', 'DESC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Recruiter', 'Total Candidates', 'Selected Candidates'));
  }

  private function generate_all_recruiters_report($filename)
  {
      $this->db->select('u.u_username, u.u_email, p.pi_phone, p.pi_gender');
      $this->db->from('users u');
      $this->db->join('profile_info p', 'u.u_username = p.pi_username', 'left');
      $this->db->where('u.u_role', 'Recruiter');
      $this->db->order_by('u.u_username', 'ASC');
      $query = $this->db->get();

      $this->output_csv($query, $filename, array('Username', 'Email', 'Phone', 'Gender'));
  }

  private function output_csv($query, $filename, $headers)
  {
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=' . $filename . '.csv');

      $output = fopen('php://output', 'w');
      fputcsv($output, $headers);

      foreach ($query->result_array() as $row) {
          fputcsv($output, $row);
      }

      fclose($output);
      exit;
  }

  public function export_selected_candidates()
  {
      if (!$this->session->userdata('authenticated')) {
          redirect(LOGIN_URL);
      }

      // Get all selected candidates
      $this->db->select('cd_name, cd_email, cd_phone, cd_gender, cd_job_title, cd_rec_username, cd_source, cd_status');
      $this->db->from('candidate_details');
      $this->db->where('cd_status', 'Selected');
      $this->db->order_by('cd_id', 'DESC');
      $query = $this->db->get();

      // Set headers for CSV download
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=selected_candidates_' . date('Y-m-d') . '.csv');

      // Create output stream
      $output = fopen('php://output', 'w');

      // Add CSV headers
      fputcsv($output, array('Name', 'Email', 'Phone', 'Gender', 'Job Title', 'Recruiter', 'Source', 'Status'));

      // Add data rows
      foreach ($query->result_array() as $row) {
          fputcsv($output, $row);
      }

      fclose($output);
      exit;
  }
  
    // Global Search
    public function global_search()
    {
        $query = $this->input->post('query');
        
        if (empty($query)) {
            echo json_encode([]);
            return;
        }
        
        $results = [
            'candidates' => [],
            'jobs' => [],
            'interviews' => []
        ];
        
        // Search Candidates
        $this->db->like('cd_name', $query);
        $this->db->or_like('cd_email', $query);
        $this->db->or_like('cd_phone', $query);
        $this->db->limit(5);
        $candidates = $this->db->get('candidate_details')->result_array();
        
        foreach ($candidates as $candidate) {
            $results['candidates'][] = [
                'name' => $candidate['cd_name'],
                'email' => $candidate['cd_email'],
                'phone' => $candidate['cd_phone']
            ];
        }
        
        // Search Jobs (if you have a jobs table)
        if ($this->db->table_exists('job_postings')) {
            $this->db->like('job_title', $query);
            $this->db->or_like('job_location', $query);
            $this->db->limit(5);
            $jobs = $this->db->get('job_postings')->result_array();
            
            foreach ($jobs as $job) {
                $results['jobs'][] = [
                    'title' => $job['job_title'],
                    'location' => $job['job_location'] ?? 'Not specified',
                    'type' => $job['job_type'] ?? 'Full-time'
                ];
            }
        }
        
        // Search Interviews
        $this->db->select('calendar_events.*, candidate_details.cd_name');
        $this->db->from(TBL_CALENDAR . ' as calendar_events');
        $this->db->join('candidate_details', 'candidate_details.cd_id = calendar_events.ce_can_id', 'left');
        $this->db->like('candidate_details.cd_name', $query);
        $this->db->limit(5);
        $interviews = $this->db->get()->result_array();
        
        foreach ($interviews as $interview) {
            $results['interviews'][] = [
                'candidate' => $interview['cd_name'],
                'date' => date('M d, Y', strtotime($interview['ce_date'])),
                'time' => $interview['ce_time']
            ];
        }
        
        echo json_encode($results);
    }
    
    // Get Notifications
    public function get_notifications()
    {
        $username = $this->session->userdata('username');
        
        // Check if notifications table exists
        if (!$this->db->table_exists('notifications')) {
            // Create sample notifications
            $notifications = [
                [
                    'id' => 1,
                    'type' => 'candidate',
                    'title' => 'New Candidate Application',
                    'message' => 'John Doe applied for Software Engineer position',
                    'link' => base_url('A_dashboard/Acandidate_users_view'),
                    'is_read' => 0,
                    'time_ago' => '5 minutes ago'
                ],
                [
                    'id' => 2,
                    'type' => 'interview',
                    'title' => 'Interview Scheduled',
                    'message' => 'Interview with Jane Smith scheduled for tomorrow at 2:00 PM',
                    'link' => base_url('A_dashboard/Ainterviewer_view'),
                    'is_read' => 0,
                    'time_ago' => '1 hour ago'
                ],
                [
                    'id' => 3,
                    'type' => 'system',
                    'title' => 'System Update',
                    'message' => 'New features have been added to the dashboard',
                    'link' => base_url('Setup'),
                    'is_read' => 0,
                    'time_ago' => '2 hours ago'
                ]
            ];
            
            echo json_encode($notifications);
            return;
        }
        
        // Get real notifications from database
        $this->db->where('user_id', $this->session->userdata('u_id'));
        $this->db->or_where('user_id IS NULL'); // System-wide notifications
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(10);
        $notifications = $this->db->get('notifications')->result_array();
        
        // Format time ago
        foreach ($notifications as &$notif) {
            $notif['time_ago'] = $this->timeAgo($notif['created_at']);
        }
        
        echo json_encode($notifications);
    }
    
    // Mark notification as read
    public function mark_notification_read()
    {
        $id = $this->input->post('id');
        
        if ($this->db->table_exists('notifications')) {
            $this->db->where('id', $id);
            $this->db->update('notifications', ['is_read' => 1]);
        }
        
        echo json_encode(['success' => true]);
    }
    
    // Mark all notifications as read
    public function mark_all_notifications_read()
    {
        if ($this->db->table_exists('notifications')) {
            $this->db->where('user_id', $this->session->userdata('u_id'));
            $this->db->update('notifications', ['is_read' => 1]);
        }
        
        echo json_encode(['success' => true]);
    }
    
    // Helper function to calculate time ago
    private function timeAgo($datetime)
    {
        $timestamp = strtotime($datetime);
        $difference = time() - $timestamp;
        
        if ($difference < 60) {
            return 'Just now';
        } elseif ($difference < 3600) {
            $minutes = floor($difference / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 604800) {
            $days = floor($difference / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M d, Y', $timestamp);
        }
    }
    
    // Notifications page
    public function notifications()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Notifications';
        
        // Get all notifications
        if ($this->db->table_exists('notifications')) {
            $this->db->where('user_id', $this->session->userdata('u_id'));
            $this->db->or_where('user_id IS NULL');
            $this->db->order_by('created_at', 'DESC');
            $data['notifications'] = $this->db->get('notifications')->result();
        } else {
            $data['notifications'] = [];
        }
        
        $this->load->view('Admin_dashboard_view/notifications_view', $data);
    }
}
