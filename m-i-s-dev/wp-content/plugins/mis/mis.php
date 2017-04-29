<?php
    /*
        Plugin Name: MIS
        Plugin URI:  http://www.therightsol.com/
        Description: Management Information System for Hospitals
        Version:     1.0
        Author:      Ali Shan - Obaid Ullah Qazi
        Author URI:  https://www.therightsol.com/
        License:     GPL2
        License URI: https://www.gnu.org/licenses/gpl-2.0.html
        Text Domain: trs
        Domain Path: /languages
    */

    //
    define('MIS_ASSETS', plugins_url('/assets', __FILE__));

    // all general functions.
    require_once ('includes/functions.php');

    // registering scripts
    require_once ('includes/register-scripts.php');

    // Patient Register
    require_once ('includes/patient-register.php');

    // MIS Main Menu
    require_once ('includes/mis-backend-main-menu.php');

    // MIS Add Companies
    require_once ('includes/mis-backend-companies.php');

    // MIS add tests
    require_once ('includes/mis-backend-tests.php');


    // Hook plugin activated
    register_activation_hook( __FILE__, 'mis_plugin_activated' );