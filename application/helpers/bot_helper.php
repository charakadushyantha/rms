<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Format bot message for display
 */
if (!function_exists('format_bot_message')) {
    function format_bot_message($message) {
        // Convert markdown-style formatting
        $message = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $message);
        $message = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $message);
        
        // Convert line breaks
        $message = nl2br($message);
        
        return $message;
    }
}

/**
 * Generate session ID
 */
if (!function_exists('generate_bot_session_id')) {
    function generate_bot_session_id() {
        return 'bot_session_' . uniqid() . '_' . time();
    }
}

/**
 * Get bot avatar
 */
if (!function_exists('get_bot_avatar')) {
    function get_bot_avatar() {
        return '<i class="fas fa-robot"></i>';
    }
}

/**
 * Get user avatar
 */
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user_name = '') {
        if ($user_name) {
            return strtoupper(substr($user_name, 0, 1));
        }
        return '<i class="fas fa-user"></i>';
    }
}

/**
 * Format timestamp for chat
 */
if (!function_exists('format_chat_time')) {
    function format_chat_time($timestamp) {
        $time = strtotime($timestamp);
        $now = time();
        $diff = $now - $time;

        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            return date('g:i A', $time);
        } else {
            return date('M j, g:i A', $time);
        }
    }
}

/**
 * Sanitize user message
 */
if (!function_exists('sanitize_bot_message')) {
    function sanitize_bot_message($message) {
        return htmlspecialchars(trim($message), ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Check if bot is enabled
 */
if (!function_exists('is_bot_enabled')) {
    function is_bot_enabled() {
        $CI =& get_instance();
        $CI->load->model('Bot_model');
        $config = $CI->Bot_model->get_config('bot_enabled');
        return $config ?? true;
    }
}

/**
 * Get bot welcome message
 */
if (!function_exists('get_bot_welcome_message')) {
    function get_bot_welcome_message() {
        $CI =& get_instance();
        $CI->load->model('Bot_model');
        $message = $CI->Bot_model->get_config('welcome_message');
        return $message ?? "Hi! 👋 I'm RecruitBot. How can I help you today?";
    }
}
