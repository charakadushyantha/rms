<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employer_profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Company_profile_model');
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
        $data['page_title'] = 'Company Profile';
        
        $data['profile'] = $this->Company_profile_model->get_company_profile();
        $data['stats'] = $this->Company_profile_model->get_profile_stats();
        
        $this->load->view('Employer_profile_view/index', $data);
    }

    public function edit()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Edit Company Profile';
        
        $data['profile'] = $this->Company_profile_model->get_company_profile();
        
        $this->load->view('Employer_profile_view/edit', $data);
    }

    public function culture()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Company Culture';
        
        $data['culture'] = $this->Company_profile_model->get_culture_data();
        
        $this->load->view('Employer_profile_view/culture', $data);
    }

    public function benefits()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Employee Benefits';
        
        $data['benefits'] = $this->Company_profile_model->get_benefits();
        
        $this->load->view('Employer_profile_view/benefits', $data);
    }
}
