<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_gallery extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Media_gallery_model');
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
        $data['page_title'] = 'Media Gallery';
        
        $data['media'] = $this->Media_gallery_model->get_all_media();
        $data['stats'] = $this->Media_gallery_model->get_media_stats();
        $data['categories'] = $this->Media_gallery_model->get_categories();
        
        $this->load->view('Media_gallery_view/index', $data);
    }

    public function upload()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Upload Media';
        
        $this->load->view('Media_gallery_view/upload', $data);
    }

    public function videos()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Video Gallery';
        
        $data['videos'] = $this->Media_gallery_model->get_videos();
        
        $this->load->view('Media_gallery_view/videos', $data);
    }
}
