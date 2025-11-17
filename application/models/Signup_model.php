<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_model extends CI_Model {

  public function Check_username()
  {
    $this->db->where('u_username',$this->input->post('username'));
    $result = $this->db->get(TBL_USERS);
    if($result->num_rows() == 0)
    {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  public function Check_rec_username()
  {
    $this->db->where('u_username',$this->input->post('rec_username'));
    $result = $this->db->get(TBL_USERS);
    if($result->num_rows() == 0)
    {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }


  public function Check_email()
  {
    $this->db->where('u_email',$this->input->post('useremail'));
    $result = $this->db->get(TBL_USERS);
    if($result->num_rows() == 0)
    {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }


  public function Check_both()
  {
    $this->db->where('u_email',$this->input->post('useremail'));
    $this->db->where('u_username',$this->input->post('username'));
    $result = $this->db->get(TBL_USERS);
    if($result->num_rows() == 0)
    {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  public function Create_rec()
  {
    try {
      // Load signup controller model to check settings
      $this->load->model('Signup_controller_model');
      $settings = $this->Signup_controller_model->get_signup_settings();
      
      // Get the role from form or use default from settings
      $role = $this->input->post('role') ? $this->input->post('role') : $settings->default_signup_role;
      
      // Check if signup is enabled for this role (with fallback)
      if (method_exists($this->Signup_controller_model, 'is_role_signup_enabled')) {
        if (!$this->Signup_controller_model->is_role_signup_enabled($role)) {
          return false; // Signup not allowed for this role
        }
      }
      
      // Determine status based on auto-approval settings (with fallback)
      $status = 'Pending'; // Default to pending
      if (method_exists($this->Signup_controller_model, 'is_auto_approve_enabled')) {
        $status = $this->Signup_controller_model->is_auto_approve_enabled($role) ? 'Active' : 'Pending';
      }

      $new_member_insert_data = array(
        'u_username' => $this->input->post('username'),
        'u_email'    => $this->input->post('useremail'),
        'u_password' => md5($this->input->post('userpass')),
        'u_role'     => $role,
        'u_status'   => $status
      );
      
      // Add created_at if column exists
      $fields = $this->db->list_fields(TBL_USERS);
      if (in_array('created_at', $fields)) {
        $new_member_insert_data['created_at'] = date('Y-m-d H:i:s');
      }
      if (in_array('created_by', $fields)) {
        $new_member_insert_data['created_by'] = 'self_registration';
      }

      $insert = $this->db->insert(TBL_USERS,$new_member_insert_data);
      return $insert;
      
    } catch (Exception $e) {
      // Fallback to original behavior if there are any errors
      log_message('error', 'Signup controller integration error: ' . $e->getMessage());
      
      $new_member_insert_data = array(
        'u_username' => $this->input->post('username'),
        'u_email'    => $this->input->post('useremail'),
        'u_password' => md5($this->input->post('userpass')),
        'u_role'     => 'Recruiter', // Set default role
        'u_status'   => 'Pending' // New users need activation
      );

      $insert = $this->db->insert(TBL_USERS,$new_member_insert_data);
      return $insert;
    }
  }

  public function add_rec()
  {

    $new_rec = array(
      'u_username' => $this->input->post('rec_username'),
      'u_email'    => $this->input->post('rec_email'),
      'u_password' => md5($this->input->post('rec_password')),
      'u_role'     => 'Recruiter', // Set default role
      'u_status'   => 'Active' // This method seems to be for direct activation
    );

    $insert = $this->db->insert(TBL_USERS,$new_rec);
  }




}
