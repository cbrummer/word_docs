<?php
/*
/**
 * Custom Navigation for ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Menus
 * @since 1.0.0
 *
 * This file places the navigation needed for ADC Twenty Thirteen
 *
 */
	
// Add mobile navigation
	add_action('genesis_before_header', 'adc_add_mobile_nav', 12);
		function adc_add_mobile_nav() {
			echo '<div id="adc-mobile-nav"><div>';  
			wp_nav_menu( 
				array( 
				'sort_column' => 'menu_order', 
				'menu_class' => 'menu genesis-nav-menu menu-mobile superfish sf-js-enabled', 
				'theme_location' => 'mobile') 
				); 
			echo '</div></div>';
		}
// Add submenu navigation depending on section
	add_action('genesis_before_sidebar_widget_area', 'adc_add_sub_nav', 8);
		function adc_add_sub_nav() {
			echo '<div class="adc-submenu-area">'; 
			//About SubMenu
			if ( is_page('about') || is_tree( 31 ) ){
				echo '<h4>About ADC</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-1') 
				); 
			// Careers Submenu	
			} elseif ( is_page('careers') || is_tree( '33' ) || 'testimonial' == get_post_type() || is_post_type_archive( 'testimonial' ) || is_singular( 'testimonial' ) ){
				echo '<h4>Careers at ADC</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-2') 
				); 	
			// Contact Submenu
			} elseif ( is_page('contact') || is_tree( 27 ) ){
				echo '<h4>Contact Us</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-3') 
				);
			// Community / Outreach Submenu
			} elseif ( is_page('outreach') || is_tree( 25 ) ){
				echo '<h4>Our Community</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-4') 
				); 
			//Doctors Submenu
			} elseif ( is_page('doctors') || is_tree( 17 ) || 'biography' == get_post_type() || is_post_type_archive( 'biography' ) || is_singular( 'biography' ) ){
				echo '<h4>Our Doctors</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-5') 
				); 	
			//Locations Submenu
			} elseif ( is_page('locations') || is_tree( 21 ) || 'location' == get_post_type() || is_post_type_archive( 'location' ) || is_singular( 'location' ) ){
				echo '<h4>Our Locations</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-6') 
				); 
			// Tools Submenu
			} elseif ( is_page('patient-tools') || is_tree( 23 ) || is_page( 'qualityreports' ) || '2771' == $post->post_parent || 'qualityreports' == get_post_type() || is_post_type_archive( 'qualityreports' ) || is_singular( 'qualityreports' ) ){
				echo '<h4>Patient Tools</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-8') 
				); 
			//Billing Submenu
			} elseif ( is_page('your-bill') || is_tree( 29 )  ){
				echo'<h4>Billing</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-9') 
				);
			//Staff Submenu
			} elseif ( is_page('for-adc-employees') || is_tree( 2518 ) ){
				echo '<h4>Staff Links</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-10') 
				);
			// Specialties Submenu
			} elseif ( is_page('medical-services') || is_tree( 19 ) || 'specialty' == get_post_type() || is_post_type_archive( 'specialty' ) || is_singular( 'biography' )){
				echo '<h4>Our Specialties</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-7') 
				);
				echo '<h4>Our Services</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-11') 
				);	
			// Services Submenu
			} elseif ('service' == get_post_type() || is_post_type_archive( 'service' ) || is_singular( 'service' )){
				echo '<h4>Our Services</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-11') 
				);	
				echo '<h4>Our Specialties</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-7') 
				);
			} elseif ( is_page('patient-education') || is_tree( 9447 ) || is_category( array ('39', '44', '50') ) || in_category( array( '39', '44', '50' ) )  ){
				echo '<h4>Patient Education</h4>';
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-13') 
				);	
			} else {
			// Show default submenu
				wp_nav_menu( 
					array( 
					'sort_column' => 'menu_order', 
					'menu_class' => 'menu genesis-nav-menu adc-sub-menu superfish sf-js-enabled', 
					'theme_location' => 'submenu-12') 
				);
				
			}
			echo '</div>';
		}