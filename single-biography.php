<?php
/**
 * Template Name: Single Biography
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
add_action( 'genesis_loop', 'custom_do_single_biography_loop' );

function custom_do_single_biography_loop() {
	global $paged;
	$args = array(
		'post_type' =>'biography',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-provider">';
			echo '<h1 class="entry-title">'. get_the_title() . ', ';
			adc_display_suffix();
			echo '</h1>';
			adc_display_more_suffix();
			echo '<div class="one-half first"><div class="adc-specialty-link">';
			echo get_the_term_list( get_the_ID(), 'medicalservice', '', ' ', '' );
			echo '</div><!--end .adc-specialty-link-->';
			
			//Check to see if provider is a hospitlist and display appropriate phone number
			if( genesis_get_custom_field('ecpt_hospitalist') == true) { //check to see if this doctor is a hospitalist
				echo '';
			} elseif (pa_in_taxonomy('otherdepartment', 'administration')) {
				echo '<div class="adc-provider-appt">';
				echo '<h3>Information</h3><a href="tel://512.901.1111/" title="Dial phone number from a mobile device">512-901-1111</a>';
				echo '</div>';
			} else {
			//Display appointment phone number of a section related by the provider's name
			$providerphone = get_posts_related_by_taxonomy(get_the_ID(),'provider');
			if ($providerphone->have_posts()){
				while ($providerphone->have_posts()): $providerphone->the_post();
					if ( 'specialty' == get_post_type() ) {
						if ( is_single( array( 447, 3342, 3352, 3389, 3130 )) ) {
							echo '<div class="adc-provider-appt btn"><h3>Appointments</h3>';
							echo '<a href="tel://';
							adc_second_location_appt_phone();
							echo '">';
							adc_second_location_appt_phone();
							echo '</a></div><!--end .adc-provider-appt-->';
						} else {
							echo '<div class="adc-provider-appt btn"><h3>Appointments</h3>';
							echo '<a href="tel://';
							adc_display_appointment_phone();
							echo '">';
							adc_display_appointment_phone();
							echo '</a></div><!--end .adc-provider-appt-->';
						}
					}  elseif ( 'service' == get_post_type()) {
						echo '<div class="adc-provider-appt btn"><h3>Appointments</h3>';
						echo '<a href="tel://';
						adc_display_main_phone();
						echo '">';
						adc_display_main_phone();
						echo '</a></div><!--end .adc-provider-appt-->';
					} else {
						
					}
				 endwhile;
			  } 
			  wp_reset_query();
             
			  } //end check to see if hospitalist */
			  
			//Display all of the locations assigned to this provider-->
            echo '<div class="adc-bio-locations"><h3>Locations</h3>';
			echo get_the_term_list( get_the_ID(), 'cliniclocation', '<p>', '<br />', '</p>' );
            echo '</div><!-- end .adc-bio-locations-->';
			//Display metabox info for this provider
        	echo '<ul class="adc-provider-basic-info">';
			adc_display_accept_new_patients();
			adc_display_accept_medicare();
			adc_display_accept_new_medicare();
			adc_provider_spanish();
			adc_provider_other_language();
			echo '</ul>';
			adc_easycare_note();
			echo '</div><!--end .one-half first-->';
			//Display doctor photo
			echo '<div class="one-half">';
			adc_featured_image_medium();
			//Doctor start date
			if ( genesis_get_custom_field( 'ecpt_startdate_2' )) {
				echo '<h4>ADC provider since ' . genesis_get_custom_field('ecpt_startdate_2') . '</h4>';
			}
			echo '</div><!-- end .one-half-->';
			//Display the content of the editor for this provider
			echo '<div class="one-half first">';
			the_content();
			//Display any extra information assigned to a metabox
			/* Place content here */
			echo '</div><!--end .one-half first-->';
			echo '<div class="one-half">';
			//Doctor quote
			if ( genesis_get_custom_field( 'ecpt_quote')) {
				echo '<div class="adc-testimonial">' . genesis_get_custom_field('ecpt_startdate_2') . '<br />- ';
				 echo get_the_title();
				 echo'</div>';	
			}
			if ( genesis_get_custom_field( 'ecpt_honorsawards' )) {
				echo '<div class="adc-provider-awards"><h4>Awards</h4>' . genesis_get_custom_field( 'ecpt_honorsawards' ) . '</div>';	
			}
			//meet the doctor video
			adc_display_bio_video();
			//Related videos
			$relatedvideos = get_posts_related_by_taxonomy(get_the_ID(),'provider');
            	if ($relatedvideos->have_posts()){
					$first = true;
						while ($relatedvideos->have_posts()): $relatedvideos->the_post();
							if ( has_post_format( 'video' )) {
                         		if ($first == true) { 
								echo '<h4>Related Videos</h4>';
								$first = false;
							 	}
								adc_get_related_post_thumb();
                                echo '<ul>';
								echo '<li><a href="';
								get_permalink();
								echo '">';
								the_title();
								echo '</a></li>';
                                echo '<li><span class="adc-date">' . the_time('F j, Y') . '</span></li>';
                                echo '</ul>';
						 	} 
						 endwhile; 
					 } 
				 wp_reset_query();
		
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

