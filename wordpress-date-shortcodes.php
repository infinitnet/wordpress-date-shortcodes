<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin Name: WordPress Date Shortcodes
 * Description: Adds shortcodes for current, published, and last modified year and month.
 * Author: Infinitnet
 * Author URI: https://infinitnet.io/
 * Plugin URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Update URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Version: 1.3
 * License: GPLv3
 * Text Domain: wordpress-date-shortcodes
 */

// Main function
if ( ! function_exists( 'infinitnet_date_shortcode' ) ) {
    function infinitnet_date_shortcode( $type, $format, $atts ) {
        $atts = shortcode_atts( array('adjust' => 0), $atts );
        $adjustment = intval($atts['adjust']);

        switch ( $type ) {
            case 'current':
                if ($format == 'Y') {
                    $adjusted_date = strtotime("$adjustment year");
                } elseif ($format == 'F') {
                    $adjusted_date = strtotime("$adjustment month");
                } else {
                    $adjusted_date = strtotime("$adjustment day");
                }
                $date = date_i18n($format, $adjusted_date);
                break;
            case 'published':
            case 'modified':
                $post_date = ($type == 'published') ? get_the_date('Y-m-d', get_the_ID()) : get_the_modified_date('Y-m-d', get_the_ID());
                if ($format == 'Y') {
                    $date = date_i18n($format, strtotime("$post_date +$adjustment year"));
                } elseif ($format == 'F') {
                    $date = date_i18n($format, strtotime("$post_date +$adjustment month"));
                } else {
                    $date = date_i18n($format, strtotime("$post_date +$adjustment day"));
                }
                break;
            default:
                $date = '';
        }

        return $date;
    }
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-date-shortcodes.php';
Date_Shortcodes::register_shortcodes();

// Unified function to process meta content with shortcodes
function infinitnet_process_meta_content( $content ) {
    return do_shortcode( $content );
}

// Attach the function to filters for Rank Math, Yoast, and SEOPress
add_filter( 'rank_math/frontend/title', 'infinitnet_process_meta_content' );
add_filter( 'rank_math/frontend/description', 'infinitnet_process_meta_content' );
add_filter( 'wpseo_title', 'infinitnet_process_meta_content' );
add_filter( 'wpseo_metadesc', 'infinitnet_process_meta_content' );
add_filter( 'seopress_titles_title', 'infinitnet_process_meta_content' );
add_filter( 'seopress_titles_desc', 'infinitnet_process_meta_content' );

// Filters for processing shortcodes in Contextual Related Posts (CRP) plugin
add_filter('crp_title', 'do_shortcode');
add_filter('crp_thumb_title', 'do_shortcode');
add_filter('crp_thumb_alt', 'do_shortcode');

// Filter for processing shortcodes in all titles
function infinitnet_process_all_titles( $title ) {
    if ( ! is_admin() ) {
        return do_shortcode( $title );
    }
    return $title;
}
add_filter( 'the_title', 'infinitnet_process_all_titles' );

// Process shortcodes in Rank Math breadcrumbs
add_filter('rank_math/frontend/breadcrumb/items', function($crumbs, $class) {
    foreach ($crumbs as &$crumb) {
        if (isset($crumb[0])) {
            $crumb[0] = infinitnet_process_meta_content($crumb[0]);
        }
    }
    return $crumbs;
}, 10, 2);
