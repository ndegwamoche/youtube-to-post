<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('YTP_Admin')) {

    class YTP_Admin
    {
        function __construct()
        {
            add_action('admin_menu', array($this, 'ytp_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'ytp_admin_enqueue_scripts'));
        }

        function ytp_admin_menu()
        {
            add_menu_page('YouTube To Post', 'YouTube to Post', 'manage_options', 'youtube-to-post', array($this, 'ytp_admin_menu_html'), 'dashicons-playlist-video', 100);
            add_submenu_page('youtube-to-post', 'YouTube To Post General Settings', 'General Settings', 'manage_options', 'youtube-to-post', array($this, 'ytp_admin_menu_html'));
            add_submenu_page('youtube-to-post', 'YouTube To Post Manual Import', 'Manual Import', 'manage_options', 'youtube-to-post-manual-import', array($this, 'ytp_admin_submenu_html'));
            add_submenu_page('youtube-to-post', 'YouTube To Post Imported Videos List', 'Imported Videos List', 'manage_options', 'youtube-to-post-imported-videos', array($this, 'ytp_admin_submenu_html'));
        }

        function ytp_admin_menu_html()
        {
            include plugin_dir_path(__FILE__) . 'ytp-admin-general-settings.php';
        }

        function ytp_admin_submenu_html()
        {
        }

        function ytp_admin_enqueue_scripts()
        {
            if (!isset($_GET["page"]) || ($_GET["page"] != 'youtube-to-post' && $_GET["page"] != "youtube-to-post-manual-import" && $_GET["page"] != "youtube-to-post-imported-videos")) {
                return;
            }

            wp_enqueue_style('bcf_font_awesome', plugin_dir_url(dirname(__FILE__)) . 'css/fontawesome.min.css');
            wp_enqueue_style('ytp_bootstrap_css', plugin_dir_url(dirname(__FILE__)) . 'css/bootstrap.min.css');
            wp_enqueue_script('ytp_bootstrap_script', plugin_dir_url(dirname(__FILE__)) . 'js/bootstrap.min.js', array(), false, true);
            wp_enqueue_style('ytp_admin_css', plugin_dir_url(dirname(__FILE__)) . 'build/style-index.css');
        }

        function ytp_handle_settings_form()
        {
            if (wp_verify_nonce($_POST['ytp_general_settings_nonce'], 'ytp_save_general_settings') && current_user_can('manage_options')) {
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
            } else { ?>
                <div class="error">
                    <p>Sorry, you do not have permission to perform that action.</p>
                </div>
<?php
            }
        }
    }
}
