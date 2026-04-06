<?php
/**
 * Plugin Name: Instagram Feed Fetcher
 * Description: Fetch and display Instagram feeds
 * Version: 1.0.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('IGF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('IGF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once IGF_PLUGIN_DIR . 'includes/class-instagram-api.php';
require_once IGF_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once IGF_PLUGIN_DIR . 'admin/class-settings.php';

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'igf_activate_plugin');
register_deactivation_hook(__FILE__, 'igf_deactivate_plugin');

function igf_activate_plugin() {
    // Flush rewrite rules if needed
    flush_rewrite_rules();
}

function igf_deactivate_plugin() {
    // Clear cached data
    delete_transient('igf_feed_cache');
    flush_rewrite_rules();
}

// Initialize plugin
add_action('plugins_loaded', 'igf_init_plugin');

function igf_init_plugin() {
    // Load text domain for translations
    load_plugin_textdomain('instagram-feed', false, dirname(plugin_basename(__FILE__)) . '/languages');
    
    // Enqueue styles and scripts
    add_action('wp_enqueue_scripts', 'igf_enqueue_assets');
}

function igf_enqueue_assets() {
    wp_enqueue_style('igf-style', IGF_PLUGIN_URL . 'assets/style.css', array(), '1.0.0');
}