<?php
/**
 * Template Name: Single Specialty
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
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_single_specialty_loop' );

function custom_do_single_specialty_loop() {
	global $paged;
	$args = array(
		'post_type' =>'specialty',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-medical-service">';
			echo '<h1 class="entry-title">'. get_the_title() . '</h1>';
			//Left column
			echo '<div class="two-thirds first">';
			//Check to see if specialty is pediatrics and display appropriate phone number
			if( has_term( 'pediatrics', 'medical-service' ) ) { //check to see if this is the pediatrics page
				echo '<div class="adc-service-appt btn">';
				echo '<h3>Appointments Available</h3>';
				echo '</div><!--end .adc-service-appt-->';
			} else {
				echo '<div class="adc-service-appt btn">';
				echo '<h3>Appointments</h3>';
				adc_display_appointment_phone();
				echo '</div><!--end .adc-service-appt-->';
			  wp_reset_query();
            } //end check to see if pediatrics */
			the_content();
			// Check if there is a video URL and display embedded player
			adc_display_video_3();
			echo '</div><!--end .two-thirds first-->';
			//Right column
			echo '<div class="one-third adc-col">';
			// Place location info here
			echo '<h3>Location & Hours</h3>';
           	output_location_info();
			echo '</div><!-- end .one-third-->';
			//Education links
			echo '<div class="adc-grid-content adc-section">';
			adc_patient_links();
			echo '</div><!-- end .adc-grid-content -->';
			//Show doctors and providers associated with this service in a grid
			echo '<div id="adc-grid-content" class="adc-grid-content adc-section">';
				output_doctor_list_1();
			echo '</div><!-- end #adc-grid-content .adc-grid-content -->';
			echo '</div><!-- end .page .hentry .entry .adc-provider-->';			
		endwhile;
	endif;
	wp_reset_query();

}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

