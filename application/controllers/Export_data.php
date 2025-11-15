<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Export_data_model');
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
        $data['page_title'] = 'Export Data';
        
        $data['export_options'] = $this->Export_data_model->get_export_options();
        $data['recent_exports'] = $this->Export_data_model->get_recent_exports();
        $data['stats'] = $this->Export_data_model->get_export_stats();
        
        $this->load->view('Export_data_view/index', $data);
    }

    public function configure($data_type)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Configure Export - ' . ucfirst($data_type);
        
        $data['data_type'] = $data_type;
        $data['fields'] = $this->Export_data_model->get_available_fields($data_type);
        $data['filters'] = $this->Export_data_model->get_available_filters($data_type);
        
        $this->load->view('Export_data_view/configure', $data);
    }

    public function history()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Export History';
        
        $data['exports'] = $this->Export_data_model->get_export_history();
        
        $this->load->view('Export_data_view/history', $data);
    }

    public function download($export_id)
    {
        // Simulate download
        $export = $this->Export_data_model->get_export($export_id);
        
        if ($export) {
            // In real implementation, generate and download file
            echo "Downloading: " . $export['filename'];
        } else {
            show_404();
        }
    }
}
