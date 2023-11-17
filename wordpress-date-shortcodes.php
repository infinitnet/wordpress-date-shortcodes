<?php
/**
 * Plugin Name: WordPress Date Shortcodes
 * Description: Adds shortcodes for current, published, and last modified year and month.
 * Author: Infinitnet
 * Author URI: https://infinitnet.io/
 * Plugin URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Update URI: https://github.com/infinitnet/wordpress-date-shortcodes
 * Version: 1.0
 * License: GPLv3
 * Text Domain: wordpress-date-shortcodes
 */

// Shortcode functions for current year and current month
if ( ! function_exists( 'infinitnet_current_year_shortcode' ) ) {
    function infinitnet_current_year_shortcode() {
        return date_i18n( 'Y' );
    }
    add_shortcode( 'currentyear', 'infinitnet_current_year_shortcode' );
}

if ( ! function_exists( 'infinitnet_current_month_shortcode' ) ) {
    function infinitnet_current_month_shortcode() {
        return date_i18n( 'F' );
    }
    add_shortcode( 'currentmonth', 'infinitnet_current_month_shortcode' );
}

// Shortcode to display the published year
if ( ! function_exists( 'infinitnet_published_year_shortcode' ) ) {
    function infinitnet_published_year_shortcode() {
        global $post;
        return get_the_date('Y', $post->ID);
    }
    add_shortcode( 'publishedyear', 'infinitnet_published_year_shortcode' );
}

// Shortcode to display the published month
if ( ! function_exists( 'infinitnet_published_month_shortcode' ) ) {
    function infinitnet_published_month_shortcode() {
        global $post;
        return get_the_date('F', $post->ID);
    }
    add_shortcode( 'publishedmonth', 'infinitnet_published_month_shortcode' );
}

if ( ! function_exists( 'infinitnet_modified_year_shortcode' ) ) {
    function infinitnet_modified_year_shortcode() {
        global $post;
        return get_the_modified_date('Y', $post->ID);
    }
    add_shortcode( 'modifiedyear', 'infinitnet_modified_year_shortcode' );
}

// Shortcode to display the last modified month
if ( ! function_exists( 'infinitnet_modified_month_shortcode' ) ) {
    function infinitnet_modified_month_shortcode() {
        global $post;
        return get_the_modified_date('F', $post->ID);
    }
    add_shortcode( 'modifiedmonth', 'infinitnet_modified_month_shortcode' );
}

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
