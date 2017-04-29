<?php
    /*
        Plugin Name: Secure Admin URL
        Plugin URI:  http://therightsol.com/
        Description: This is fourth plugin in Plugin Development Class. This plugin check an additional string in wp-admin; if not found then it redirect back to home page
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


    if (!defined('STK'))
        define('STK', 'secret');

    if (!defined('STV'))
        define('STV', '12');

    function update_login_url($login_url){
        if (isset($_GET[STK])) // $_GET['x']
           $login_url .= '&' . STK . '=' . esc_attr($_GET[STK]);



        return $login_url;
    }
    add_filter('login_url', 'update_login_url');











    function trs_check_loginurl(){
        if (is_user_logged_in()) return;










        if ($GLOBALS['pagenow'] === 'wp-login.php' && !isset($_GET[SECRET_TOKEN_KEY])){

            wp_redirect(home_url('/'));

        }else {
            if ( $_GET[SECRET_TOKEN_KEY] !== SECRET_TOKEN_VALUE )
                wp_redirect(home_url('/'));
        }
    }
   add_action('init', 'trs_check_loginurl');





    /**
     * Register a custom menu page.
     */
function wpdocs_register_my_custom_menu_page(){
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'custom menu 12',
        'manage_options',
        'custompage',
        'my_custom_menu_page',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

/**
 * Display a custom menu page
 */
function my_custom_menu_page(){
    ?>
    <h1>This is </h1>
    <form action=""><input type="text"></form>
    <?php
}



