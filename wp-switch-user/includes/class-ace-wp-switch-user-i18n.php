<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/acewebx/#content-plugins
 * @since      1.0.0
 *
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ace_Wp_Switch_User
 * @subpackage Ace_Wp_Switch_User/includes
 * @author     AceWebX Team <developer@acewebx.com>
 */
class Ace_Wp_Switch_User_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ace-wp-switch-user',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
