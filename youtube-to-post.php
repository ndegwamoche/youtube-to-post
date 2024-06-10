<?php

/**
 * Plugin Name: YouTube to Post
 * Description: Easily import and embed YouTube videos into your posts with full customization
 * Version: 1.0
 * Author: Martin Ndegwa Moche
 * Author URI: https://github.com/ndegwamoche/
 * Text Domain: wcpdomain
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('YTP')) {

    class YTP
    {
        function __construct()
        {
            require_once plugin_dir_path(__FILE__) . 'includes/ytp-admin.php';
            require_once plugin_dir_path(__FILE__) . 'includes/ytp-rest-routes.php';
        }
    }

    $bcf = new YTP();
}
