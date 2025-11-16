<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Helper Functions
 */

if (!function_exists('json_response')) {
    /**
     * Send JSON response
     */
    function json_response($data, $status_code = 200) {
        http_response_code($status_code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

if (!function_exists('api_error')) {
    /**
     * Send API error response
     */
    function api_error($message, $status_code = 400) {
        json_response(['error' => $message], $status_code);
    }
}

if (!function_exists('api_success')) {
    /**
     * Send API success response
     */
    function api_success($data, $message = null) {
        $response = ['success' => true];
        if ($message) {
            $response['message'] = $message;
        }
        $response['data'] = $data;
        json_response($response);
    }
}

if (!function_exists('validate_api_key')) {
    /**
     * Validate API key
     */
    function validate_api_key($api_key) {
        // For now, accept any non-empty key
        // In production, validate against database
        return !empty($api_key);
    }
}

if (!function_exists('get_api_key')) {
    /**
     * Get API key from request
     */
    function get_api_key() {
        $CI =& get_instance();
        
        // Check Authorization header
        $auth_header = $CI->input->get_request_header('Authorization');
        if ($auth_header && strpos($auth_header, 'Bearer ') === 0) {
            return substr($auth_header, 7);
        }
        
        // Check query parameter
        $api_key = $CI->input->get('api_key');
        if ($api_key) {
            return $api_key;
        }
        
        // Check POST parameter
        $api_key = $CI->input->post('api_key');
        if ($api_key) {
            return $api_key;
        }
        
        return null;
    }
}
