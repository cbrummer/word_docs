<?php 
/**
 * Template Name: Weight Loss Section Page
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Force Sidebar-Content-Sidebar Layout
add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );
add_action ('genesis_before_loop', 'adc_shop_slider');
function adc_shop_slider() {
	$nivo = genesis_get_custom_field('adc-nivo-slider');
		if (is_mobile()) {
			
		} elseif ($nivo) {
			nivo_slider($nivo);	
		} else {
	}
}
add_action ('genesis_before_loop', 'adc_shop_widget_area_menu');
function adc_shop_widget_area_menu() {
	adc_do_store_widget_area();	
}
add_action( 'genesis_after_loop', 'adc_do_store_disclaimer' );

genesis();