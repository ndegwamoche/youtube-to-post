<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1>General Settings</h1>
                <p>Welcome to the YouTube to Post plugin's General Settings page. Here you can configure essential options to customize how YouTube videos are imported and displayed on your site. Fill up the settings below to set up your preferences:</p>
                <button class="btn btn-success btn-lg import-videos-button" type="button">Import Videos</button>
            </div>
        </div>
    </div>

    <?php if (isset($_POST['ytp_general_settings_submitted']) == "true") $this->ytp_handle_settings_form() ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <form method="POST" id="ytp-general-settings-form">
                                <input type="hidden" name="ytp_general_settings_submitted" value="true">
                                <?php wp_nonce_field('ytp_save_general_settings', 'ytp_general_settings_nonce'); ?>
                                <div class="form-group">
                                    <label>API Key</label>
                                    <input class="form-control" placeholder="A-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-Z" name="ytp_api_key">
                                    <p class="help-block">Enter your YouTube API key in the provided field.</p>
                                </div>
                                <div class="form-group">
                                    <label>Channel or Playlist ID</label>
                                    <input class="form-control" placeholder="@youtubechannel" name="ytp_channel_id">
                                    <p class="help-block">Input the YouTube channel or playlist ID.</p>
                                </div>
                                <div class="form-group">
                                    <label>Search Term</label>
                                    <input class="form-control" placeholder="New pussycat video" name="ytp_search_term">
                                    <p class="help-block">Enter keywords to search for videos on YouTube.</p>
                                </div>
                                <div class="form-group">
                                    <label>Categories</label>

                                    <?php
                                    $categories = get_categories(array(
                                        'taxonomy' => 'category',
                                        'orderby' => 'count',
                                        'order' => 'DESC',
                                        'hide_empty' => false,
                                        'parent' => 0
                                    ));
                                    ?>

                                    <select class="form-control form-select" name="ytp_category">
                                        <option value="0">Please Select</option>
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo $category->term_id; ?>"><?php echo esc_html($category->name); ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="help-block">Choose categories for imported videos.</p>
                                </div>
                                <div class="form-group">
                                    <label>Tags</label>

                                    <?php
                                    $tags = get_tags(array(
                                        'hide_empty' => false
                                    ));
                                    ?>
                                    <select class="form-control form-select" name="ytp_tag">
                                        <option value="0">Please Select</option>
                                        <?php foreach ($tags as $tag) { ?>
                                            <option value="<?php echo $tag->term_id; ?>"><?php echo esc_html($tag->name); ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="help-block">Specify tags for imported videos.</p>
                                </div>
                                <div class="form-group">
                                    <label>Max Results</label>
                                    <input class="form-control" placeholder="10" value="10" name="ytp_max_results">
                                    <p class="help-block">Enter the maximum number of videos to import (e.g., 5, 10, 20).</p>
                                </div>
                                <div class="form-group">
                                    <label>Videos Published After</label>
                                    <input class="form-control" placeholder="20" type="date" name="ytp_video_published_after">
                                    <p class="help-block">Select a date to fetch videos published after this date</p>
                                </div>
                                <div class="form-group" style="margin-top: 45px;">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>