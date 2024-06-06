<?php

class Date_Shortcodes {

    public static function register_shortcodes() {
        add_shortcode( 'currentyear', array( __CLASS__, 'current_year_shortcode' ) );
        add_shortcode( 'publishedyear', array( __CLASS__, 'published_year_shortcode' ) );
        add_shortcode( 'modifiedyear', array( __CLASS__, 'modified_year_shortcode' ) );
        
        add_shortcode( 'currentmonth', array( __CLASS__, 'current_month_shortcode' ) );
        add_shortcode( 'publishedmonth', array( __CLASS__, 'published_month_shortcode' ) );
        add_shortcode( 'modifiedmonth', array( __CLASS__, 'modified_month_shortcode' ) );
        
        add_shortcode( 'currentday', array( __CLASS__, 'current_day_shortcode' ) );
        add_shortcode( 'publishedday', array( __CLASS__, 'published_day_shortcode' ) );
        add_shortcode( 'modifiedday', array( __CLASS__, 'modified_day_shortcode' ) );
    }

    public static function current_year_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'current', 'Y', $atts );
    }

    public static function published_year_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'published', 'Y', $atts );
    }

    public static function modified_year_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'modified', 'Y', $atts );
    }

    public static function current_month_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'current', 'F', $atts );
    }

    public static function published_month_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'published', 'F', $atts );
    }

    public static function modified_month_shortcode( $atts ) {
        return infinitnet_date_shortcode( 'modified', 'F', $atts );
    }

    public static function current_day_shortcode( $atts ) {
        $day_format = preg_match( '/[jS]/', get_option( 'date_format' ), $day_only_format ) ? $day_only_format[0] : 'j';
        return infinitnet_date_shortcode( 'current', $day_format, $atts );
    }

    public static function published_day_shortcode( $atts ) {
        $day_format = preg_match( '/[jS]/', get_option( 'date_format' ), $day_only_format ) ? $day_only_format[0] : 'j';
        return infinitnet_date_shortcode( 'published', $day_format, $atts );
    }

    public static function modified_day_shortcode( $atts ) {
        $day_format = preg_match( '/[jS]/', get_option( 'date_format' ), $day_only_format ) ? $day_only_format[0] : 'j';
        return infinitnet_date_shortcode( 'modified', $day_format, $atts );
    }
}
