<?php
/**
 * Plugin Name: WordPress Date Shortcodes
 * Description: Adds shortcodes for current, published, and last modified year and month.
 * Author: Infinitnet
 * Author URI: https://infinitnet.io/
 * Plugin URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Update URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Version: 1.1
 * License: GPLv3
 * Text Domain: wordpress-date-shortcodes
 */

// Main function
if ( ! function_exists( 'infinitnet_date_shortcode' ) ) {
    function infinitnet_date_shortcode( $type, $format, $adjustment = 0, $post_date = '' ) {
        switch ( $type ) {
            case 'current':
                $date = date_i18n($format, strtotime("$adjustment days"));
                break;
            case 'published':
                $date = get_the_date($format, get_the_ID());
                break;
            case 'modified':
                $date = get_the_modified_date($format, get_the_ID());
                break;
            default:
                $date = '';
        }

        if ($type !== 'current' && $adjustment !== 0) {
            $date = date_i18n($format, strtotime("$post_date $adjustment days"));
        }

        return $date;
    }
}

// Year shortcodes
add_shortcode( 'currentyear', function() { return infinitnet_date_shortcode('current', 'Y'); });
add_shortcode( 'publishedyear', function() { return infinitnet_date_shortcode('published', 'Y'); });
add_shortcode( 'modifiedyear', function() { return infinitnet_date_shortcode('modified', 'Y'); });

// Month shortcodes
add_shortcode( 'currentmonth', function() { return infinitnet_date_shortcode('current', 'F'); });
add_shortcode( 'publishedmonth', function() { return infinitnet_date_shortcode('published', 'F'); });
add_shortcode( 'modifiedmonth', function() { return infinitnet_date_shortcode('modified', 'F'); });

// Day shortcodes
add_shortcode( 'currentday', function($atts) {
    $atts = shortcode_atts( array('adjust' => 0), $atts, 'currentday' );
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('current', $day_format, intval($atts['adjust']));
});
add_shortcode( 'publishedday', function($atts) {
    $atts = shortcode_atts( array('adjust' => 0), $atts, 'publishedday' );
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('published', $day_format, intval($atts['adjust']), get_the_date('Y-m-d'));
});
add_shortcode( 'modifiedday', function($atts) {
    $atts = shortcode_atts( array('adjust' => 0), $atts, 'modifiedday' );
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('modified', $day_format, intval($atts['adjust']), get_the_modified_date('Y-m-d'));
});

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
