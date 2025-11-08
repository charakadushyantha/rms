<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| AI Chatbot Configuration
|--------------------------------------------------------------------------
|
| Configure your AI chatbot settings here
|
*/

// AI Provider: 'openai', 'anthropic', 'custom'
$config['provider'] = 'openai';

// API Key - IMPORTANT: Set your API key here or use environment variable
$config['api_key'] = getenv('OPENAI_API_KEY') ?: 'YOUR_API_KEY_HERE';

// Model to use
$config['model'] = 'gpt-3.5-turbo'; // or 'gpt-4' for better responses

// Maximum tokens per response
$config['max_tokens'] = 500;

// Temperature (0-1, higher = more creative)
$config['temperature'] = 0.7;

// Enable chat logging
$config['enable_logging'] = true;

// Chat widget settings
$config['widget_position'] = 'bottom-right'; // bottom-right, bottom-left
$config['widget_color'] = '#007bff';
$config['widget_title'] = 'Recruitment Assistant';
$config['welcome_message'] = 'Hi! I\'m your AI Recruitment Assistant. How can I help you today?';
