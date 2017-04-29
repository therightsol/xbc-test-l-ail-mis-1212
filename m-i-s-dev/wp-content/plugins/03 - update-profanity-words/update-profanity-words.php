<?php
    /*
        Plugin Name: Change Profanity words to stars
        Plugin URI:  http://therightsol.com/
        Description: This is third plugin in Plugin Development Class. This plugin check profanity word. If found replace with ***
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

    function change_profanity_words( $content ) {
        $profanity_words = [
            'asshole', 'asses', 'ass', 'bullshit'
        ];

        return str_replace($profanity_words, '***', $content);
    }
    add_filter('the_content', 'change_profanity_words');

