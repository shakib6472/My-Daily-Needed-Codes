<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/acewebx/#content-plugins
 * @since      1.0.0
 *
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/public
 * @author     AceWebX Team <developer@acewebx.com>
 */
class Ace_Wp_Switch_User_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ace-wp-switch-user-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ace-wp-switch-user-public.js', array('jquery'), $this->version, false);
	}

	public function aceSwitchWidget()
	{
		if (is_user_logged_in() && isset($_SESSION['og_user'])) {
			$ogUserId = $_SESSION['og_user'];
			$ogUserObj = get_userdata($ogUserId);

			$bare_url = wp_login_url() . '?action=back_to_og_user&user_id=' . $ogUserId;
			$nonceUrl = wp_nonce_url($bare_url, 'back_to_og_' . $ogUserId);
			echo '<p class="aceSwapLink"><a href="' . $nonceUrl . '">Switch back to ' . $ogUserObj->display_name . '</a></p>';
		}
	}
}
