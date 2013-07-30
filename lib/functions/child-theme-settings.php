<?php
/**
 * ADC Twenty Thirteen Settings
 *
 * This file registers all of this child theme's specific Theme Settings, accessible from
 * Genesis > Child Theme Settings.
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @link         https://github.com/billerickson/BE-Genesis-Child
 */ 
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @since 1.0.0
 *
 * @package BE_Genesis_Child
 * @subpackage Child_Theme_Settings
 */
class Child_Theme_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 * @since 1.0.0
	 */
	function __construct() {

		// Specify a unique page ID. 
		$page_id = 'child';

		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => 'Genesis - ADC Twenty Thirteen Settings',
				'menu_title'  => 'ADC Twenty Thirteen Settings',
			)
		);

		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		

		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'child-settings' );
		$settings_field = 'child-settings';

		// Set the default values
		$default_settings = array(
			'footer-right'  => 'Disclaimer: The information contained in these pages is not intended as a substitute for medical advice from your doctor. Always seek the advice of your physician.',
		);

		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	/** 
	 * Set up Sanitization Filters
	 * @since 1.0.0
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 */	
	function sanitization_filters() {

		genesis_add_option_filter( 'safe_html', $this->settings_field,
			array(
				'footer-right',
			) );
	}

	/**
	 * Set up Help Tab
	 * @since 1.0.0
	 *
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 */
	 function help() {
	 	$screen = get_current_screen();

		$screen->add_help_tab( array(
			'id'      => 'need-help', 
			'title'   => 'Need Help?',
			'content' => '<p>If you have questions about how to fill out or use any part of this website, call Cindy Brummer, Content Manager & Web Designer, at (w) 512-901-4453, (m) 512-653-7651 or email at <a href="mailto:cbrummer@adclinic.com">cbrummer@adclinic.com</a>.</p>',
		) );
	 }

	/**
	 * Register metaboxes on Child Theme Settings page
	 * @since 1.0.0
	 */
	function metaboxes() {

		add_meta_box('footer_metabox', 'Footer', array( $this, 'footer_metabox' ), $this->pagehook, 'main', 'high');

	}

	/**
	 * Footer Metabox
	 * @since 1.0.0
	 */
	function footer_metabox() {

	echo '<p><strong>Footer Right:</strong></p>';
	wp_editor( $this->get_field_value( 'footer-right' ), $this->get_field_id( 'footer-right' ), array( 'textarea_rows' => 5 ) ); 
	}


}

/**
 * Add the Theme Settings Page
 * @since 1.0.0
 */
function adc_add_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new Child_Theme_Settings;	 	
}
add_action( 'genesis_admin_menu', 'adc_add_child_theme_settings' );