<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Google OAuth Configuration
|--------------------------------------------------------------------------
*/

$config['google_oauth'] = array(
    'client_id'     => 'YOUR_GOOGLE_CLIENT_ID',
    'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
    'redirect_uri'  => 'http://localhost/rms/auth/google/callback',
    'api_key'       => 'YOUR_GOOGLE_API_KEY'
);
