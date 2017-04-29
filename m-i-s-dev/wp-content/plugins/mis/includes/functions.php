<?php 

    if (! defined('ABSPATH') ) 
        exit('Direct Access is not allowed');


    if (! function_exists('mis_plugin_activated')) {
        function mis_plugin_activated()
        {
            // Create Page with regform
            wp_insert_post(
                [
                    'post_type' => 'page',
                    'post_title' => "Patient Registration Form",
                    'post_content' => "[" . REG_FORM_KEY . "]",
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'blog'
                ]
            );


            // Create 'Companies' Table
            /*
             * id, name, address, contact, email
             *
             *
             * */



        }
    }