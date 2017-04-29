<?php
    /*
        Plugin Name: Enhanced Title Plugin
        Plugin URI:  http://therightsol.com/
        Description: This is sixth plugin in WP Plugin Development Class. This plugin update title (add extra text with every title) and provides administration screen.
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


    // Getting option and setting constant
    $plugin_options = get_option( 'trs_enhanced_arr' );
    if (isset($plugin_options['title']) && !empty($plugin_options['title'])){
        $title = $plugin_options['title'];
    }else {
        $title = '';
    }

    if (!defined('EXTRA_TITLE'))
        define('EXTRA_TITLE', $title);



    function trs_update_title( $title ) {

        return $title . EXTRA_TITLE;
    }
   add_filter('the_title', 'trs_update_title');



    // First, tell WordPress that you're going to use new options
    add_action('admin_init', 'trs_page_option_settings' );
    function trs_page_option_settings(){
        register_setting( 'enhanced_title_options', 'trs_enhanced_arr' );
    }



    /**
     * Register menu page.
     */
    function trs_enhanced_title_plugin_page(){
        add_menu_page(
            __( 'Enhanced Title Plugin', 'therightsol' ),
            'Enhanced Title',
            'manage_options',
            'enhanced-title-plugin',
            'get_html_for_enhanced_title_administration_page',
            plugins_url( 'assets/backend/images/24xplugin.png', __FILE__ ),
            6
        );
    }
    add_action( 'admin_menu', 'trs_enhanced_title_plugin_page' );

    /**
     * Display a custom menu page
     */
    function get_html_for_enhanced_title_administration_page(){
        ?>
        <style>
            .plugin-info{
                padding: 10px;
                border: 1px dashed;
                width: 50%;
                text-align: left;
                margin: 0 auto;
            }
        </style>
        <div class="wrap">
            <h2>Enhanced Title Plugin</h2>

            <div class="plugin-info">
                This plugin will display text after any post / page title. <br />
                Please enter title below.
            </div>

            <form method="post" action="options.php">
                <?php settings_fields('enhanced_title_options'); // enter nonce, options and action hidden inputs ?>


                <ul>
                    <li>
                        <label for="trs_extra_title">Please enter title*</label>
                        <input type="text" id="trs_extra_title" name="trs_enhanced_arr[title]"
                               required value="<?php echo EXTRA_TITLE; ?>">
                        <span class="description">Enter title that you want to display after page / post title.</span>
                    </li>
                    <li>
                        <input class='button-primary' type='submit' name='Save' value='<?php  _e('Save', 'therightsol'); ?>'
                    </li>
                </ul>

            </form>

        </div>
        <?php
    }


    // Display notices on successfully saved
    add_action('admin_notices', 'trs_plugin_options_saved');
    function trs_plugin_options_saved(){
        if (isset($_GET['page']) && ($_GET['page'] == 'enhanced-title-plugin') && isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'){
            ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Settings saved.</strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
<?php
        }
    }
