<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path(__FILE__) . 'ytp-api-key.php';

if (!class_exists('YTP_Rest_Routes')) {

    class YTP_Rest_Routes
    {
        function __construct()
        {
            add_action('rest_api_init', array($this, 'ytp_register_rest_routes'));
        }

        function ytp_register_rest_routes()
        {
            register_rest_route('ytp/v1', '/import-videos', array(
                'methods' => 'POST',
                'callback' => array($this, 'ytp_handle_import_videos'),
                'permission_callback' => '__return_true',
            ));
        }

        function ytp_handle_import_videos(WP_REST_Request $request)
        {
            $ytp_api_key = sanitize_text_field($request['ytp_api_key']);

            $ytp_api = new YTP_API_Key();
            $results = $ytp_api->search_youtube('dj afro');

            if ($results) {
                foreach ($results as $item) {
                    // Process each search result item
                    var_dump($item);
                }
            } else {
                echo 'Failed to retrieve search results.';
            }
        }
    }

    // Initialize the YTP_Rest_Routes class
    new YTP_Rest_Routes();
}
