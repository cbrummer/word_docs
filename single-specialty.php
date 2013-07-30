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
			echo '<div class="one-half first">';
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
			echo '</div><!--end .one-half first-->';
			
			//Right column
			echo '<div class="one-half">';
			// Place location info here
			echo '<h3>Location & Hours</h3>';
            $location1 = genesis_get_custom_field( 'ecpt_location1' );
				echo '<h4 class="adc-info-numbers"><a href="';
				echo bloginfo('url') . '/locations/' . sanitize_title( $location1 ) .'/';
				echo '">';
				echo $location1;
				echo '</a></h4>';
				echo '<ul class="adc-num-list">';
			 	adc_display_location_1_list();
        	 	echo'</ul><!--end location 1 important numbers list-->';
            $location2 = genesis_get_custom_field( 'ecpt_location2' );
				if( $location2 ) {
					echo '<h4 class="adc-info-numbers"><a href="';
					echo bloginfo('url') . '/locations/' . sanitize_title( $location2 ) . '/';
					echo '">';
					echo $location2;
					echo '</a></h4>';
					echo '<ul class="adc-num-list">';
					adc_display_location_2_list();
					echo '</ul><!--end location 2 important numbers list-->';
				}
        	$location3 = genesis_get_custom_field( 'ecpt_location3' );
				if( $location3 ) {
					echo '<h4 class="adc-info-numbers"><a href="';
					echo bloginfo('url') . '/locations/' . sanitize_title( $location3 ) . '/';
					echo '">';
					echo $location3;
					echo '</a></h4>';
					echo '<ul class="adc-num-list">';
					adc_display_location_3_list();
					echo '</ul><!--end location 3 important numbers list-->';
				}
             $location4 = genesis_get_custom_field( 'ecpt_location4' );
				if( $location4 ) {
					echo '<h4 class="adc-info-numbers"><a href="';
					echo bloginfo('url') . '/locations/' . sanitize_title( $location4 ) . '/';
					echo '">';
					echo $location4;
					echo '</a></h4>';
					echo '<ul class="adc-num-list">';
					adc_display_location_4_list();
					echo '</ul><!--end important numbers list-->';
				}
			
			echo '</div><!-- end .one-half-->';
			
			
			
			//Left column
			echo '<div class="one-half first">';
			
			//Place education links here
			//Show list of related educational materials EXCEPT those in patient education category 
            $visitinfo = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
             	if ($visitinfo->have_posts()){
                	$first = true;
						while ($visitinfo->have_posts()): $visitinfo->the_post();
							if ( in_category( array('instructions', 'patient-forms', 'procedure-preparations', 'resource-materials', 'office-policies', 'patient-surveys') )) {					
							if ($first == true) { 
								echo '<h3>Prepare for your visit</h3><ul class="adc-col-list">';
								$first = false;
							 }
                             	echo '<li><a href="' ;
								the_permalink();
								echo '">';
								the_title();
								echo '</a></li>';
							}
					endwhile;
				} else { 
					}
				echo '</ul>';
			wp_reset_query();
           
             //Show list of related educational materials EXCEPT those in patient education category--> 
             $education = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
             	if ($education->have_posts()){
                	$first = true;
						while ($education->have_posts()): $education->the_post();
							if ( in_category( 'patient-education' )) {
								if ($first == true) { 
									echo '<h3>Educational Materials</h3><ul class="adc-col-list">';
								$first = false;
							 }
                           		echo '<li><a href="' ;
								the_permalink();
								echo '">';
								the_title();
								echo '</a></li>';
							}
					endwhile;
				} else {
					}
				echo '</ul>';
			wp_reset_query(); 
            
            //Related patient education
            $healtharticles = get_blog_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');	
             	if ($healtharticles->have_posts()){
                	$first = true;
						while ($healtharticles->have_posts()): $healtharticles->the_post();
						static $counter = 0;
							if ( in_category( 'health-articles' )) {	
						
							if ($first == true) { echo '<h3>Related Health News</h3><ul class="adc-col-list">';
								$first = false;
							 }
							 if ($counter == "5") { break;
							 } else {
                           		echo '<li><a href="' ;
								the_permalink();
								echo '">';
								the_title();
								echo '</a></li>';
							$counter++;
							};
						}
					endwhile;
				} else { 
					}
				echo '</ul>';
			wp_reset_query();
           //Show list of related quality reports
             $qareports = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
             	if ($qareports->have_posts()){
                	$first = true;
						while ($qareports->have_posts()): $qareports->the_post();
							if ( 'qualityreports' == get_post_type()) {
								if ($first == true) { echo '<h4>Quality Reports</h4><ul class="adc-col-list">';
								$first = false;
							 }
                          		echo '<li><a href="' ;
								the_permalink();
								echo '">';
								the_title();
								echo '</a></li>';
							}
					endwhile;
				} else {
					}
				echo '</ul>';
			wp_reset_query();
			echo '</div><!--end .one-half first-->';
			
			
			//Right column
			echo '<div class="one-half">';
			//Doctors associated with this specialty
			$providers = get_provider_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
			if ($providers->have_posts()){
				echo '<h3>Doctors &amp; Providers</h3>';
                	while ($providers->have_posts()): $providers->the_post();
						if ( 'biography' == get_post_type()) {
							if (pa_in_taxonomy('cliniclocation', 'cedar-bend')){
                              echo '<div class="adc-list-excerpt adc-provider-basic-info">';  
                            echo '<div class="adc-list-excerpt-img">';
							adc_get_related_post_thumb();
							echo '</div><!--.adc-list-excerpt-img-->';
                            echo '<div class="adc-list-excerpt-info">';
                            echo '<h4><a href="';
							the_permalink();
							echo '">';
							the_title();
							echo ', ';
							adc_display_suffix();
							echo '</a></h4>';
							echo '<ul>';
							adc_display_accept_new_patients();
							echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
                            echo '</ul>';
                            echo '</div><!-- end .adc-list-excerpt-info-->';
                         	echo '</div><!-- end .adc-list-excerpt-->';
							  
						} elseif (pa_in_taxonomy('cliniclocation', 'circle-c')){
							echo '<div class="adc-list-excerpt">';  
                            echo '<div class="adc-list-excerpt-img">';
							adc_get_related_post_thumb();
							echo '</div><!--.adc-list-excerpt-img-->';
                            echo '<div class="adc-list-excerpt-info">';
                            echo '<h4><a href="';
							the_permalink();
							echo '">';
							the_title();
							echo ', ';
							adc_display_suffix();
							echo '</a></h4>';
							echo '<ul>';
							adc_display_accept_new_patients();
							echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
                            echo '</ul>';
                            echo '</div><!-- end .adc-list-excerpt-info-->';
                         	echo '</div><!-- end .adc-list-excerpt-->';
                         } else {
                        	echo '<div class="adc-list-excerpt">';  
                            echo '<div class="adc-list-excerpt-img">';
							adc_get_related_post_thumb();
							echo '</div><!--.adc-list-excerpt-img-->';
                            echo '<div class="adc-list-excerpt-info">';
                            echo '<h4><a href="';
							the_permalink();
							echo '">';
							the_title();
							echo ', ';
							adc_display_suffix();
							echo '</a></h4>';
							echo '<ul>';
							adc_display_accept_new_patients();
							echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
                            echo '</ul>';
                            echo '</div><!-- end .adc-list-excerpt-info-->';
                         	echo '</div><!-- end .adc-list-excerpt-->';
						 }
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

