<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews_management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Reviews_management_model');
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
        $data['page_title'] = 'Reviews Management';
        
        $data['reviews'] = $this->Reviews_management_model->get_all_reviews();
        $data['stats'] = $this->Reviews_management_model->get_review_stats();
        $data['platforms'] = $this->Reviews_management_model->get_platform_stats();
        
        $this->load->view('Reviews_management_view/index', $data);
    }

    public function respond($review_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Respond to Review';
        
        $data['review'] = $this->Reviews_management_model->get_review($review_id);
        
        $this->load->view('Reviews_management_view/respond', $data);
    }

    public function analytics()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Review Analytics';
        
        $data['trends'] = $this->Reviews_management_model->get_review_trends();
        $data['sentiment'] = $this->Reviews_management_model->get_sentiment_analysis();
        
        $this->load->view('Reviews_management_view/analytics', $data);
    }
}
