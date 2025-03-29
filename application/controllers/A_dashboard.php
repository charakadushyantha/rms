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
    //print_r($data);
     $this->load->view('Admin_dashboard_view/Adashboard',$data);
  }

  public function Acalendar_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $this->load->view('Admin_dashboard_view/Acalendar',$data);

  }

  public function Arecruiter_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $this->load->view('Admin_dashboard_view/Arecruiter',$data);
  }

  public function Aaccount_details_view()
  {
    $data['uname'] = $this->session->userdata('username');
    if($this->profile_record_model->check_admin_details($data))
    {
      $data['admin_details'] = $this->profile_record_model->check_admin_details($data);
    }
    $this->load->view('Admin_dashboard_view/Aaccount_details',$data);
  }

  public function Ascandidate_view()
  {
    $data['uname'] = $this->session->userdata('username');
    $data['can_details']=$this->Candidate_model->get_selected_all_candidate($data);
    $this->load->view('Admin_dashboard_view/Asele_candidate',$data);
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

  public function Areports_view()
  {
      $data['uname'] = $this->session->userdata('username');
      
      // Temporary dummy data
      $data['job_stats'] = array(
          array('cd_job_title' => 'Software Developer', 'total_count' => 15, 'shortlisted' => 8, 'selected' => 3, 'in_review' => 4),
          array('cd_job_title' => 'UI/UX Designer', 'total_count' => 10, 'shortlisted' => 5, 'selected' => 2, 'in_review' => 3)
      );
      
      $data['interview_stats'] = array(
          array('ce_rec_username' => 'recruiter1', 'ce_interview_round' => 0.25, 'total_interviews' => 12),
          array('ce_rec_username' => 'recruiter1', 'ce_interview_round' => 0.5, 'total_interviews' => 8),
          array('ce_rec_username' => 'recruiter2', 'ce_interview_round' => 0.25, 'total_interviews' => 10)
      );
      
      $data['recruiter_stats'] = array(
          array('u_username' => 'recruiter1', 'u_email' => 'rec1@example.com', 'total_candidates' => 25, 'candidates_selected' => 8),
          array('u_username' => 'recruiter2', 'u_email' => 'rec2@example.com', 'total_candidates' => 18, 'candidates_selected' => 5)
      );
      
      $this->load->view('Admin_dashboard_view/Areports', $data);
  }

}


 ?>
