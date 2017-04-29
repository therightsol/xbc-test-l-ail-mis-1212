<?php
    /*
        Plugin Name: Update Title
        Plugin URI:  http://therightsol.com/
        Description: This is fifth plugin. This plugin update title (add extra text with every title)
        Version:     1.0
        Author:      Ali Shan
        Author URI:  http://therightsol.com/
        License:     GPL2
        License URI: https://www.gnu.org/licenses/gpl-2.0.html
        Text Domain: therightsol
        Domain Path: /languages
    */

    if (! defined('ABSPATH'))
        exit ('You can not access directly.');


    if (!defined('EXTRA_TITLE'))
        define('EXTRA_TITLE', ' - AIL ');


    function trs_update_title( $title ) {

        return $title . EXTRA_TITLE;
    }
    add_filter('the_title', 'trs_update_title');

