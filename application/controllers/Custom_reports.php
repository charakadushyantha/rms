<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Custom_reports_model');
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
        $data['page_title'] = 'Custom Reports';
        
        $data['reports'] = $this->Custom_reports_model->get_all_reports();
        $data['templates'] = $this->Custom_reports_model->get_report_templates();
        $data['stats'] = $this->Custom_reports_model->get_report_stats();
        
        $this->load->view('Custom_reports_view/index', $data);
    }

    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Create Custom Report';
        
        $data['metrics'] = $this->Custom_reports_model->get_available_metrics();
        $data['dimensions'] = $this->Custom_reports_model->get_available_dimensions();
        
        $this->load->view('Custom_reports_view/create', $data);
    }

    public function view($report_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'View Report';
        
        $data['report'] = $this->Custom_reports_model->get_report($report_id);
        $data['report_data'] = $this->Custom_reports_model->get_report_data($report_id);
        
        $this->load->view('Custom_reports_view/view', $data);
    }

    public function schedule()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Schedule Reports';
        
        $data['scheduled'] = $this->Custom_reports_model->get_scheduled_reports();
        
        $this->load->view('Custom_reports_view/schedule', $data);
    }
}
