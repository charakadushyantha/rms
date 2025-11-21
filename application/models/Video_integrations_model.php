<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_integrations_model extends CI_Model
{
    /**
     * Get platform configuration
     */
    public function get_platform_config($platform)
    {
        try {
            $query = $this->db->get_where('video_platform_config', array('platform' => $platform));
            return $query->row();
        } catch (Exception $e) {
            log_message('error', 'Video integrations table error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save platform configuration
     */
    public function save_config($config_data)
    {
        $platform = $config_data['platform'];
        
        // Check if config exists
        $existing = $this->get_platform_config($platform);
        
        if ($existing) {
            // Update
            $this->db->where('platform', $platform);
            return $this->db->update('video_platform_config', $config_data);
        } else {
            // Insert
            return $this->db->insert('video_platform_config', $config_data);
        }
    }

    /**
     * Create video meeting
     */
    public function create_meeting($platform, $meeting_data)
    {
        // Get platform config
        $config = $this->get_platform_config($platform);
        
        if (!$config || !$config->is_enabled) {
            return array('success' => false, 'error' => 'Platform not configured or disabled');
        }
        
        // Call appropriate platform API
        switch ($platform) {
            case 'zoom':
                return $this->create_zoom_meeting($config, $meeting_data);
            case 'teams':
                return $this->create_teams_meeting($config, $meeting_data);
            case 'meet':
                return $this->create_meet_meeting($config, $meeting_data);
            default:
                return array('success' => false, 'error' => 'Unknown platform');
        }
    }

    /**
     * Create Zoom meeting
     */
    private function create_zoom_meeting($config, $meeting_data)
    {
        // Zoom API endpoint
        $url = 'https://api.zoom.us/v2/users/me/meetings';
        
        // Prepare meeting data
        $settings = json_decode($config->settings, true);
        $zoom_data = array(
            'topic' => $meeting_data['title'],
            'type' => 2, // Scheduled meeting
            'start_time' => date('Y-m-d\TH:i:s', strtotime($meeting_data['start_time'])),
            'duration' => $meeting_data['duration'],
            'timezone' => 'Asia/Colombo',
            'settings' => array(
                'host_video' => true,
                'participant_video' => true,
                'join_before_host' => $settings['join_before_host'] ?? false,
                'waiting_room' => $settings['waiting_room'] ?? true,
                'auto_recording' => $settings['auto_recording'] ? 'cloud' : 'none'
            )
        );
        
        // Make API call
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($zoom_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key,
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 201) {
            $result = json_decode($response, true);
            
            // Save meeting to database
            $meeting_record = array(
                'platform' => 'zoom',
                'meeting_id' => $result['id'],
                'meeting_url' => $result['join_url'],
                'password' => $result['password'] ?? null,
                'title' => $meeting_data['title'],
                'start_time' => $meeting_data['start_time'],
                'duration' => $meeting_data['duration'],
                'interview_id' => $meeting_data['interview_id'] ?? null,
                'candidate_id' => $meeting_data['candidate_id'] ?? null,
                'created_by' => $this->session->userdata('username'),
                'status' => 'scheduled'
            );
            
            $this->db->insert('video_meetings', $meeting_record);
            
            // Log usage
            $this->log_usage('zoom', 'create_meeting');
            
            return array(
                'success' => true,
                'meeting_url' => $result['join_url'],
                'meeting_id' => $result['id'],
                'password' => $result['password'] ?? null
            );
        } else {
            return array('success' => false, 'error' => 'Failed to create Zoom meeting: ' . $response);
        }
    }

    /**
     * Create Teams meeting
     */
    private function create_teams_meeting($config, $meeting_data)
    {
        // Microsoft Graph API endpoint
        $url = 'https://graph.microsoft.com/v1.0/me/onlineMeetings';
        
        // Get access token
        $access_token = $this->get_teams_access_token($config);
        
        if (!$access_token) {
            return array('success' => false, 'error' => 'Failed to get Teams access token');
        }
        
        // Prepare meeting data
        $teams_data = array(
            'subject' => $meeting_data['title'],
            'startDateTime' => date('Y-m-d\TH:i:s', strtotime($meeting_data['start_time'])),
            'endDateTime' => date('Y-m-d\TH:i:s', strtotime($meeting_data['start_time'] . ' +' . $meeting_data['duration'] . ' minutes'))
        );
        
        // Make API call
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($teams_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 201) {
            $result = json_decode($response, true);
            
            // Save meeting to database
            $meeting_record = array(
                'platform' => 'teams',
                'meeting_id' => $result['id'],
                'meeting_url' => $result['joinUrl'],
                'title' => $meeting_data['title'],
                'start_time' => $meeting_data['start_time'],
                'duration' => $meeting_data['duration'],
                'interview_id' => $meeting_data['interview_id'] ?? null,
                'candidate_id' => $meeting_data['candidate_id'] ?? null,
                'created_by' => $this->session->userdata('username'),
                'status' => 'scheduled'
            );
            
            $this->db->insert('video_meetings', $meeting_record);
            
            // Log usage
            $this->log_usage('teams', 'create_meeting');
            
            return array(
                'success' => true,
                'meeting_url' => $result['joinUrl'],
                'meeting_id' => $result['id']
            );
        } else {
            return array('success' => false, 'error' => 'Failed to create Teams meeting: ' . $response);
        }
    }

    /**
     * Create Google Meet meeting
     */
    private function create_meet_meeting($config, $meeting_data)
    {
        // Google Calendar API endpoint
        $url = 'https://www.googleapis.com/calendar/v3/calendars/primary/events';
        
        // Prepare event data
        $event_data = array(
            'summary' => $meeting_data['title'],
            'start' => array(
                'dateTime' => date('c', strtotime($meeting_data['start_time'])),
                'timeZone' => 'Asia/Colombo'
            ),
            'end' => array(
                'dateTime' => date('c', strtotime($meeting_data['start_time'] . ' +' . $meeting_data['duration'] . ' minutes')),
                'timeZone' => 'Asia/Colombo'
            ),
            'conferenceData' => array(
                'createRequest' => array(
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => array('type' => 'hangoutsMeet')
                )
            )
        );
        
        // Make API call
        $ch = curl_init($url . '?conferenceDataVersion=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($event_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key,
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $result = json_decode($response, true);
            
            // Save meeting to database
            $meeting_record = array(
                'platform' => 'meet',
                'meeting_id' => $result['id'],
                'meeting_url' => $result['hangoutLink'],
                'title' => $meeting_data['title'],
                'start_time' => $meeting_data['start_time'],
                'duration' => $meeting_data['duration'],
                'interview_id' => $meeting_data['interview_id'] ?? null,
                'candidate_id' => $meeting_data['candidate_id'] ?? null,
                'created_by' => $this->session->userdata('username'),
                'status' => 'scheduled'
            );
            
            $this->db->insert('video_meetings', $meeting_record);
            
            // Log usage
            $this->log_usage('meet', 'create_meeting');
            
            return array(
                'success' => true,
                'meeting_url' => $result['hangoutLink'],
                'meeting_id' => $result['id']
            );
        } else {
            return array('success' => false, 'error' => 'Failed to create Meet meeting: ' . $response);
        }
    }

    /**
     * Get Teams access token
     */
    private function get_teams_access_token($config)
    {
        $url = 'https://login.microsoftonline.com/' . $config->tenant_id . '/oauth2/v2.0/token';
        
        $data = array(
            'client_id' => $config->client_id,
            'client_secret' => $config->client_secret,
            'scope' => 'https://graph.microsoft.com/.default',
            'grant_type' => 'client_credentials'
        );
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        return $result['access_token'] ?? null;
    }

    /**
     * Test platform connection
     */
    public function test_connection($platform)
    {
        $config = $this->get_platform_config($platform);
        
        if (!$config) {
            return array('success' => false, 'message' => 'Platform not configured');
        }
        
        // Test based on platform
        switch ($platform) {
            case 'zoom':
                return $this->test_zoom_connection($config);
            case 'teams':
                return $this->test_teams_connection($config);
            case 'meet':
                return $this->test_meet_connection($config);
            default:
                return array('success' => false, 'message' => 'Unknown platform');
        }
    }

    /**
     * Test Zoom connection
     */
    private function test_zoom_connection($config)
    {
        $url = 'https://api.zoom.us/v2/users/me';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return array('success' => true, 'message' => 'Connection successful');
        } else {
            return array('success' => false, 'message' => 'Connection failed');
        }
    }

    /**
     * Test Teams connection
     */
    private function test_teams_connection($config)
    {
        $access_token = $this->get_teams_access_token($config);
        
        if ($access_token) {
            return array('success' => true, 'message' => 'Connection successful');
        } else {
            return array('success' => false, 'message' => 'Connection failed');
        }
    }

    /**
     * Test Meet connection
     */
    private function test_meet_connection($config)
    {
        $url = 'https://www.googleapis.com/calendar/v3/users/me/calendarList';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $config->api_key
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return array('success' => true, 'message' => 'Connection successful');
        } else {
            return array('success' => false, 'message' => 'Connection failed');
        }
    }

    /**
     * Get usage statistics
     */
    public function get_usage_stats()
    {
        try {
            $this->db->reset_query();
            $stats = array();
            
            // Get meeting counts by platform
            $this->db->select('platform, COUNT(*) as count');
            $this->db->from('video_meetings');
            $this->db->group_by('platform');
            $query = $this->db->get();
            
            foreach ($query->result() as $row) {
                $stats[$row->platform] = $row->count;
            }
            
            return $stats;
        } catch (Exception $e) {
            log_message('error', 'Usage stats error: ' . $e->getMessage());
            return array();
        }
    }

    /**
     * Log usage
     */
    private function log_usage($platform, $action)
    {
        try {
            $data = array(
                'integration_type' => 'video',
                'platform' => $platform,
                'action' => $action,
                'date' => date('Y-m-d')
            );
            
            // Simple insert - let database handle duplicates
            $this->db->insert('integration_usage_stats', $data);
        } catch (Exception $e) {
            log_message('error', 'Usage logging error: ' . $e->getMessage());
        }
    }

    /**
     * Process webhook
     */
    public function process_webhook($platform, $payload)
    {
        // Log webhook
        $webhook_data = array(
            'integration_type' => 'video',
            'platform' => $platform,
            'event_type' => 'webhook',
            'payload' => $payload,
            'status' => 'received'
        );
        
        $this->db->insert('integration_webhooks', $webhook_data);
        $webhook_id = $this->db->insert_id();
        
        try {
            // Process based on platform
            $data = json_decode($payload, true);
            
            // Update meeting status based on webhook event
            // Implementation depends on specific webhook events
            
            // Mark as processed
            $this->db->where('id', $webhook_id);
            $this->db->update('integration_webhooks', array(
                'status' => 'processed',
                'processed_at' => date('Y-m-d H:i:s')
            ));
            
            return true;
        } catch (Exception $e) {
            // Mark as failed
            $this->db->where('id', $webhook_id);
            $this->db->update('integration_webhooks', array(
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ));
            
            return false;
        }
    }
}
