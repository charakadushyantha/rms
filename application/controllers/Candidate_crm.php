<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidate_crm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Candidate_crm_model');
    }

    private function logged_in()
    {
        if (!$this->session->userdata('authenticated')) {
            redirect(LOGIN_URL);
        }
    }

    public function index()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Candidate CRM';
        
        $data['candidates'] = $this->Candidate_crm_model->get_all_candidates();
        $data['stats'] = $this->Candidate_crm_model->get_statistics();
        $data['pipeline_stages'] = $this->Candidate_crm_model->get_pipeline_stages();
        
        $this->load->view('Candidate_crm_view/index', $data);
    }

    public function pipeline()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'CRM Pipeline';
        
        $data['stages'] = $this->Candidate_crm_model->get_pipeline_stages();
        $data['candidates_by_stage'] = $this->Candidate_crm_model->get_candidates_by_stage();
        
        $this->load->view('Candidate_crm_view/pipeline', $data);
    }
}
