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
			echo '<div class="two-thirds first">';
				 if (!is_single('2087')) { //Make sure this is not the X-ray page
				 	//if not X-ray, display appointment button
					 echo '<div class="adc-service-appt btn">';
					 echo '<h3>Appointments</h3>';
					 adc_display_appointment_phone();
					 echo '</div><!--end .adc-service-appt-->';
				} else {
				//If is is X-ray, don't display anything
				}
				the_content();
			// Check if there is a video URL and display embedded player
				adc_display_video_3();
			echo '</div><!--end .two-thirds first-->';
			
			//Right column
			echo '<div class="one-third adc-col">';
			// Place location info here
			echo '<h3>Location & Hours</h3>';
            output_location_info();
			//if this is the HRM page, show the next HRM event-->
            if (is_single('2079')) {
				 if ( is_active_sidebar('hrm-sidebar') ) {
						dynamic_sidebar( 'hrm-sidebar' );
					}
			} else {
			}
			//if this is the EasyCare page, show school physical links
            if (is_single('2077')) {
				echo '<div>';
				adc_school_physical_forms();
				echo '</div>';
			} else {
			}
			//if this is the travel clinic, show list of external bookmarks
			if(is_single( '2082' )) {
				echo '<div>';
				adc_travel_links();	
				echo '</div>';
			} else {
			}
			echo '</div><!-- end .one-third-->';
			//Education links
			echo '<div class="adc-grid-content adc-section">';
			adc_patient_links();
			echo '</div><!-- end .adc-grid-content .adc-section-->';
			//Show doctors and providers associated with this service in a grid
			echo '<div id="adc-grid-content" class="adc-grid-content adc-section">';
				output_doctor_list_2();
			echo '</div><!-- end #adc-grid-content .adc-grid-content -->';
			adc_easycare_note_page();
			echo '</div><!-- end .page .hentry .entry .adc-provider-->';			
		endwhile;
	endif;
	wp_reset_query();
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

