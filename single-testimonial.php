<?php
/**
 * Template Name: Single testimonial
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
add_action( 'genesis_loop', 'custom_do_single_testimonial_loop' );

function custom_do_single_testimonial_loop() {
	global $paged;
	$args = array(
		'post_type' =>'testimonial',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-testimonial">';
			echo '<h1 class="entry-title">'. get_the_title() . '</h1>';
			if (in_category( 'staff-testimonials' )){
				echo '<h2>';
				adc_staff_info();
				echo '</h2>';
				echo '<h3>';
				adc_start_date();
				echo '</h3>';
				the_content();
				adc_display_video_4();
			} elseif (in_category( 'patient-testimonials' )){
				the_content();
				adc_display_video_4();	
			} else {
				the_content();	
			}
			
			echo '</div><!-- end .page .hentry .entry .adc-testimonial-->';			
		endwhile;
	endif;
	wp_reset_query();

}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

