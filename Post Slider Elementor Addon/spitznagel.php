<?php /*
 * Plugin Name:       Spitznagel - Core
 * Plugin URI:        https://facebook.com/shakib6472/
 * Description:       This is the spitznagel websites Custom Plugin. All features are came from here.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       spitznagel
 * Domain Path:       /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}





$plugin_url = plugin_dir_path(__FILE__);



function enqueue_spitznagel_jquery_in_plugin()
{
    wp_enqueue_script('jquery');
    // Register Bootstrap CSS
    wp_enqueue_style('bootstrap-renu-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');
}
add_action('wp_enqueue_scripts', 'enqueue_spitznagel_jquery_in_plugin');


// Add a custom widget to the widgets_init action hook.
function elementor_spitznagel_core_adding($widgets_manager)
{

    require_once(__DIR__ . '/widgets/post-slider/post-slider.php');
    require_once(__DIR__ . '/widgets/news-arcive/news-arcive.php');


    $widgets_manager->register(new \Elementor_spitznagel_post_slider());
    $widgets_manager->register(new \Elementor_spitznagel_news_arcive());
}
add_action('elementor/widgets/register', 'elementor_spitznagel_core_adding');


















// Activation Hook
register_activation_hook(__FILE__, 'spitznagel_core_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'spitznagel_core_deactivation_function');

// Activation function
function spitznagel_core_activation_function() {
    // Your activation code here
    // For example, create database tables or set default options
}

// Deactivation function
function spitznagel_core_deactivation_function() {
    // Your deactivation code here
    // For example, delete database tables or clean up options
}