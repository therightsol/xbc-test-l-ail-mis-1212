<?php 

    if (! defined('ABSPATH') ) 
        exit('Direct Access is not allowed');


    add_action('wp_enqueue_scripts', 'enque_mis_scripts');

    if (! function_exists('enque_mis_scripts')){
        function enque_mis_scripts(){
            wp_enqueue_style('mis-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
            wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css');
            wp_enqueue_script('mis-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['jquery'], null, true);
            wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', ['jquery'], null, true);
            wp_enqueue_script('frontend', MIS_ASSETS . '/js/frontend.js', ['jquery', 'select2'], null, true);
	
	
			wp_localize_script( 'frontend', 'ajax_object',
								array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        
        }
    }