<?php
class Calendar_model extends CI_Model
{
  public function get_event($uname)
  {
    $this->db->where('ce_rec_username',$uname);
    $this->db->where('ce_interview_round !=',1);
    return $this->db->get(TBL_CALENDAR);

  }

  public function get_event_admin($uname)
  {
    $this->db->where('ce_interview_round !=',1);
    return $this->db->get(TBL_CALENDAR);
  }

  public function add_event()
  {
    $data = array(
      'ce_rec_username' => $this->session->userdata('username'),
      'ce_can_name' => $this->input->post('can_name'),
      'ce_start_date' => $this->input->post('sdate'),
      'ce_end_date' => $this->input->post('edate'),
      'ce_interviewer' => $this->input->post('Interviewer'),
      'ce_id'          => $this->input->post('can_id')
    );
      $res = $this->db->insert(TBL_CALENDAR, $data);
      return $res;
  }

  public function update_event($id, $data)
  {
      $this->db->where("ce_id", $id)->update(TBL_CALENDAR, $data);
      $this->db->where("cd_id",$id)->update(TBL_CANDIDATE_DETAILS,array('cd_name'=>$data['ce_can_name']));
  }

  public function delete_event($id)
  {
      $this->db->where("ce_id", $id)->delete(TBL_CALENDAR);
      $this->db->where("cd_id", $id)->update(TBL_CANDIDATE_DETAILS,array('cd_status' => 'Not Interested','cd_interview_status'=> 0));

  }

  

  public function get_selected_all_can()
  {
    $this->db->select('ce_can_name');
    $this->db->where('ce_interview_round',1);
    $can = $this->db->get(TBL_CALENDAR);
    return $can->result_array();
  }

  public function count_can($data,$round)
  {
    $this->db->where('ce_rec_username',$data['uname']);
    $this->db->where('ce_interview_round',$round);
    return $this->db->count_all_results(TBL_CALENDAR);
  }

  public function count_can_admin()
  {
    $this->db->where('ce_interview_round',1);
    return $this->db->count_all_results(TBL_CALENDAR);
  }
  

  public function int_not_sel_can(){
    $all_can = $this->db->count_all_results(TBL_CALENDAR);
    $this->db->where('ce_interview_round',1);
    $sel_can = $this->db->count_all_results(TBL_CALENDAR);
    $ans = $all_can - $sel_can;
    return $ans;
  }

  public function count_all($data)
  {
    $this->db->where('ce_rec_username',$data['uname']);
    return $this->db->count_all_results(TBL_CALENDAR);
  }

  public function get_interview_stats()
  {
      $username = $this->session->userdata('username');
      
      // Query to get interview stats for specific recruiter
      $this->db->select('ce_interview_round, COUNT(*) as total_interviews');
      $this->db->from(TBL_CALENDAR);
      $this->db->where('ce_rec_username', $username);
      $this->db->group_by('ce_interview_round');
      
      $query = $this->db->get();
      return $query->result_array();
  }
  
  public function get_all_interview_stats()
  {
      // Query to get interview stats for all recruiters
      $this->db->select('ce_rec_username, ce_interview_round, COUNT(*) as total_interviews');
      $this->db->from(TBL_CALENDAR);
      $this->db->group_by(array('ce_rec_username', 'ce_interview_round'));
      
      $query = $this->db->get();
      return $query->result_array();
  }


}
 ?>
