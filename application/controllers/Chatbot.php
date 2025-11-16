<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
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
        $data['page_title'] = 'AI Chatbot';
        $this->load->view('Chatbot_view/index', $data);
    }
}
