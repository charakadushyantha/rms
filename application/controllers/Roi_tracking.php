<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roi_tracking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Roi_tracking_model');
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
        $data['page_title'] = 'ROI Tracking';
        
        $data['overview'] = $this->Roi_tracking_model->get_roi_overview();
        $data['channels'] = $this->Roi_tracking_model->get_channel_roi();
        $data['campaigns'] = $this->Roi_tracking_model->get_campaign_roi();
        $data['trends'] = $this->Roi_tracking_model->get_roi_trends();
        
        $this->load->view('Roi_tracking_view/index', $data);
    }

    public function channel($channel_name)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Channel ROI - ' . $channel_name;
        
        $data['channel'] = $this->Roi_tracking_model->get_channel_details($channel_name);
        
        $this->load->view('Roi_tracking_view/channel', $data);
    }

    public function forecast()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'ROI Forecast';
        
        $data['forecast'] = $this->Roi_tracking_model->get_roi_forecast();
        
        $this->load->view('Roi_tracking_view/forecast', $data);
    }
}
