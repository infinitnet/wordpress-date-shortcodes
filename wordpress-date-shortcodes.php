<?php
/**
 * Plugin Name: WordPress Date Shortcodes
 * Description: Adds shortcodes for current, published, and last modified year and month.
 * Author: Infinitnet
 * Author URI: https://infinitnet.io/
 * Plugin URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Update URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Version: 1.2
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

// Year shortcodes
add_shortcode( 'currentyear', function($atts) { return infinitnet_date_shortcode('current', 'Y', $atts); });
add_shortcode( 'publishedyear', function($atts) { return infinitnet_date_shortcode('published', 'Y', $atts); });
add_shortcode( 'modifiedyear', function($atts) { return infinitnet_date_shortcode('modified', 'Y', $atts); });

// Month shortcodes
add_shortcode( 'currentmonth', function($atts) { return infinitnet_date_shortcode('current', 'F', $atts); });
add_shortcode( 'publishedmonth', function($atts) { return infinitnet_date_shortcode('published', 'F', $atts); });
add_shortcode( 'modifiedmonth', function($atts) { return infinitnet_date_shortcode('modified', 'F', $atts); });

// Day shortcodes
add_shortcode( 'currentday', function($atts) {
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('current', $day_format, $atts);
});
add_shortcode( 'publishedday', function($atts) {
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('published', $day_format, $atts);
});
add_shortcode( 'modifiedday', function($atts) {
    $day_format = preg_match('/[jS]/', get_option('date_format'), $day_only_format) ? $day_only_format[0] : 'j';
    return infinitnet_date_shortcode('modified', $day_format, $atts);
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
