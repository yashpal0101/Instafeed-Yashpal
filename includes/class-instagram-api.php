<?php
/**
 * Instagram API Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Instagram_API {
    
    private $access_token;
    private $business_account_id;
    private $api_url = 'https://graph.instagram.com/v18.0';
    
    public function __construct() {
        $this->access_token = get_option('igf_access_token');
        $this->business_account_id = get_option('igf_business_account_id');
    }
    
    /**
     * Get Instagram feed
     */
    public function get_feed($limit = 12) {
        if (empty($this->access_token) || empty($this->business_account_id)) {
            return new WP_Error('missing_credentials', 'Instagram API credentials not configured');
        }
        
        // Check cache first
        $cache_key = 'igf_feed_cache';
        $cached_feed = get_transient($cache_key);
        
        if ($cached_feed !== false) {
            return $cached_feed;
        }
        
        // Fetch from API
        $feed = $this->fetch_from_api($limit);
        
        if (is_wp_error($feed)) {
            return $feed;
        }
        
        // Cache for 1 hour
        set_transient($cache_key, $feed, HOUR_IN_SECONDS);
        
        return $feed;
    }
    
    /**
     * Fetch feed from Instagram Graph API
     */
    private function fetch_from_api($limit) {
        $url = $this->api_url . '/' . $this->business_account_id . '/media';
        
        $args = array(
            'fields' => 'id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count',
            'access_token' => $this->access_token,
            'limit' => $limit
        );
        
        $response = wp_remote_get(add_query_arg($args, $url));
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!isset($data['data'])) {
            return new WP_Error('api_error', 'Failed to fetch Instagram feed');
        }
        
        return $data['data'];
    }
    
    /**
     * Test API connection
     */
    public function test_connection() {
        if (empty($this->access_token) || empty($this->business_account_id)) {
            return false;
        }
        
        $url = $this->api_url . '/' . $this->business_account_id;
        
        $response = wp_remote_get(add_query_arg(array(
            'access_token' => $this->access_token
        ), $url));
        
        return !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200;
    }
}