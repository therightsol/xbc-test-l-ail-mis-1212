<?php 

    if (! defined('ABSPATH') ) 
        exit('Direct Access is not allowed');

    
    if (! defined('TESTS_POST_TYPE'))
        define('TESTS_POST_TYPE', 'mistests');


// Adding categories / departments

function custom_post_type() {

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'MIS Tests', 'Post Type General Name', 'trs' ),
        'singular_name'       => _x( 'MIS Test', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'MIS Tests', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Test', 'twentythirteen' ),
        'all_items'           => __( 'All tests', 'twentythirteen' ),
        'view_item'           => __( 'View Tests', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New ', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Tests', 'twentythirteen' ),
        'update_item'         => __( 'Update Tests', 'twentythirteen' ),
        'search_items'        => __( 'Search Tests', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'Tests', 'twentythirteen' ),
        'description'         => __( 'Tests', 'twentythirteen' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

        // This is where we add taxonomies to our CPT

    );

    // Registering your Custom Post Type
    register_post_type( TESTS_POST_TYPE, $args );


    // Registering Categories.

    $labels = array(
        'name'              => _x( 'MIS Departments', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'MIS Department', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Departments', 'textdomain' ),
        'all_items'         => __( 'All Departments', 'textdomain' ),
        'parent_item'       => __( 'Parent Department', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Department:', 'textdomain' ),
        'edit_item'         => __( 'Edit Department', 'textdomain' ),
        'update_item'       => __( 'Update Department', 'textdomain' ),
        'add_new_item'      => __( 'Add New Department', 'textdomain' ),
        'new_item_name'     => __( 'New Department Name', 'textdomain' ),
        'menu_name'         => __( 'Department', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    );

    register_taxonomy( 'mistests_cats', array( TESTS_POST_TYPE ), $args );

}


add_action('add_meta_boxes_' . TESTS_POST_TYPE, 'trs_create_tests_meta_boxes');
if (! function_exists('trs_create_tests_meta_boxes')){
    function trs_create_tests_meta_boxes(){
        add_meta_box('tests-price', 'Test Price', 'trs_get_test_price_html', [TESTS_POST_TYPE]);
    }
}

if(! function_exists('trs_get_test_price_html')){
    function trs_get_test_price_html( $post ){
        
        $value = esc_attr(get_post_meta($post->ID, 'test_price', true));
        
        $value = empty($value) ? '' : $value;
        
        
        
        ob_start();
        ?>

        <label for="test_price">Price</label>
        <input type="number" min="1" class="" id="test_price" name="test_price" placeholder="Example: 450" value="<?php echo esc_attr($value); ?>">
        <span>PKRS</span>
        
        <?php
        echo ob_get_clean();
    }
}


add_action('save_post_' . TESTS_POST_TYPE, 'trs_tests_post_saving');
if (! function_exists('trs_tests_post_saving')){
    function trs_tests_post_saving( $post_id ){
        if(wp_is_post_autosave($post_id))
            return true;
        
        if (wp_is_post_revision($post_id))
            return true;
            
        if (!current_user_can('manage_options'))
            return true;
        
        $post_data = filter_input_array(INPUT_POST);
        
        $test_price = esc_attr($post_data['test_price']);
        
        update_post_meta($post_id, 'test_price', $test_price);
        
        return true;
    }
}




/*@TODO: Put MIS Tests menu under MIS*/
add_action('admin_menu', 'creates_tests_menu');


// Adding a sub menu
	if (! function_exists('creates_tests_menu')){
		function creates_tests_menu(){
			// Companies page
			add_submenu_page(
				'mis',
				__('Tests', 'trs'),
				__('Tests', 'trs'),
				'manage_options',
				'mis-tests',
				'get_mis_tests_html'
			);
		}
	}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_type', 0 );


if (! function_exists('get_mis_tests_html')){
    function get_mis_tests_html(){
        if (! filter_input_array(INPUT_POST)):
            ?>
            <div class="wrap">
                <h1><?php _e('Register New Test', 'trs'); ?></h1>
                <form class="form-horizontal"  method="post" action="<?php echo admin_url('admin.php?page=mis-companies'); ?>">
                    <div class="widefat">
                        <label for="name">Name:</label>
                        <input type="text" id="name" placeholder="Enter Company Name" value="" name="name">
                    </div>
                    <div class="widefat">
                        <label for="c_code">Test Code:</label>
                        <input type="text" id="c_code" placeholder="Enter Company Code" value="" name="c_code">
                        <span class="description">Company can logged in with code.</span>
                    </div>
                    <div class="widefat">
                        <label for="email">Price:</label>
                        <input type="text" id="price" placeholder="Enter Company Email" value="" name="email">
                    </div>
                    <div class="widefat">
                        <label for="address">description:</label>
                        <textarea id="address" placeholder="Enter Company Address" name="address" cols="50" rows="5"></textarea>
                    </div>
                    <div class="widefat">
                       <!--drop down menu-->
                        <label for="address">Department:</label>
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