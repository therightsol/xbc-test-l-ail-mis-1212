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
        'singular_name'       => _x( 'MIS Test', 'Post Type Singular Name', 'twentythirteen', 'trs'  ),
        'menu_name'           => __( 'MIS Tests', 'twentythirteen', 'trs'  ),
        'parent_item_colon'   => __( 'Parent Test', 'twentythirteen', 'trs'  ),
        'all_items'           => __( 'All tests', 'twentythirteen', 'trs'  ),
        'view_item'           => __( 'View Tests', 'twentythirteen', 'trs'  ),
        'add_new_item'        => __( 'Add New ', 'twentythirteen', 'trs'  ),
        'add_new'             => __( 'Add New', 'twentythirteen', 'trs'  ),
        'edit_item'           => __( 'Edit Tests', 'twentythirteen', 'trs'  ),
        'update_item'         => __( 'Update Tests', 'twentythirteen', 'trs'  ),
        'search_items'        => __( 'Search Tests', 'twentythirteen', 'trs'  ),
        'not_found'           => __( 'Not Found', 'twentythirteen', 'trs'  ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen', 'trs'  ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'Tests', 'twentythirteen', 'trs'  ),
        'description'         => __( 'Tests', 'twentythirteen', 'trs'  ),
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
        'name'              => _x( 'MIS Departments', 'taxonomy general name','trs'  ),
        'singular_name'     => _x( 'MIS Department', 'taxonomy singular name', 'textdomain', 'trs'  ),
        'search_items'      => __( 'Search Departments','trs'  ),
        'all_items'         => __( 'All Departments','trs'  ),
        'parent_item'       => __( 'Parent Department','trs'  ),
        'parent_item_colon' => __( 'Parent Department:','trs'  ),
        'edit_item'         => __( 'Edit Department','trs'  ),
        'update_item'       => __( 'Update Department','trs'  ),
        'add_new_item'      => __( 'Add New Department','trs'  ),
        'new_item_name'     => __( 'New Department Name', 'trs'  ),
        'menu_name'         => __( 'Department', 'trs'  ),
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


                    }
}