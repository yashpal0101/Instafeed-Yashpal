<?php
/**
 * Admin Settings Page
 */

if (!defined('ABSPATH')) {
    exit;
}

class IGF_Settings {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Instagram Feed Settings',
            'Instagram Feed',
            'manage_options',
            'igf-settings',
            array($this, 'render_settings_page'),
            'dashicons-camera'
        );
    }
    
    public function register_settings() {
        register_setting('igf_settings', 'igf_access_token');
        register_setting('igf_settings', 'igf_business_account_id');
        
        add_settings_section(
            'igf_main_section',
            'Instagram API Configuration',
            array($this, 'render_section'),
            'igf_settings'
        );
        
        add_settings_field(
            'igf_access_token',
            'Access Token',
            array($this, 'render_access_token_field'),
            'igf_settings',
            'igf_main_section'
        );
        
        add_settings_field(
            'igf_business_account_id',
            'Business Account ID',
            array($this, 'render_account_id_field'),
            'igf_settings',
            'igf_main_section'
        );
    }
    
    public function render_section() {
        echo 'Enter your Instagram Graph API credentials below:';
    }
    
    public function render_access_token_field() {
        $token = get_option('igf_access_token');
        ?>
        <input type="password" name="igf_access_token" value="<?php echo esc_attr($token); ?>" style="width: 100%; max-width: 500px;">
        <p class="description">Your Instagram Graph API access token</p>
        <?php
    }
    
    public function render_account_id_field() {
        $account_id = get_option('igf_business_account_id');
        ?>
        <input type="text" name="igf_business_account_id" value="<?php echo esc_attr($account_id); ?>" style="width: 100%; max-width: 500px;">
        <p class="description">Your Instagram Business Account ID</p>
        <?php
    }
    
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Instagram Feed Settings</h1>
            
            <?php
            $instagram = new Instagram_API();
            if ($instagram->test_connection()) {
                echo '<div class="notice notice-success"><p>✓ Instagram API connection successful!</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>✗ Instagram API connection failed. Please check your credentials.</p></div>';
            }
            ?>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('igf_settings');
                do_settings_sections('igf_settings');
                submit_button();
                ?>
            </form>
            
            <h2>Usage</h2>
            <p>Add this shortcode to any post or page:</p>
            <code>[instagram_feed limit="12" columns="3" show_captions="true" show_stats="true"]</code>
        </div>
        <?php
    }
}

// Initialize settings
if (is_admin()) {
    new IGF_Settings();
}