<?php
/*
    Plugin Name: create custom page
    Plugin URI:  http://ail.com.pk/
    Description: this is a test page, to create by admin for checking purpose
    Version:     1.1.2
    Author:      Obaidullah Qazi
    Author URI:  http://ail.com.pk/
    License:     open
    License URI: https://www.ail.com.pk/license
    Text Domain: ail
    Domain Path: /languages
*/

if(!defined ('ABSPATH'))
    exit ('not absoulte path');

$plugin_options = get_option('options_menu_page_custom_array');



$title = $plugin_options['profinity_words'];




$mask = $plugin_options['mask_key'];

if(!defined ('some_content'))
    define('some_content', $title);
if(!defined('mask'))
    define('mask',$mask);


add_filter('the_content','update_block_content');
function update_block_content($content){

$explode_array = explode(",",some_content);
    //var_export($explode_array);
    return str_replace($explode_array, mask, $content );
}




add_action('admin_init', 'tracking_time_page_settings' );
function tracking_time_page_settings(){
    register_setting( 'group_of_profinity_words', 'options_menu_page_custom_array' );
}



add_action('admin_menu','create_custom_page');
function create_custom_page(){
    add_menu_page('my_first_menu', 'Profanity Filter ', 'manage_options', 'Profanity-filter-slug','html',plugins_url(''),6);
}
function html(){
    ?>
    <div class="wrap">
    <h1>
        Profanity Words Filter
    </h1>

        <form class="form-horizontal"  method="post", action="options.php">
            <?php settings_fields('group_of_profinity_words');  ?>
            <fieldset>


                <div class="form-group">

                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Enter Profanity words</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="textArea" name="options_menu_page_custom_array[profinity_words]" value= ""><?php echo some_content ;  ?></textarea>
                            <span class="help-block" style="color:red; font-style: italic;">Multiple Profanity words must be separated by a comma (,)</span>
                        </div>
                    </div>



                    <label for="inputPassword" class="col-lg-2 control-label">Masking Key</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="inputPassword" placeholder="Password" name="options_menu_page_custom_array[mask_key]" value="<?php echo mask; ?>" >

                    </div>
                </div>



                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
<?php
}

add_action('admin_notices', 'ail_plugin_options_saved');
function ail_plugin_options_saved(){
    if (isset($_GET['page']) && ($_GET['page'] == 'Profanity-filter-slug') && isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'){
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