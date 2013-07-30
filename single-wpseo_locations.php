<?php
/**
 * Template Name: Locations custom post type
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action('genesis_loop', 'adc_do_location_loop');
	function adc_do_location_loop() {
		global $paged;
		$args = array('post_type' => 'location');
		// Accepts WP_Query args 
		// (http://codex.wordpress.org/Class_Reference/WP_Query)
		genesis_custom_loop( $args );
 
	}