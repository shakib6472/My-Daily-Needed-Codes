<?php 

 /*
 * Plugin Name:       Rbonison Core
 * Plugin URI:        https://facebook.com/shakib6472/
 * Description:       Description
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       robinson
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


//requir Files
$plugin_url = plugin_dir_path(__FILE__);
require_once(__DIR__ . '/user-meta.php');

function swagbulk_enqueue_scripts()
{
	//css
	wp_enqueue_style('swagbulk-style', plugin_dir_url(__FILE__) . '/assets/css/style.css');
	wp_enqueue_style('swagbulk-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
	wp_enqueue_style('spectrum-colorpicker', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css', array(), '1.8.0');
	//js
	wp_enqueue_script('jquery');
	wp_enqueue_script('spectrum-colorpicker', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js', array('jquery'), '1.8.0', true);
	wp_enqueue_script('swagbulk-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'swagbulk_enqueue_scripts');



// Enqueue Bootstrap CSS in the admin area
function enqueue_bootstrap_admin_swagbulk() {
    wp_enqueue_style('swagbulk-bootstrap-admin-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');

}
add_action('admin_enqueue_scripts', 'enqueue_bootstrap_admin_swagbulk');


//Elementor Widgets

//Elementor Setup
function elementor_ctds_widgets($widgets_manager)
{

	require_once(__DIR__ . '/due-titel.php');

	$widgets_manager->register(new \Elementor_swagbulk_product_loop());
}
add_action('elementor/widgets/register', 'elementor_ctds_widgets');














// Activation Hook
register_activation_hook(__FILE__, 'your_plugin_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'your_plugin_deactivation_function');

// Activation function
function your_plugin_activation_function() {
    // Your activation code here
    // For example, create database tables or set default options
}

// Deactivation function
function your_plugin_deactivation_function() {
    // Your deactivation code here
    // For example, delete database tables or clean up options
}


