<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_advocacy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Employee_advocacy_model');
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
        $data['page_title'] = 'Employee Advocacy';
        
        $data['advocates'] = $this->Employee_advocacy_model->get_all_advocates();
        $data['stats'] = $this->Employee_advocacy_model->get_statistics();
        $data['top_advocates'] = $this->Employee_advocacy_model->get_top_advocates(5);
        
        $this->load->view('Employee_advocacy_view/index', $data);
    }

    public function advocates()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Employee Advocates';
        
        $data['advocates'] = $this->Employee_advocacy_model->get_all_advocates();
        
        $this->load->view('Employee_advocacy_view/advocates', $data);
    }

    public function content()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Advocacy Content';
        
        $data['content'] = $this->Employee_advocacy_model->get_all_content();
        
        $this->load->view('Employee_advocacy_view/content', $data);
    }

    public function leaderboard()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Advocacy Leaderboard';
        
        $data['top_advocates'] = $this->Employee_advocacy_model->get_top_advocates(20);
        
        $this->load->view('Employee_advocacy_view/leaderboard', $data);
    }
}
