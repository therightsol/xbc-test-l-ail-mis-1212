<?php
	/**
	 * Created by PhpStorm.
	 * User: Ali Shan
	 * Date: 5/20/2017
	 * Time: 9:08 AM
	 */
	
	
	
	add_action( 'wp_ajax_get_patient_record', 'mis_get_patient_record' );
	
	function mis_get_patient_record() {
		global $wpdb; // this is how you get access to the database
		
		
		$postData = filter_input_array(INPUT_POST);
		$user_login = esc_attr($postData['pid']);
		
		
		$user = (array) get_user_by('login', $user_login);
		$user_meta = get_user_meta($user['ID']);
		
		$user = array_merge($user, $user_meta);
		
		if (intval(count($user)) === 0)
			echo 'not-found';
		else
			echo json_encode($user);
		
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}