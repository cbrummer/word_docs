<?php
/**
 * Template Name: Single Location
 *
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
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );

	
/** Remove Post Info */
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action('genesis_after_post_content','genesis_post_meta');

 
genesis();

