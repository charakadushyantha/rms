<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paid_advertising extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Paid_advertising_model');
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
        $data['page_title'] = 'Paid Advertising';
        
        $data['campaigns'] = $this->Paid_advertising_model->get_all_campaigns();
        $data['stats'] = $this->Paid_advertising_model->get_statistics();
        
        $this->load->view('Paid_advertising_view/index', $data);
    }

    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Create Ad Campaign';
        
        $this->load->view('Paid_advertising_view/create', $data);
    }

    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Advertising Analytics';
        
        $data['campaigns'] = $this->Paid_advertising_model->get_all_campaigns();
        $data['performance'] = $this->Paid_advertising_model->get_performance_data();
        
        $this->load->view('Paid_advertising_view/analytics', $data);
    }
}
