<?php 

    if (! defined('ABSPATH') ) 
        exit('Direct Access is not allowed');


    define('REG_FORM_KEY', 'regform');

    //@TODO: Convert all strings into _e for translation in this file.



    add_shortcode(REG_FORM_KEY, 'patient_register_form');
    function patient_register_form(){

        // get patient unique ID
        $uid = get_mis_patient_unique_id();


        $args = array(
            'meta_key' => 'mis-user_type',
            'meta_value' => 'company'
        );

        $u = new WP_User_Query( $args );


        ob_start();
        if (! filter_input_array(INPUT_POST)):
        ?>

       <h1><strong>Patient Registration Form</strong></h1>


        <form action='' method="POST">

            <div class="form-group">
                <label for="pid"><?php _e('Patient ID: ', 'trs'); ?></label>
                <input class="form-control" type="text" name="mis-pid" id="pid" value="<?=$uid?>" readonly>
            </div>

            <div class="form-group">
                <label for="name"><?php _e('Name: ', 'trs'); ?></label>
                <input class="form-control" type="text" name="mis-name" id="name" value="" placeholder="Enter patient name">
            </div>

            <div class="form-group">
                <label for="phone-number"><?php _e('Phone Number:', 'trs'); ?> </label>
                <input maxlength="13" class="form-control" type="text" name="mis-phone-number" id="phone-number" value="" placeholder="Enter Patient Phone Number">
            </div>

            <div class="form-group">
                <label for="age"><?php _e('Age:', 'trs'); ?> </label>
                <input class="form-control" type="text" name="mis-age" id="age" value="" placeholder="Enter patient age">
            </div>


            <div class="form-group">
                <label for="sex"><?php _e('Sex:', 'trs'); ?></label>

                <label for="sex-male"> <?php _e('Male', 'trs'); ?>
                    <input type="radio" name="mis-sex" id="sex-male" value="male">
                </label>

                <label for="sex-female"> <?php _e('Female', 'trs'); ?>
                    <input type="radio" name="mis-sex" id="sex-female" value="female">
                </label>
            </div>

            <div class="form-group">
                <label for="company">Location: </label>
                <select name="mis-copmany" id="company">
                    <?php
                    // User Loop
                    if ( ! empty( $u->results ) ) {
                        foreach ( $u->results as $user ) {
                            echo '<option value="'.$user->ID.'">'. $user->display_name .'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit">
            </div>

        </form>


        <?php
        elseif(filter_input_array(INPUT_POST) && !isset($_GET['step'])):

            $uid = esc_attr($_POST['mis-pid']);
            /*
             * @TODO: All patient registration form (sex, location, age etc) should also be saved.
            */
			$phone = esc_attr($_POST['mis-phone-number']);


            ?>

            <form action='<?php echo rtrim($_SERVER['REDIRECT_URL'], '/') . '?step=2&status=success'; ?>' method="POST">

                <input type="hidden" name="phone-number" value="<?php echo $phone; ?>">
                
                <div class="form-group">
                    <label for="pid"><?php _e('Patient ID: ', 'trs'); ?></label>
                    <input class="form-control" type="text" name="mis-pid" id="pid" value="<?=$uid?>" readonly>
                </div>


                <div class="form-group">
                    <label for="ftests"><?php __('Choose / Search Test:', 'trs'); ?></label>
                    <select name="mis_test_list" class="form-control mis_test_list" id="ftests">
                         <?php

                         $args = [
                             'post_type'  =>   'mistests',
                             'post_status'   =>  'publish'
                         ];

                         $result = new WP_Query( $args );

                         if ($result->have_posts()):
							 echo '<option data-testprice=""  value="">Please choose Test</option>';
                             while ($result->have_posts()): $result->the_post();

                                $price =  get_post_meta(get_the_ID(), 'test_price', true);
                                 echo '<option data-testprice="'.$price.'"  value="'.get_the_ID().'">' . get_the_title() . '  -  @ Rs. ' . $price . '</option>';


                             endwhile;
                         else:
                             echo '<option data-testprice="" value="nofound">No Data Found</option>';
                         endif;


                         ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tprice"><?php __('Total Price:', 'trs');?></label>
                    <input type="text" id="tprice" readonly value="" class="form-control">
                </div>
                
                <div class="form-group">
                    <button disabled class="patient_register_step2_submit_btn btn btn-primary">Register Patient</button>
                </div>

            </form>

        <?php


        elseif(filter_input_array(INPUT_POST) && isset($_GET['step'])):
 
            $post_data = filter_input_array(INPUT_POST);
            
            $patient_id = esc_attr($post_data['mis-pid']);
            $test_lists = esc_attr($post_data['mis_test_list']);
            $phone_number = esc_attr($post_data['phone-number']);
			
            $password = wp_hash_password(wp_generate_password(8));
            
            $uid = wp_create_user($patient_id, $password);
            
            /*@TODO: Make Tests Entry more Sophisticated
            PROBLEM:
            What will happen if User registered more tests after 10 minutes.
            Even the previously tests are in progress.
            It will definitely delete old record and add only new registered test.
            
            SOLUTION:
            Execution should come here only if the user is not registered.
            if user is already registered, merge old tests with new one.
            
            
            PROBLEM:
            if the old tests are very old and all tests are out dated, then what will happen ?
            
            SOLUTION:
            --> IMPORTANT <-- second or third or mulitple visits must be treated as separate orders with unique orderID

            We should save test date and status against each record. It should be multidimentional array.
                array(
                    01
                        =>  '25/June/2014'
                            'TestLists'
                                =>  [
                                    'test-code/post_id' => 'status',
                                    'test-code/post_id' => 'status',
                                    'test-code/post_id' => 'status',
                                ],
                            'OverallStatus'
                                =>  [
                                    Completed
                                ]
                
                    02
                        =>  '15/April/2017'
                            'TestLists'
                                =>  [
                                    'test-code/post_id' => 'pending',
                                ],
                            'OverallStatus'
                                =>  [
                                    in process
                                ]
                )
            */

            //var_export($_SERVER);
            
            
            if ($uid && !is_object($uid)):
                update_user_meta($uid, 'registered_tests_ids', $test_lists);
                update_user_meta($uid, 'phone_number', $phone_number);
                ?>
                
                <div class="alert alert-success">
                    Patient has been successfully registered.
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Go Back</a>
                </div>
    
                <?php
            endif;
        
        endif;



    }

    if (!function_exists('get_mis_patient_unique_id')) {
        function get_mis_patient_unique_id(){
            $unix_time = time();

            return $unix_time;
        }
    }