<?php /*
 * Plugin Name:       Tiny Schoolars
 * Description:       This is the boikotha websites Custom Plugin. All features are came from here.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tinyschoolars
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
 
$plugin_url = plugin_dir_path(__FILE__);  
// require_once(__DIR__ . '/shortcode/dashboard.php');
require_once(__DIR__ . '/dashboard/left-menu.php');
require_once(__DIR__ . '/dashboard/footer.php');
require_once(__DIR__ . '/functions/ajax.php');
require_once(__DIR__ . '/admin/admin-menu.php');
//require_once(__DIR__ . '/admin.php');


// Enqueue styles and scripts
function tinyscholars_enqueue_scripts() {
    // Enqueue style
    wp_enqueue_style('tiny-scholars-style', plugins_url('asset/style.css', __FILE__), array(), '1.0', 'all');
    
    // Enqueue script
    wp_enqueue_script('tiny-scholars-script', plugins_url('asset/script.js', __FILE__), array('jquery', 'media-editor'), '1.0', true);
      // Enqueue the media uploader script
      wp_enqueue_media();
    
    // Send Ajax data URL to tiny-scholars-script
    wp_localize_script('tiny-scholars-script', 'tinyscholarsAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'tinyscholars_enqueue_scripts');


function elementor_ctds_widgets($widgets_manager)
{
    //require_once(__DIR__ . '/dashboard/dashboard.php');
    require_once(__DIR__ . '/dashboard/main-dashboard.php');
    //$widgets_manager->register(new \Elementor_tiny_tutor_dashboard_elementor());
    $widgets_manager->register(new \Elementor_tiny_tutor_main_dashboard_elementor());
}
add_action('elementor/widgets/register', 'elementor_ctds_widgets');





// Activation Hook
register_activation_hook(__FILE__, 'tiny_schoolars_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'tiny_schoolars_deactivation_function');

// Activation function
function tiny_schoolars_activation_function() {
    // Your activation code here
    tiny_child_database_creation_while_activation ();
}

// Deactivation function
function tiny_schoolars_deactivation_function() {
    // Your deactivation code here
    // For example, delete database tables or clean up options
}

