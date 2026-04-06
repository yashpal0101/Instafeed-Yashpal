<?php
/**
 * Shortcode Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class IGF_Shortcode {
    
    public function __construct() {
        add_shortcode('instagram_feed', array($this, 'render_feed'));
    }
    
    /**
     * Render Instagram feed shortcode
     * [instagram_feed limit="12" columns="3"]
     */
    public function render_feed($atts) {
        $atts = shortcode_atts(array(
            'limit' => 12,
            'columns' => 3,
            'show_captions' => false,
            'show_stats' => false
        ), $atts, 'instagram_feed');
        
        $instagram = new Instagram_API();
        $feed = $instagram->get_feed($atts['limit']);
        
        if (is_wp_error($feed)) {
            return '<p class="igf-error">' . esc_html($feed->get_error_message()) . '</p>';
        }
        
        ob_start();
        ?>
        <div class="igf-feed" style="display: grid; grid-template-columns: repeat(<?php echo intval($atts['columns']); ?>, 1fr); gap: 15px;">
            <?php foreach ($feed as $post) : ?>
                <div class="igf-post">
                    <a href="<?php echo esc_url($post['permalink']); ?>" target="_blank" rel="noopener noreferrer" class="igf-post-link">
                        <img src="<?php echo esc_url($post['media_url']); ?>" alt="Instagram post" class="igf-post-image" style="width: 100%; height: auto; display: block;">
                    </a>
                    
                    <?php if ($atts['show_captions'] && !empty($post['caption'])) : ?>
                        <div class="igf-caption" style="padding: 10px; font-size: 14px;">
                            <?php echo wp_kses_post(wp_trim_words($post['caption'], 20)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($atts['show_stats']) : ?>
                        <div class="igf-stats" style="padding: 10px; font-size: 12px; color: #666;">
                            <span>❤️ <?php echo intval($post['like_count']); ?></span> | 
                            <span>💬 <?php echo intval($post['comments_count']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize shortcode
new IGF_Shortcode();
