<?php
if (! defined('ABSPATH') )
    exit('Direct Access is not allowed');


add_action('admin_menu', 'mis_main_menu');

if (! function_exists('mis_main_menu')) {
    function mis_main_menu()
    {

        // Top Level Page
        add_menu_page(
            __('MIS', 'trs'),
            __("MIS", 'trs'),
            'manage_options',
            'mis',
            '',
            'dashicons-desktop',
            6
        );

        // Top Level Submenu
        add_submenu_page(
            'mis',
            __('MIS', 'trs'),
            __('MIS', 'trs'),
            'manage_options',
            'mis',
            'get_mis_html'
        );
    }
}


if (! function_exists('get_mis_html')){
    function get_mis_html(){
        echo 'hi';
    }
}