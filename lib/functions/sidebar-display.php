<?php
/*
/**
 * Sidebar display for ADC Twenty Thirteen
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
 * Sidebar display
 * @since 1.0.0
 *
 * This file displays sidebars according to page and post type for ADC Twenty Thirteen
 *
 */
/************************************************************
 /* Load alert widget on all pages if sidebar active
*************************************************************/
add_action( 'genesis_before_content_sidebar_wrap', 'adc_announce' );
 function adc_announce() {
 if ( is_active_sidebar('alert-widget-area') ) {
		echo '<div id="adc-alert"><div class="adc-announce adc-alert">';
		dynamic_sidebar( 'alert-widget-area' );
		echo '</div><!-- end .adc-alert --></div><!-- end #adc-alert -->';
 	}
 }
/************************************************************
 /* Load home headline widget on home page if sidebar active
*************************************************************/
add_action( 'genesis_before_content', 'adc_home_headline' );
 function adc_home_headline() {
 if ( is_home() && is_active_sidebar('adc-home-headline') ) {
		echo '<div id="home-top-headline">';
		dynamic_sidebar( 'adc-home-headline' );
		echo '</div><!-- end #home-top-headline -->';
 	}
 }
/************************************************************
 /* Load appointment button above sidebar
*************************************************************/
add_action( 'genesis_before_sidebar_widget_area', 'adc_add_appt_button_sidebar', 7 );
 function adc_add_appt_button_sidebar() {
 if ( is_active_sidebar('appointment-widget-area') ) {
		dynamic_sidebar( 'appointment-widget-area' );
 	}
 } 
/************************************************************
 /* Replace and add sidebars on left and/or right of content conditionally according to section
*************************************************************/
add_action('get_header','adc_change_genesis_sidebar');
	function adc_change_genesis_sidebar() {
	//About Sidebars - Main/nav extras
		if ( is_page('about') || is_tree( 31 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_about_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_about_nav_extras' );
	// Billing Sidebars - Main / nav extras
		} elseif ( is_page('your-bill') || is_tree( 29 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_billing_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_billing_nav_extras' );
	// Careers Sidebars - Main / nav extras
		} elseif ( is_page('careers') || is_tree( 33 ) || 'testimonial' == get_post_type() || is_post_type_archive( 'testimonial' ) || is_singular( 'testimonial' ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_careers_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_careers_nav_extras' );
	// Community Sidebars - Main / nav extras
		} elseif ( is_page('outreach') || is_tree( 25 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_community_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_community_nav_extras' );
	// Contact Sidebar - Main
		} elseif ( is_page('contact') || is_tree( 27 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_contact_sidebar' );
	// Employee Sidebar - Main / nav extras
		} elseif ( is_page('for-adc-employees') || is_tree( 2518 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_employees_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_employees_nav_extras' );
	// Events Sidebar - Main / nav extras
		} elseif ('events' == get_post_type() || is_post_type_archive( 'events' ) || is_singular( 'events' )){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_events_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_events_nav_extras' );
	// Doctors Sidebar - Main / nav extas
		} elseif ( is_page('doctors') || is_tree( 17 ) || 'biography' == get_post_type() || is_post_type_archive( 'biography' ) || is_singular( 'biography' )){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_biography_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_biography_nav_extras' );
	// Locations Sidebar - Main / nav extras
		} elseif ( is_singular( 'location' ) || is_page( 'locations' ) || is_tree( 21 ) || 'location' == get_post_type() || is_post_type_archive( 'location' ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_locations_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_locations_nav_extras' );
	// Patient Tools Sidebar - Main / nav extras
		} elseif ( is_page('patient-tools') || is_tree( 23 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_patient_tools_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_patient_tools_nav_extras', 2 );
	// Quality Assurance Sidebar - nav extras
		} elseif ( is_page('quality_reports') || is_tree( 2771 ) || 'qualityreports' == get_post_type() || is_post_type_archive( 'qualityreports' ) || is_singular( 'qualityreports' ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_quality_reports_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_quality_reports_nav_extras', 1 );
	// Services Sidebar - Main / nav extras
		} elseif ( array('service', 'specialty' ) == get_post_type() || is_post_type_archive( array('service', 'specialty' )) || is_singular( array('service', 'specialty' ) ) || is_page('medical-services') || is_tree( 19 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_medical_services_sidebar' );
			add_action( 'genesis_before_sidebar_alt_widget_area', 'adc_do_medical_services_nav_extras', 2 );
		} elseif ( is_page('flu') || is_tree( 7334 ) ){
			remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
			add_action( 'genesis_sidebar', 'adc_do_flu_sidebar' );
		}
	}

//Functions to output custom sidebars
//About main sidebar - replaces primary
function adc_do_about_sidebar() {
	dynamic_sidebar( 'about-sidebar' );
}
//About nav extras (these go above the secondary sidebar)
function adc_do_about_nav_extras() {
	dynamic_sidebar( 'about-extras-sidebar' );
}
//Billing main sidebar - replaces primary
function adc_do_billing_sidebar() {
	dynamic_sidebar( 'billing-sidebar' );
}
//Billing nav extras (these go above the secondary sidebar)
function adc_do_billing_nav_extras() {
	dynamic_sidebar( 'billing-extras-sidebar' );
}
//Careers main sidebar - replaces primary
function adc_do_careers_sidebar() {
	dynamic_sidebar( 'careers-sidebar' );
}
//Careers sidebar extras (these go above the secondary sidebar)
function adc_do_careers_nav_extras() {
	dynamic_sidebar( 'careers-extras-sidebar' );
}
//Community main sidebar - replaces primary
function adc_do_community_sidebar() {
	dynamic_sidebar( 'community-sidebar' );
}
//Community sidebar extras (these go above the secondary sidebar)
function adc_do_community_nav_extras() {
	dynamic_sidebar( 'community-extras-sidebar' );
}
//Contact main sidebar - replaces primary
function adc_do_contact_sidebar() {
	dynamic_sidebar( 'contact-sidebar' );
}
// Employees main sidebar
function adc_do_employees_sidebar() {
	dynamic_sidebar( 'employee-sidebar' );
}
// Employees sidebar extras (these go above the secondary sidebar)
function adc_do_employees_nav_extras() {
	dynamic_sidebar( 'employee-extras-sidebar' );
}
// Events main sidebar
function adc_do_events_sidebar() {
	dynamic_sidebar( 'event-sidebar' );
}
// Events sidebar extras (these go above the secondary sidebar)
function adc_do_events_nav_extras() {
	dynamic_sidebar( 'event-extras-sidebar' );
}
// Doctors main sidebar
function adc_do_biography_sidebar() {
	dynamic_sidebar( 'doctors-sidebar' );
}
// Doctors sidebar extras (these go above the secondary sidebar)
function adc_do_biography_nav_extras() {
	dynamic_sidebar( 'doctors-extras-sidebar' );
}
// Locations main sidebar
function adc_do_locations_sidebar() {
	dynamic_sidebar( 'locations-sidebar' );
}
// Locations sidebar extras (these go above the secondary sidebar)
function adc_do_locations_nav_extras() {
	dynamic_sidebar( 'locations-extras-sidebar' );
}
// Patient Tools main sidebar
function adc_do_patient_tools_sidebar() {
	dynamic_sidebar( 'patient-tools-sidebar' );
}
// Patient Tools sidebar extras (these go above the secondary sidebar)
function adc_do_patient_tools_nav_extras() {
	dynamic_sidebar( 'patient-tools-extras-sidebar' );
}
// Quality Assurance main sidebar
function adc_do_quality_reports_sidebar() {
	dynamic_sidebar( 'quality-assurance-sidebar' );
}
// Quality Assurance sidebar extras (these go above the secondary sidebar)
function adc_do_quality_reports_nav_extras() {
	dynamic_sidebar( 'quality-assurance-extras-sidebar' );
}
// Medical Services main sidebar
function adc_do_medical_services_sidebar() {
	dynamic_sidebar( 'services-sidebar' );
}
// Medical Services sidebar extras (these go above the secondary sidebar)
function adc_do_medical_services_nav_extras() {
	dynamic_sidebar( 'services-extras-sidebar' );
}
// Flu sidebar main sidebar
function adc_do_flu_sidebar() {
	dynamic_sidebar( 'flu-sidebar' );
}