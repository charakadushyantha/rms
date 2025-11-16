<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R_dashboard extends CI_Controller
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
      $data['can_details']=$this->Candidate_model->get_selected_candidate($data);
      $data['last_can'] = $this->Candidate_model->last_candidate($data);
      $data['rtotal'] = $this->Calendar_model->count_all($data);
      $data['r1'] = $this->Calendar_model->count_can($data,0.25);
      $data['r2'] = $this->Calendar_model->count_can($data,0.5);
      $data['r3'] = $this->Calendar_model->count_can($data,0.75);
      $data['rc'] = $this->Calendar_model->count_can($data,1);
      $this->load->view('Recruiter_dashboard_view/Rdashboard',$data);
    }

    public function count_can()
    {
      $data['uname'] = $this->session->userdata('username');
      $data['rtotal'] = $this->Calendar_model->count_all($data);
      $data['r1'] = $this->Calendar_model->count_can($data,0.25);
      $data['r2'] = $this->Calendar_model->count_can($data,0.5);
      $data['r3'] = $this->Calendar_model->count_can($data,0.75);
      $data['rc'] = $this->Calendar_model->count_can($data,1);

    }

    public function Rcalendar_view()
    {
      $data['uname'] = $this->session->userdata('username');
      $this->load->view('Recruiter_dashboard_view/Rcalendar_new',$data); // Using new modern UI
      // To use old design: $this->load->view('Recruiter_dashboard_view/Rcalendar',$data);
    }

    public function Rcandidate_view()
    {
      $data['uname'] = $this->session->userdata('username');
      $data['page_title'] = 'Add Candidate';
      $this->load->view('templates/recruiter_header', $data);
      $this->load->view('Recruiter_dashboard_view/Rcandidate_content',$data);
      $this->load->view('templates/recruiter_footer', $data);
    }

    public function add_candidate_process()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(base_url('Login'));
        }

        $username = $this->session->userdata('username');
        
        // Handle file upload if resume is provided
        $resume_filename = '';
        if (!empty($_FILES['resume']['name'])) {
            $config['upload_path'] = './uploads/resumes/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('resume')) {
                $upload_data = $this->upload->data();
                $resume_filename = $upload_data['file_name'];
            }
        }

        // Prepare candidate data
        $candidate_data = array(
            'cd_rec_username' => $username,
            'cd_name' => $this->input->post('candidate_name'),
            'cd_email' => $this->input->post('candidate_email'),
            'cd_phone' => $this->input->post('candidate_phone'),
            'cd_gender' => $this->input->post('candidate_gender'),
            'cd_job_title' => $this->input->post('job_title'),
            'cd_source' => $this->input->post('source'),
            'cd_description' => $this->input->post('current_status'),
            'cd_status' => $this->input->post('candidate_status'),
            'cd_interview_status' => 0
        );

        if (!empty($resume_filename)) {
            $candidate_data['cd_resume_link'] = $resume_filename;
        }

        // Insert candidate
        if ($this->db->insert('candidate_details', $candidate_data)) {
            $this->session->set_flashdata('success_msg', 'Candidate added successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to add candidate. Please try again.');
        }

        redirect('R_dashboard/Rcandidate_view');
    }

    public function Rstatus_view()
    {
      $data['uname'] = $this->session->userdata('username');
      $data['can_details']=$this->Candidate_model->get_candidate($data);
      $data['page_title'] = 'Pipeline';
      $this->load->view('templates/recruiter_header', $data);
      $this->load->view('Recruiter_dashboard_view/Rstatus_content',$data);
      $this->load->view('templates/recruiter_footer', $data);
    }

    public function Raccount_details_view()
    {
      $data['uname'] = $this->session->userdata('username');
      
      // Get user details including profile picture from users table
      $user_data = $this->db->select('u_email, profile_picture')
                            ->where('u_username', $data['uname'])
                            ->get(TBL_USERS)
                            ->row();
      
      // Get additional profile details if exists
      if($this->profile_record_model->check_rec_details($data))
      {
        $profile_details = $this->profile_record_model->check_rec_details($data);
        if(!empty($profile_details)) {
          $profile_details = is_array($profile_details) ? $profile_details[0] : $profile_details;
          $data['recruiter_details'] = (object) array_merge((array)$user_data, (array)$profile_details);
        } else {
          $data['recruiter_details'] = $user_data;
        }
      } else {
        $data['recruiter_details'] = $user_data;
      }
      
      $data['page_title'] = 'My Account';
      $this->load->view('templates/recruiter_header', $data);
      $this->load->view('Recruiter_dashboard_view/Raccount_details_content',$data);
      $this->load->view('templates/recruiter_footer', $data);
    }

    public function Rscandidate_view()
    {
      $data['uname'] = $this->session->userdata('username');
      $data['can_details']=$this->Candidate_model->get_selected_candidate($data);
      $data['page_title'] = 'Selected Candidates';
      $this->load->view('templates/recruiter_header', $data);
      $this->load->view('Recruiter_dashboard_view/Rscandidate_content',$data);
      $this->load->view('templates/recruiter_footer', $data);
    }

    public function Rschedule_view()
    {
      // Redirect to pipeline page where scheduling is done via modal
      $this->session->set_flashdata('info_msg', 'Select a candidate from the list below to schedule an interview.');
      redirect('R_dashboard/Rstatus_view');
    }

    public function schedule_proc()
    {
      if($this->Candidate_model->check_status())
      {
        if($this->Calendar_model->add_event())
        {
          $this->Candidate_model->update_interview_status();
          $this->session->set_flashdata('success_msg', 'Interview scheduled successfully!');
          redirect(R_CALENDAR_URL);
        }
        else {
          $this->session->set_flashdata('msg', 'Failed to schedule interview. Please try again.');
          redirect(R_SCHEDULE_URL);
        }
      }
      else {
        $this->session->set_flashdata('msg','Entered Candidate is not interested for interview or Not Picking up Call');
        redirect(R_SCHEDULE_URL);
      }
    }

    public function get_events()
    {
    $data = array();
    $uname = $this->session->userdata('username');
    $result = $this->Calendar_model->get_event($uname);
    foreach($result->result_array() as $row)
    {


      $data[]=array(
        'id' => $row['ce_id'],
        'title' => $row['ce_can_name'],
        'Interviewer'=>$row['ce_interviewer'],
        'start' => $row['ce_start_date'],
        'end'=>$row['ce_end_date'],
        'interview_round' => $row['ce_interview_round']
      );
    }
    echo json_encode($data);
    }


    public function do_upload()
    {
      $rec_username = $this->session->userdata('username');
      if($this->Candidate_model->upload_can($rec_username))
      {
                if(($this->input->post('can_current_status')) == 'Interested')
                {
                  $data['can_name'] = $this->input->post('cname');
                  $data['uname'] = $this->session->userdata('username');
                  $data['can_id'] = $this->Candidate_model->get_id();
                  $this->load->view('Recruiter_dashboard_view/Rschedule',$data);
                }
                else {
                  $this->Rstatus_view();
                }

      }
      else if($this->input->post('rfile')) {

        $file = $_FILES['resume_file'];
        $fileName = $_FILES['resume_file']['name'];
        $fileTmpName = $_FILES['resume_file']['tmp_name'];
        $fileSize = $_FILES['resume_file']['size'];
        $fileError = $_FILES['resume_file']['error'];
        $fileType = $_FILES['resume_file']['type'];
        $file_ext = explode('.',$fileName);
        $fileActualExt = strtolower(end($file_ext));

        $allowedformat = array( 'pdf', 'doc', 'docx');

        if (in_array($fileActualExt, $allowedformat)) {
            if ($fileError == 0) {
                if($fileSize < 1000000){
                    $fileNewName = ($this->input->post('cname')).".".$fileActualExt;
                    $fileDestination = dirname(__FILE__).'/../../uploads/'.$fileNewName;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    //header("Location: index.php?uploadsuccess");
                }
                else{
                    echo "Your file is too big!";
                }

            } else {
                echo "There was an error uploading your file!";
            }

        }
        else{
            echo "You cannot upload files of this type!";
        }

      }

    }




    public function logout()
    {
        $this->session->sess_destroy();
        redirect(LOGIN_URL);
    }

    public function rec_profile_upload()
    {
      $rec_username = $this->session->userdata('username');
      if($this->profile_record_model->rec_exists($rec_username))
      {
        redirect(R_DASHBOARD_URL);
      }
      else
      {
        $this->profile_record_model->rec_profile();
        redirect(R_DASHBOARD_URL);
      }
    }




    public function calender_update()
    {
      $id = $this->input->post('can_id');
      $delete = intval($this->input->post("delete"));
      if($delete)
      {
        $this->Calendar_model->delete_event($id);
      }
      else {
        $data = array(
          'ce_can_name' => $this->input->post('can_name'),
          'ce_interviewer' => $this->input->post('Interviewer'),
          'ce_start_date' => $this->input->post('start_date'),
          'ce_end_date' => $this->input->post('end_date'),
          'ce_interview_round' => $this->input->post('interview_round')
        );
        $this->Calendar_model->update_event($id,$data);
      }
      redirect(R_CALENDAR_URL);
    }

    public function find_can_details()
    {
      $can_id = $this->input->post('can_id');
      $data = $this->Candidate_model->get_can_by_id($can_id);
      echo json_encode($data[0]);
    }

    public function update_candidate()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $candidate_id = $this->input->post('candidate_id');
        
        $update_data = array(
            'cd_name' => $this->input->post('candidate_name'),
            'cd_email' => $this->input->post('candidate_email'),
            'cd_phone' => $this->input->post('candidate_phone'),
            'cd_job_title' => $this->input->post('job_title'),
            'cd_source' => $this->input->post('source'),
            'cd_status' => $this->input->post('candidate_status')
        );

        $this->db->where('cd_id', $candidate_id);
        
        if ($this->db->update('candidate_details', $update_data)) {
            $this->session->set_flashdata('success_msg', 'Candidate updated successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to update candidate.');
        }

        redirect('R_dashboard/Rstatus_view');
    }

    public function schedule_btn_action()
    {
      $can_id = $this->uri->segment(3);
      // Redirect to pipeline page with candidate ID to auto-open modal
      $this->session->set_flashdata('schedule_candidate_id', $can_id);
      redirect('R_dashboard/Rstatus_view');
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

        redirect('R_dashboard/Raccount_details_view');
    }

    public function update_profile()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $username = $this->session->userdata('username');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $gender = $this->input->post('gender');

        $update_data = array(
            'u_email' => $email
        );

        $this->db->where('u_username', $username);
        $this->db->update(TBL_USERS, $update_data);

        // Update personal info if exists in profile table
        $this->db->where('pi_username', $username);
        $pi_exists = $this->db->get(TBL_PROFILE)->num_rows();

        if ($pi_exists > 0) {
            $this->db->where('pi_username', $username);
            $this->db->update(TBL_PROFILE, array(
                'pi_phone' => $phone,
                'pi_gender' => $gender,
                'pi_email' => $email
            ));
        } else {
            $this->db->insert(TBL_PROFILE, array(
                'pi_username' => $username,
                'pi_phone' => $phone,
                'pi_gender' => $gender,
                'pi_email' => $email,
                'pi_role' => 'Recruiter'
            ));
        }

        $this->session->set_flashdata('success_msg', 'Profile updated successfully!');
        redirect('R_dashboard/Raccount_details_view');
    }

    public function get_candidate_details($candidate_id = null)
    {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        // Get candidate ID from URL parameter or POST data
        if (!$candidate_id) {
            $candidate_id = $this->input->post('candidate_id');
        }

        if (!$candidate_id) {
            echo json_encode(['success' => false, 'message' => 'Candidate ID is required']);
            return;
        }

        $candidate = $this->db->where('cd_id', $candidate_id)
                              ->get('candidate_details')
                              ->row_array();

        if ($candidate) {
            echo json_encode(['success' => true, 'candidate' => $candidate]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Candidate not found']);
        }
    }

    public function schedule_interview()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $candidate_id = $this->input->post('candidate_id');
        $interview_round = $this->input->post('interview_round');
        $interview_date = $this->input->post('interview_date');
        $interview_time = $this->input->post('interview_time');
        $notes = $this->input->post('notes');
        $interviewers = $this->input->post('interviewers'); // Array of interviewer usernames
        $username = $this->session->userdata('username');

        // Get candidate name
        $candidate = $this->db->select('cd_name')
                              ->where('cd_id', $candidate_id)
                              ->get('candidate_details')
                              ->row();

        if (!$candidate) {
            $this->session->set_flashdata('error_msg', 'Candidate not found.');
            redirect('R_dashboard/Rstatus_view');
            return;
        }

        // Format interviewers list
        $interviewers_list = is_array($interviewers) ? implode(', ', $interviewers) : $interviewers;
        $interview_type = (is_array($interviewers) && count($interviewers) > 1) ? 'Panel Interview' : 'Individual Interview';

        // Check if calendar table exists and what columns it has
        $tables = $this->db->list_tables();
        
        if (in_array('calendar_events', $tables) || in_array('calendar', $tables)) {
            // Insert into calendar
            $calendar_data = array(
                'can_id' => $candidate_id,
                'can_name' => $candidate['cd_name'],
                'date' => $interview_date,
                'time' => $interview_time,
                'recruiter' => $username
            );

            // Check if created_at column exists
            $table_name = in_array('calendar_events', $tables) ? 'calendar_events' : 'calendar';
            $fields = $this->db->list_fields($table_name);
            if (in_array('created_at', $fields)) {
                $calendar_data['created_at'] = date('Y-m-d H:i:s');
            }
            if (in_array('notes', $fields)) {
                $calendar_data['notes'] = $notes;
            }
            if (in_array('interviewers', $fields)) {
                $calendar_data['interviewers'] = $interviewers_list;
            }
            if (in_array('interview_type', $fields)) {
                $calendar_data['interview_type'] = $interview_type;
            }

            $this->db->insert($table_name, $calendar_data);
        }

        // Update candidate interview status and round (if column exists)
        $update_data = array('cd_interview_status' => 1);
        
        // Check if cd_interview_round column exists
        $fields = $this->db->list_fields('candidate_details');
        if (in_array('cd_interview_round', $fields)) {
            $update_data['cd_interview_round'] = $interview_round;
        }
        
        $this->db->where('cd_id', $candidate_id);
        $this->db->update('candidate_details', $update_data);

        $interviewer_count = is_array($interviewers) ? count($interviewers) : 1;
        $success_message = $interview_type . ' scheduled successfully with ' . $interviewer_count . ' interviewer(s)!';
        
        $this->session->set_flashdata('success_msg', $success_message);
        redirect('R_dashboard/Rstatus_view');
    }

    public function change_password()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $username = $this->session->userdata('username');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');

        // Verify current password
        $user = $this->db->where('u_username', $username)
                        ->where('u_password', md5($current_password))
                        ->get(TBL_USERS)
                        ->row();

        if ($user) {
            $this->db->where('u_username', $username);
            $this->db->update(TBL_USERS, array('u_password' => md5($new_password)));
            
            $this->session->set_flashdata('success_msg', 'Password changed successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Current password is incorrect!');
        }

        redirect('R_dashboard/Raccount_details_view');
    }

    public function get_interview_details($candidate_id)
    {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        // Get candidate and interview details
        $this->db->select('cd.*, ce.*');
        $this->db->from(TBL_CANDIDATE_DETAILS . ' cd');
        $this->db->join(TBL_CALENDAR . ' ce', 'cd.cd_id = ce.ce_id', 'left');
        $this->db->where('cd.cd_id', $candidate_id);
        $interview = $this->db->get()->row_array();

        if ($interview) {
            echo json_encode(['success' => true, 'interview' => $interview]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Interview not found']);
        }
    }

    public function reschedule_interview()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $candidate_id = $this->input->post('candidate_id');
        $interview_date = $this->input->post('interview_date');
        $interview_time = $this->input->post('interview_time');
        $interview_round = $this->input->post('interview_round');
        $interviewer = $this->input->post('interviewer');

        // Combine date and time
        $start_datetime = $interview_date . ' ' . $interview_time;
        
        // Calculate end time (1 hour later)
        $end_datetime = date('Y-m-d H:i:s', strtotime($start_datetime . ' +1 hour'));

        // Update the interview in calendar
        $update_data = array(
            'ce_start_date' => $start_datetime,
            'ce_end_date' => $end_datetime,
            'ce_interviewer' => $interviewer,
            'ce_interview_round' => $interview_round
        );

        $this->db->where('ce_id', $candidate_id);
        
        if ($this->db->update(TBL_CALENDAR, $update_data)) {
            $this->session->set_flashdata('success_msg', 'Interview rescheduled successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to reschedule interview.');
        }

        redirect('R_dashboard/Rstatus_view');
    }

    public function cancel_interview()
    {
        if (!$this->session->userdata('authenticated')) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $candidate_id = $this->input->post('candidate_id');

        // Delete from calendar
        $this->db->where('ce_id', $candidate_id);
        $calendar_deleted = $this->db->delete(TBL_CALENDAR);

        // Update candidate interview status
        $this->db->where('cd_id', $candidate_id);
        $candidate_updated = $this->db->update(TBL_CANDIDATE_DETAILS, array('cd_interview_status' => 0));

        if ($calendar_deleted && $candidate_updated) {
            echo json_encode(['success' => true, 'message' => 'Interview cancelled successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel interview']);
        }
    }

    public function export_selected_candidates()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }

        $username = $this->session->userdata('username');

        // Get selected candidates for this recruiter
        $this->db->select('cd_name, cd_email, cd_phone, cd_gender, cd_job_title, cd_source, cd_status');
        $this->db->from('candidate_details');
        $this->db->where('cd_rec_username', $username);
        $this->db->where('cd_status', 'Selected');
        $this->db->order_by('cd_id', 'DESC');
        $query = $this->db->get();

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=selected_candidates_' . date('Y-m-d') . '.csv');

        // Create output stream
        $output = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($output, array('Name', 'Email', 'Phone', 'Gender', 'Job Title', 'Source', 'Status'));

        // Add data rows
        foreach ($query->result_array() as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

}
