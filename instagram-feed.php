<?php

class InstagramFeed {
    // Constructor and initialization code
    public function __construct() {
        add_action('init', array($this, 'load_feed'));
    }

    // Function to load Instagram feed
    public function load_feed() {
        // Code to fetch and display the feed
    }

    // Additional methods and functionalities
}

// Loading the plugin
function run_instagram_feed() {
    $plugin = new InstagramFeed();
}

run_instagram_feed();
