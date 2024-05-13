<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/acewebx/#content-plugins
 * @since      1.0.0
 *
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/admin
 * @author     AceWebX Team <developer@acewebx.com>
 */
class Ace_Wp_Switch_User_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function aceEnqueueStyles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ace_Wp_Switch_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ace_Wp_Switch_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ace-wp-switch-user-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function aceEnqueueScripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ace_Wp_Switch_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ace_Wp_Switch_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ace-wp-switch-user-admin.js', array('jquery'), $this->version, false);
	}

	public function aceAdminMenu(WP_Admin_Bar $admin_bar)
	{
		if (isset($_SESSION['og_user'])) {

			$userObj = wp_get_current_user();
			$userID = $_SESSION['og_user'];

			if ($_SESSION['og_user'] != $userObj->ID) {

				$bareUrl = wp_login_url() . '?action=back_to_og_user&user_id=' . $userID;
				$nonceUrl    = wp_nonce_url($bareUrl, 'back_to_og_' . $userID);
				$linkLabel = 'Switch Back';

				$admin_bar->add_menu(array(
					'id'    => 'switch-back',
					'parent' => 'top-secondary',
					'group'  => NULL,
					'title' => $linkLabel,
					'href'  => $nonceUrl,
					'meta' => [
						'title' => __($linkLabel, 'ace-wp-switch-user'),
					]
				));
			}
		}
	}

	public function aceUserSwitchLink($userActions, $userObj)
	{

		$userID = $userObj->ID;
		$user = wp_get_current_user();

		if (isset($_SESSION['og_user'])) {

			if ($_SESSION['og_user'] == $userID) {

				if (!empty($user) && ($user->ID !== $userID)) {
					$bareUrl = wp_login_url() . '?action=back_to_og_user&user_id=' . $userID;
					$nonceUrl    = wp_nonce_url($bareUrl, 'back_to_og_' . $userID);
					$userActions['swap'] = '<a href="' . $nonceUrl . '">Switch Back</a>';
				}
			}
		} else {

			if (!empty($user) && ($user->ID != $userID)) {
				$bareUrl = wp_login_url() . '?action=change_loggedin_user&user_id=' . $userID;
				$nonceUrl = wp_nonce_url($bareUrl, 'change_loggedin_' . $userID);
				$userActions['swap'] = '<a href="' . $nonceUrl . '">Switch To</a>';
			}
		}
		return $userActions;
	}

	public function aceSwitchAction()
	{
		if (isset($_REQUEST['action']) && isset($_REQUEST['user_id'])) {

			if ($_REQUEST['user_id'] != '') $userId =  $_REQUEST['user_id'];

			$userExists = get_userdata($userId);
			if ($userExists === false) wp_die(esc_html__('Could not switch users.', 'ace-wp-switch-user'));

			if ($_REQUEST['action']  == 'change_loggedin_user') {

				// if (!current_user_can('administrator', $userId)) {
				// 	wp_die(esc_html__('Could not switch users.', 'ace-wp-switch-user'));
				// }

				//check_admin_referer("change_loggedin_$userId");
  
				$currentUser          = wp_get_current_user();
				$_SESSION['og_user']  = $currentUser->ID;

				wp_clear_auth_cookie();
				wp_set_current_user($userId);
				wp_set_auth_cookie($userId);

				
					wp_redirect(home_url());
					exit();
				
			} elseif ($_REQUEST['action']  == 'back_to_og_user') {

				check_admin_referer("back_to_og_$userId");

				unset($_SESSION['og_user']);

				wp_clear_auth_cookie();
				wp_set_current_user($userId);
				wp_set_auth_cookie($userId);
					wp_redirect(home_url());
				
			}
		}
	}
}
