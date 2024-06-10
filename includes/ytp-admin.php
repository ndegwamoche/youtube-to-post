<?php

// Exit if accessed directly to ensure security
if (!defined('ABSPATH')) {
    exit;
}

// Check if the class YTP_Admin exists to avoid redeclaration errors
if (!class_exists('YTP_Admin')) {

    class YTP_Admin {

        /**
         * Constructor to initialize the admin hooks
         */
        public function __construct() {
            // Add admin menu items
            add_action('admin_menu', array($this, 'ytp_admin_menu'));
            // Enqueue admin scripts and styles
            add_action('admin_enqueue_scripts', array($this, 'ytp_admin_enqueue_scripts'));
        }

        /**
         * Adds the YouTube to Post admin menu and submenu items
         */
        public function ytp_admin_menu() {
            add_menu_page(
                'YouTube To Post', // Page title
                'YouTube to Post', // Menu title
                'manage_options', // Capability
                'youtube-to-post', // Menu slug
                array($this, 'ytp_admin_menu_html'), // Callback function
                'dashicons-playlist-video', // Icon
                100 // Position
            );

            add_submenu_page(
                'youtube-to-post', // Parent slug
                'YouTube To Post General Settings', // Page title
                'General Settings', // Menu title
                'manage_options', // Capability
                'youtube-to-post', // Menu slug
                array($this, 'ytp_admin_menu_html') // Callback function
            );

            add_submenu_page(
                'youtube-to-post', // Parent slug
                'YouTube To Post Manual Import', // Page title
                'Manual Import', // Menu title
                'manage_options', // Capability
                'youtube-to-post-manual-import', // Menu slug
                array($this, 'ytp_admin_submenu_html') // Callback function
            );

            add_submenu_page(
                'youtube-to-post', // Parent slug
                'YouTube To Post Imported Videos List', // Page title
                'Imported Videos List', // Menu title
                'manage_options', // Capability
                'youtube-to-post-imported-videos', // Menu slug
                array($this, 'ytp_admin_submenu_html') // Callback function
            );
        }

        /**
         * Outputs the HTML for the General Settings admin page
         */
        public function ytp_admin_menu_html() {
            include plugin_dir_path(__FILE__) . 'ytp-admin-general-settings.php';
        }

        /**
         * Outputs the HTML for the Manual Import and Imported Videos List admin pages
         */
        public function ytp_admin_submenu_html() {
            // You can include different PHP files for different submenus if needed
        }

        /**
         * Enqueues the admin-specific scripts and styles
         */
        public function ytp_admin_enqueue_scripts() {
            // Only load scripts on specific admin pages
            if (!isset($_GET["page"]) || !in_array($_GET["page"], ['youtube-to-post', 'youtube-to-post-manual-import', 'youtube-to-post-imported-videos'])) {
                return;
            }

            // Enqueue styles
            wp_enqueue_style('ytp_font_awesome', plugin_dir_url(dirname(__FILE__)) . 'css/fontawesome.min.css');
            wp_enqueue_style('ytp_bootstrap_css', plugin_dir_url(dirname(__FILE__)) . 'css/bootstrap.min.css');
            wp_enqueue_style('ytp_admin_css', plugin_dir_url(dirname(__FILE__)) . 'build/style-index.css');

            // Enqueue scripts
            wp_enqueue_script('ytp_bootstrap_script', plugin_dir_url(dirname(__FILE__)) . 'js/bootstrap.min.js', array(), false, true);
            wp_enqueue_script('ytp_admin_js', plugin_dir_url(dirname(__FILE__)) . 'build/index.js', array(), false, true);

            // Localize script with data
            wp_localize_script('ytp_admin_js', 'ytp_local_data', array(
                'root_url' => get_site_url(),
                'nonce' => wp_create_nonce('wp_rest')
            ));
        }

        /**
         * Handles the form submission for saving settings
         */
        public function ytp_handle_settings_form() {
            // Check nonce and user capabilities
            if (isset($_POST['ytp_general_settings_nonce']) && wp_verify_nonce($_POST['ytp_general_settings_nonce'], 'ytp_save_general_settings') && current_user_can('manage_options')) {
                // Sanitize and save options
                update_option('ytp_api_key', sanitize_text_field($_POST['ytp_api_key']));
                update_option('ytp_channel_id', sanitize_text_field($_POST['ytp_channel_id']));
                update_option('ytp_search_term', sanitize_text_field($_POST['ytp_search_term']));
                update_option('ytp_category', sanitize_text_field($_POST['ytp_category']));
                update_option('ytp_tag', sanitize_text_field($_POST['ytp_tag']));
                update_option('ytp_max_results', sanitize_text_field($_POST['ytp_max_results']));
                update_option('ytp_video_published_after', sanitize_text_field($_POST['ytp_video_published_after']));
                ?>
                <div class="updated">
                    <p>Your settings were saved.</p>
                </div>
                <?php
            } else {
                ?>
                <div class="error">
                    <p>Sorry, you do not have permission to perform that action.</p>
                </div>
                <?php
            }
        }
    }

    // Initialize the YTP_Admin class
    new YTP_Admin();
}
