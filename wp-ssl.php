<?php
/*
Plugin Name: WordPress SSL
Plugin URI: http://codemaster.fi/wordpress/plugins/wp-ssl/
Description: Map URLs to SSL if the site is accessed via SSL
Version: 1.0.0
Author: S H Mohanjith (Code Master)
Author URI: http://codemaster.fi/
*/

class Wp_Ssl {

        public function __construct() {
                if ( is_ssl() ) {
                        add_filter( 'pre_option_siteurl', array($this, 'pre_option_siteurl') );
                        add_filter( 'pre_option_home', array($this, 'pre_option_home') );
                        add_filter( 'the_content', array($this, 'the_content') );

                        /*add_filter( 'print_head_scripts', array($this, 'print_head_scripts'), 1, 1);

                        add_filter( 'plugins_url', array($this, 'plugins_url'), 10, 3);
                        add_filter( 'site_url', array($this, 'site_url'), 10, 4);
                        add_filter( 'home_url', array($this, 'home_url'), 10, 3);

                        add_filter( 'includes_url', array($this, 'includes_url'), 10, 2);*/
                }
        }

        public function pre_option_siteurl($value) {
                if (preg_match('/^http:/', $value) > 0) {
                        $value = preg_replace('/^http:/', 'https:', $value);
                }
                return $value;
        }

        public function pre_option_home($value) {
                if (preg_match('/^http:/', $value) > 0) {
                        $value = preg_replace('/^http:/', 'https:', $value);
                }
                return $value;
        }

        public function the_content($content) {
                $new_url = get_option('siteurl');
                $orig_url = preg_replace('/^https:/', 'http:', $new_url);

                str_replace( trailingslashit($orig_url), trailingslashit($new_url), $content );

                return $content;
        }

}

new Wp_Ssl();
