<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Awards_recognition extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Awards_recognition_model');
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
        $data['page_title'] = 'Awards & Recognition';
        
        $data['awards'] = $this->Awards_recognition_model->get_all_awards();
        $data['stats'] = $this->Awards_recognition_model->get_award_stats();
        $data['categories'] = $this->Awards_recognition_model->get_categories();
        
        $this->load->view('Awards_recognition_view/index', $data);
    }

    public function add()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Add Award';
        
        $this->load->view('Awards_recognition_view/add', $data);
    }

    public function certifications()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Certifications';
        
        $data['certifications'] = $this->Awards_recognition_model->get_certifications();
        
        $this->load->view('Awards_recognition_view/certifications', $data);
    }
}
