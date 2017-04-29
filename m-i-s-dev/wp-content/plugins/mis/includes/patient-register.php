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
        elseif(filter_input_array(INPUT_POST)):

            $uid = esc_attr($_POST['mis-pid']);


            ?>

            <form action='' method="POST">

                <div class="form-group">
                    <label for="pid"><?php _e('Patient ID: ', 'trs'); ?></label>
                    <input class="form-control" type="text" name="mis-pid" id="pid" value="<?=$uid?>" readonly>
                </div>


                <div class="form-group">
                    <label for="ftests">Choose / Search Test</label>
                    <select name="mis_test_list" class="form-control" id="fte111ts">
                         <?php

                         $args = [
                             'post_type'  =>   'mistests',
                             'post_status'   =>  'publish'
                         ];

                         $result = new WP_Query( $args );

                         if ($result->have_posts()):
                             while ($result->have_posts()): $result->the_post();

                                 echo '<option value="'.get_the_ID().'">' . get_the_title() . '</option>';


                             endwhile;
                         else:
                             echo '<option value="nofound">No Data Found</option>';
                         endif;


                         ?>
                    </select>
                </div>

            </form>

        <?php



        endif;



    }

    if (!function_exists('get_mis_patient_unique_id')) {
        function get_mis_patient_unique_id(){
            $unix_time = time();

            return $unix_time;
        }
    }