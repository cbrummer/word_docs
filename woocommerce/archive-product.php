<?php
/**
 * Template Name: Product archive
 *
 * Description:
 * 
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 * @package genesis_connect_woocommerce
 * @version 0.9.5
 * @since 0.9.0
 *
 */
// Force full-width-content on Single Product pages
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
/** Remove default Genesis loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/** Uncomment the below line of code to add back WooCommerce breadcrumbs */
//add_action( 'genesis_before_loop', 'woocommerce_breadcrumb', 10, 0 );

/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


/** Get Shop Page ID */
// @TODO Retained for backwards compatibility with < 1.6.0 WooC installs
global $shop_page_id;
$shop_page_id = get_option( 'woocommerce_shop_page_id' );


add_filter( 'genesis_pre_get_option_site_layout', 'genesiswooc_archive_layout' );
/**
 * Manage page layout for the Product archive (Shop) page
 *
 * Set the layout in the Genesis layouts metabox in the Page Editor
 *
 * @since 0.9.0
 *
 * @param str $layout Genesis layout, eg 'content-sidebar', etc
 * @global string|int $shop_page_id The ID of the Shop WP Page
 * @return str $layout Shop Page layout from postmeta
 */
function genesiswooc_archive_layout( $layout ) {

	global $shop_page_id;

	$layout = get_post_meta( $shop_page_id, '_genesis_layout', true );

	return $layout;
}
add_action ('genesis_before_loop', 'adc_shop_slider');
function adc_shop_slider() {
	//$nivo = genesis_get_custom_field('adc-nivo-slider');
	$nivo = get_post_meta(10073, 'adc-nivo-slider', true);
	if (is_mobile()) {
		
	} else {
		nivo_slider($nivo);	
	}
}
add_action ('genesis_before_loop', 'adc_shop_widget_area_menu');
function adc_shop_widget_area_menu() {
	adc_do_store_widget_area();	
}
add_action( 'genesis_before_loop', 'genesiswooc_archive_product_loop' );
/**
 * Display shop items (product custom post archive)
 *
 * This function has been refactored in 0.9.4 to provide compatibility with
 * both WooC 1.6.0 and backwards compatibility with older versions.
 * This is needed thanks to substantial changes to WooC template contents
 * introduced in WooC 1.6.0.
 *
 * @uses genesiswooc_content_product() if WooC is version 1.6.0+
 * @uses genesiswooc_product_archive() for earlier WooC versions
 *
 * @since 0.9.0
 * @updated 0.9.4
 * @global object $woocommerce
 */
function genesiswooc_archive_product_loop() {

	global $woocommerce;
	
	$new = version_compare( $woocommerce->version, '1.6.0', '>=' );
	
	if ( $new )
		genesiswooc_content_product();
		
	else
		genesiswooc_product_archive();
}

genesis();