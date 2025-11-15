<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto_distribution extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Auto_distribution_model');
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
        $data['page_title'] = 'Auto Distribution';
        
        $data['rules'] = $this->Auto_distribution_model->get_all_rules();
        $data['stats'] = $this->Auto_distribution_model->get_statistics();
        
        $this->load->view('Auto_distribution_view/index', $data);
    }

    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Create Distribution Rule';
        
        $this->load->view('Auto_distribution_view/create', $data);
    }

    public function logs()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Distribution Logs';
        
        $data['logs'] = $this->Auto_distribution_model->get_recent_logs(50);
        
        $this->load->view('Auto_distribution_view/logs', $data);
    }
}
