<?php /*
 * Plugin Name:       Certificate
 * Plugin URI:        https://facebook.com/shakib6472/
 * Description:       This is the certificate websites Custom Plugin. All features are came from here.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shakib Shown
 * Author URI:        https://facebook.com/shakib6472/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       certificate
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
//requir Files

$plugin_url = plugin_dir_path(__FILE__);
require_once($plugin_url . '/admin.php');
function certificate_enqueue_scripts()
{

	wp_enqueue_style('certificate-style', plugin_dir_url(__FILE__) . '/style.css');
	wp_enqueue_style('certificate-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script('certificate-script', plugin_dir_url(__FILE__) . '/script.js', array('jquery'), null, true);

	// Localize the script with new data
	wp_localize_script('certificate-script', 'ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		// Add other variables you want to pass to your script here
	));
}

add_action('wp_enqueue_scripts', 'certificate_enqueue_scripts');



// Enqueue Spectrum Colorpicker script and styles
function certificate_admin_enqueue_scripts()
{
	wp_enqueue_style('certificate-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
	wp_enqueue_script('jquery');


	wp_enqueue_style('certificate-admin-style', plugin_dir_url(__FILE__) . '/style.css');
	wp_enqueue_script('certificate-admin-script', plugin_dir_url(__FILE__) . '/script.js');
	wp_localize_script('certificate-admin-script', 'ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'certi_all' => admin_url('/admin.php?page=all-certificates'),
		// Add other variables you want to pass to your script here
	));
}
add_action('admin_enqueue_scripts', 'certificate_admin_enqueue_scripts');


//Elementor Setup
function elementor_ctds_widgets($widgets_manager)
{

	require_once(__DIR__ . '/validation.php');

	$widgets_manager->register(new \Elementor_certificate_product_loop());
}
add_action('elementor/widgets/register', 'elementor_ctds_widgets');







// Activation function
function certificate_activation_function()
{
	// Your activation code here
	// For example, create database tables or set default options
	global $wpdb;
	$table_name = $wpdb->prefix . 'certificate_details';
	$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        certi_id text NOT NULL,
        name text NOT NULL,
        dob text NOT NULL,
        course_name text NOT NULL,
        issue_date text NOT NULL,
        expire_date text NOT NULL,
        PRIMARY KEY  (id)
    );";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sql);
}

// Deactivation function
function certificate_deactivation_function()
{
	// Your deactivation code here
	// For example, delete database tables or clean up options
}



// Activation Hook
register_activation_hook(__FILE__, 'certificate_activation_function');

// Deactivation Hook
register_deactivation_hook(__FILE__, 'certificate_deactivation_function');




//ajax

function add_new_certificate()
{

	$id = $_POST['id'];
	$name = $_POST['name'];
	$dob = $_POST['dob'];
	$course_name = $_POST['course_name'];
	$issue = $_POST['issue'];
	$expire = $_POST['expire'];

	global $wpdb;

	// Define the table name
	$table_name = $wpdb->prefix . 'certificate_details';

	// Insert initial data into the table
	$result = $wpdb->insert(
		$table_name,
		array(
			'certi_id' => $id,
			'name' => $name,
			'dob' => $dob,
			'course_name' => $course_name,
			'issue_date' => $issue,
			'expire_date' => $expire,

		)
	);

	// Check for errors during insertion
	if ($result === false) {
		// If there was an error, send JSON error response
		wp_send_json_error('Error inserting data: ' . $wpdb->last_error);
	} else {
		// If insertion was successful, send JSON success response
		wp_send_json_success('Data successfully added');
	}
}
add_action('wp_ajax_add_new_certificate', 'add_new_certificate');
add_action('wp_ajax_nopriv_add_new_certificate', 'add_new_certificate');


function verify_the_ceritificate()
{

	$id = $_POST['id'];

	global $wpdb;
	// Define the table name
	$table_name = $wpdb->prefix . 'certificate_details';

	// Use a prepared statement to safely query the database
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE certi_id = %d", $id));

	// Check if the row exists and display the data
	if ($row) {
		$response = [];
		$response['name'] .= $row->name;
		$response['course'] .= $row->course_name;
		$response['dob'] .= $row->dob;
		$response['issue'] .= $row->issue_date;
		$response['expire'] .= $row->expire_date;
		$response['success'] .= true;

		wp_send_json($response);
	} else {
		wp_send_json_error('Certificate Not Found');
	}
}
add_action('wp_ajax_verify_the_ceritificate', 'verify_the_ceritificate');
add_action('wp_ajax_nopriv_verify_the_ceritificate', 'verify_the_ceritificate');


