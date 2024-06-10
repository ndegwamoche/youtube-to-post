<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('YTP_API_Key')) {

    class YTP_API_Key {

        private $client_id = 'xxxxxx';
        private $client_secret = 'xxxxxx';
        private $refresh_token = 'xxxxxx';
        private $access_token;

        function __construct() {
            // Optionally initialize things if needed
        }

        /**
         * Retrieves the access token using the refresh token.
         * 
         * @return bool|string The access token on success, false on failure.
         */
        private function get_access_token() {
            $url = 'https://oauth2.googleapis.com/token';
            $body = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'refresh_token' => $this->refresh_token,
                'grant_type' => 'refresh_token'
            );

            $response = wp_remote_post($url, array(
                'body' => http_build_query($body),
                'headers' => array('Content-Type' => 'application/x-www-form-urlencoded')
            ));

            if (is_wp_error($response)) {
                return false;
            }

            $data = json_decode(wp_remote_retrieve_body($response), true);

            if (isset($data['access_token'])) {
                $this->access_token = $data['access_token'];
                return $this->access_token;
            }

            return false;
        }

        /**
         * Performs a YouTube search query using the access token.
         * 
         * @param string $query The search query.
         * @return array|bool The search results on success, false on failure.
         */
        public function search_youtube($query) {
            if (!$this->access_token && !$this->get_access_token()) {
                return false;
            }

            $url = 'https://youtube.googleapis.com/youtube/v3/search';
            $params = array(
                'part' => 'snippet',
                'q' => urlencode($query),
                'access_token' => $this->access_token
            );

            $response = wp_remote_get(add_query_arg($params, $url));

            if (is_wp_error($response)) {
                return false;
            }

            $data = json_decode(wp_remote_retrieve_body($response), true);

            if (isset($data['items'])) {
                return $data['items'];
            }

            return false;
        }
    }
}
