<?php
/**
 * Template Name: Single Quality Report
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
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content_sidebar' );
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_single_quality_report_loop' );

function custom_do_single_quality_report_loop() {
	global $paged;
	$args = array(
		'post_type' =>'qualityreports',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-medical-service">';
			echo '<h1 class="entry-title">'. get_the_title() . '</h1>';
			the_content();
			echo '</div><!-- end .page .hentry .entry .adc-provider-->';			
		endwhile;
	endif;
	wp_reset_query();

}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

