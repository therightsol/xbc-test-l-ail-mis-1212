<?php 

    if (! defined('ABSPATH') ) 
        exit('Direct Access is not allowed');

    /*add_action('admin_init', 'check_options');
    function check_options(){
        if (current_user_can('manage_options')){
            echo '<h1>Yes </h1>';
        }else {
            exit('no manage options');
        }
    }*/
        

    add_action('admin_menu', 'create_companies_menu');

    if (! function_exists('create_companies_menu')){
        function create_companies_menu(){
            // Companies page
            add_submenu_page(
                'mis',
                __('Companies', 'trs'),
                __('Companies', 'trs'),
                'manage_options',
                'mis-companies',
                'get_mis_companies_html'
            );
        }
    }


    if (! function_exists('get_mis_companies_html')){
        function get_mis_companies_html(){
            if (! filter_input_array(INPUT_POST)):
            ?>
                <div class="wrap">
                    <h1><?php _e('Register a Company', 'trs'); ?></h1>
                    <form class="form-horizontal"  method="post" action="<?php echo admin_url('admin.php?page=mis-companies'); ?>">
                         <div class="widefat">
                            <label for="name">Name:</label>
                            <input type="text" id="name" placeholder="Enter Company Name" value="" name="name">
                        </div>
                        <div class="widefat">
                            <label for="c_code">Company Code:</label>
                            <input type="text" id="c_code" placeholder="Enter Company Code" value="" name="c_code">
                            <span class="description">Company can logged in with code.</span>
                        </div>
                        <div class="widefat">
                            <label for="email">Email:</label>
                            <input type="text" id="email" placeholder="Enter Company Email" value="" name="email">
                        </div>
                        <div class="widefat">
                            <label for="address">Address:</label>
                            <textarea id="address" placeholder="Enter Company Address" name="address" cols="50" rows="5"></textarea>
                        </div>

                        <?php submit_button() ?>
                    </form>
                </div>
            <?php
            elseif (filter_input_array(INPUT_POST)):

                $name = esc_attr($_POST['name']);
                $address = esc_attr($_POST['address']);
                $c_code = esc_attr($_POST['c_code']);
                $email = esc_attr($_POST['email']);

                $clear_password = wp_generate_password(6);

                date_default_timezone_set('Asia/Karachi');

                $user = [
                    'user_login'    =>  $c_code,
                    'user_pass'     =>  wp_hash_password($clear_password),
                    'user_email'    =>  $email,
                    'user_registered'   => date('Y-m-d H:i:s'),
                    'user_nicename' =>  ucfirst($name),
                    'display_name'  => ucfirst($name)
                ];

                // Registering User
                $id = wp_insert_user( $user );

                update_user_meta($id, 'mis-address', $address);
                update_user_meta($id, 'mis-user_type', 'company');

                // Sending Welcome Email
                $msg = "Your company \"{$name}\" has been registered with " . get_bloginfo('blogname');
                wp_mail($email, 'Congrats! Your company has been registered', $msg);

                //@TODO: add success msg.

            endif;
        }
    }



    // Register Our Options
    add_action('admin_init', 'register_mis_options' );
    function register_mis_options(){
        //register_setting( 'group_mis', 'mis_options' );
    }