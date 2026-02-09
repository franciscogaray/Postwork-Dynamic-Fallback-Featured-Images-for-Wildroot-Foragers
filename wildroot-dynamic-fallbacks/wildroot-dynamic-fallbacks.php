<?php
/**
 * Plugin Name: Wildroot Dynamic Fallbacks
 * Description: Implements hierarchical fallback images for Wildroot Foragers (Posts & Products).
 * Version: 1.0.0
 * Author: Francisco Garay
 * Author URI: https://franciscogaray.me
 */

if (!defined('ABSPATH')) exit;

// Define constants
define('WDF_PATH', plugin_dir_path(__FILE__));

require_once WDF_PATH . 'includes/settings-page.php';

/**
 * Intercept the post thumbnail ID call to provide fallbacks.
 */
function wdf_fallback_image_logic($metadata, $object_id, $meta_key, $single) {
    // Only target the featured image meta key
    if ($meta_key !== '_thumbnail_id' || !is_numeric($object_id)) {
        return $metadata;
    }

    // Check if the post actually has a thumbnail set in the DB
    remove_filter('get_post_metadata', 'wdf_fallback_image_logic', 10);
    $current_thumbnail = get_post_meta($object_id, '_thumbnail_id', true);
    add_filter('get_post_metadata', 'wdf_fallback_image_logic', 10, 4);

    // 1. Assigned Featured Image: If it exists, use it.
    if (!empty($current_thumbnail)) {
        return $metadata;
    }

    $fallback_id = null;
    $options = get_option('wdf_settings');
    $post_type = get_post_type($object_id);

    // 2. Category-Specific Default
    $taxonomy = ($post_type === 'product') ? 'product_cat' : 'category';
    $terms = get_the_terms($object_id, $taxonomy);

    if ($terms && !is_wp_error($terms)) {
        // Use the first category assigned
        $primary_cat_id = $terms[0]->term_id;
        if (!empty($options['category_map'][$primary_cat_id])) {
            $fallback_id = $options['category_map'][$primary_cat_id];
        }
    }

    // 3. Global Fallback
    if (!$fallback_id && !empty($options['global_fallback'])) {
        $fallback_id = $options['global_fallback'];
    }

    // Developer Friendly: Custom filter for programmatic overrides
    $fallback_id = apply_filters('wdf_custom_fallback_override', $fallback_id, $object_id);

    return $fallback_id ? (string)$fallback_id : $metadata;
}

add_filter('get_post_metadata', 'wdf_fallback_image_logic', 10, 4);