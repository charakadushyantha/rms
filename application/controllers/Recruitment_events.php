<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_events extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_in();
        $this->load->model('Recruitment_events_model');
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
        $data['page_title'] = 'Recruitment Events';
        
        $filters = [
            'type' => $this->input->get('type'),
            'status' => $this->input->get('status')
        ];
        
        $data['events'] = $this->Recruitment_events_model->get_all_events($filters);
        $data['stats'] = $this->Recruitment_events_model->get_statistics();
        $data['event_types'] = $this->Recruitment_events_model->get_event_types();
        
        $this->load->view('Recruitment_events_view/index', $data);
    }

    public function create()
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Create Event';
        $data['event_types'] = $this->Recruitment_events_model->get_event_types();
        
        $this->load->view('Recruitment_events_view/create', $data);
    }

    public function save()
    {
        $username = $this->session->userdata('username');
        
        $event_data = [
            'event_name' => $this->input->post('event_name'),
            'event_type' => $this->input->post('event_type'),
            'description' => $this->input->post('description'),
            'event_date' => $this->input->post('event_date'),
            'start_time' => $this->input->post('start_time'),
            'end_time' => $this->input->post('end_time'),
            'location' => $this->input->post('location'),
            'venue_type' => $this->input->post('venue_type'),
            'virtual_link' => $this->input->post('virtual_link'),
            'max_attendees' => $this->input->post('max_attendees'),
            'budget' => $this->input->post('budget'),
            'organizer' => $this->input->post('organizer'),
            'contact_email' => $this->input->post('contact_email'),
            'contact_phone' => $this->input->post('contact_phone'),
            'status' => 'Upcoming',
            'created_by' => $username
        ];
        
        $event_id = $this->Recruitment_events_model->create_event($event_data);
        
        if ($event_id) {
            $this->session->set_flashdata('success_msg', 'Event created successfully!');
            redirect('Recruitment_events/view/' . $event_id);
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to create event.');
            redirect('Recruitment_events/create');
        }
    }

    public function view($event_id)
    {
        $data['uname'] = $this->session->userdata('username');
        $data['page_title'] = 'Event Details';
        
        $data['event'] = $this->Recruitment_events_model->get_event($event_id);
        $data['registrations'] = $this->Recruitment_events_model->get_registrations($event_id);
        $data['jobs'] = $this->Recruitment_events_model->get_event_jobs($event_id);
        
        $this->load->view('Recruitment_events_view/view', $data);
    }

    public function delete($event_id)
    {
        if ($this->Recruitment_events_model->delete_event($event_id)) {
            $this->session->set_flashdata('success_msg', 'Event deleted successfully!');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to delete event.');
        }
        
        redirect('Recruitment_events');
    }
}
