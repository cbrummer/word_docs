<?php
/**
 * Template Name: Single Service
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
add_action( 'genesis_loop', 'custom_do_single_service_loop' );

function custom_do_single_service_loop() {
	global $paged;
	$args = array(
		'post_type' =>'service',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-medical-service">';
			echo '<h1 class="entry-title">'. get_the_title() . '</h1>';
			//Left column
			echo '<div class="one-half first">';
				echo '<div class="adc-service-appt btn">';
				echo '<h3>Appointments</h3>';
				adc_display_appointment_phone();
				echo '</div><!--end .adc-service-appt-->';
				the_content();
			// Check if there is a video URL and display embedded player
				adc_display_video_3();
			echo '</div><!--end .one-half first-->';
			
			//Right column
			echo '<div class="one-half">';
			// Place location info here
			echo '<h3>Location & Hours</h3>';
            output_location_info();
			//if this is the HRM page, show the next HRM event-->
            if (is_single('2079')) {
				echo '<div class="adc-event">';
                echo '<h4>Register for Our Next Event</h4>';
				adc_next_HRM_event();
				echo '</div>';
			} else {
				
			}
			//Education links
				output_patient_visit_links();
				output_related_education_links();
				output_related_blog_links();
				output_quality_reports_links();
			//Doctors associated with this specialty
			output_doctor_list_1();
			echo '</div><!-- end .one-half-->';
			echo '</div><!-- end .page .hentry .entry .adc-provider-->';			
		endwhile;
	endif;
	wp_reset_query();

}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

