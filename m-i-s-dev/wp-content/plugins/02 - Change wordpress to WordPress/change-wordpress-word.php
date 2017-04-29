<?php
    /*
        Plugin Name: Change wordpress to WordPress
        Plugin URI:  http://therightsol.com/
        Description: This is second plugin in Plugin Development Class. This plugin change wordpress into WordPress.
        Version:     1.0
        Author:      Ali Shan
        Author URI:  http://therightsol.com/
        License:     GPL2
        License URI: https://www.gnu.org/licenses/gpl-2.0.html
        Text Domain: therightsol
        Domain Path: /languages
    */

    if (!defined('ABSPATH'))
        exit ('You can not access directly.');





    function change_wordpress_word( $content ){
        return str_replace('wordpress', 'WordPress', $content);
    }
    add_filter('the_content', 'change_wordpress_word');

