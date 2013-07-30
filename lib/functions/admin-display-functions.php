<?php
/**
 * Functions for ADC Twenty Thirteen Admin display
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 *
 */
 
/************************************************************
 /*ADMIN AREA CUSTOMIZATIONS
*************************************************************/ 
// This action changes the default Wordpress logo on the login screen to the ADC logo
function my_custom_login_logo()
{
	echo '<style type="text/css"> h1 a {  background-image:url('.get_bloginfo('stylesheet_directory').'/images/ADClogoburgundy.jpg)  !important; background-position: center center !important;
    background-repeat: no-repeat !important;
    background-size: 274px auto !important; width:325px !important; height:276px !important; } </style>';
}
add_action('login_head',  'my_custom_login_logo');

// This filter changes the link on the login screen from wordpress.org to the site's link
function change_wp_login_url()
{
	echo bloginfo('url');
}
add_filter('login_headerurl', 'change_wp_login_url');

// This filter changes the default login logo title and alt text to the site's name
function change_wp_login_title()
{
	echo get_option('blogname');
}
add_filter('login_headertitle', 'change_wp_login_title');

// This action adds a favicon to the admin area
	function admin_favicon() {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/admin-favicon.png" />';
	}
	add_action('admin_head', 'admin_favicon');

// This action changes the admin dashboard header logo
function custom_admin_logo() {
	echo '<style type="text/css">#wp-admin-bar-wp-logo > .ab-item .ab-icon { 
	background-image: url(' . get_bloginfo('stylesheet_directory') . '/images/adc-icon.png) !important; 
	background-position: 0 0;
	}
#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
	background-position: 0 0;
	}	
</style>
';
}
add_action('admin_head', 'custom_admin_logo');

// This action removes default widget boxes from the Wordpress dashboard for all users, including plugins
function example_remove_dashboard_widgets() {	// Globalize the metaboxes array, this holds all the widgets for wp-admin	
	global $wp_meta_boxes;	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);	
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
} 
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );

 //This action adds a custom dashboard widget to explain basic contact information for using the ADC dashboard
function adc_dashboard_help_widget_function() {
	// Entering the text between the quotes
	echo "<ul>
	<li>Cindy Brummer, Web Designer, Developer & Content Manager</li>
	<li><a href='mailto:cbrummer@adclinic.com?subject=Wordpress Dashboard Help!'>cbrummer@adclinic.com</a></li>
	<li>901-4453</li>
	</ul>";
}
function wpc_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Questions about how to use the ADClinic.com Dashboard?', 'adc_dashboard_help_widget_function');
}
add_action('wp_dashboard_setup', 'wpc_add_dashboard_widgets' );
/** 
 * Remove default Wordpress widgets
 *
 * @since 1.0.0
 */
function unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);
/** 
 * Remove Genesis widgets
 *
 * @since 1.0.0
 */
function adc_remove_genesis_widgets() {
    unregister_widget( 'Genesis_eNews_Updates'          );
    unregister_widget( 'Genesis_Latest_Tweets_Widget'   );
    unregister_widget( 'Genesis_User_Profile_Widget'    );
}

//This function customizes the information displayed in the dashboard/admin area footer
 function modify_footer_admin () {
  echo 'Created by Cindy Brummer, ADC Web Designer. Powered by <a href="http://www.wordpress.org">WordPress</a>';
} 
 add_filter('admin_footer_text', 'modify_footer_admin');
?>