<?php
/**
 * Template Name: Locations Archive
 *
 * Description: Layout for top-level locations page
 * Uses custom query to display excerpts and thumbnails from location custom post type
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_location_archives_loop' );

function custom_do_location_archives_loop() {
    	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	//echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	//echo '<div class="entry-content">' . get_the_content() ;
	if ( !get_query_var( 'paged' ) ) {
		$pt = get_post_type_object( get_post_type() );
		echo '<h1 class="entry-title">'.$pt->labels->name.'</h1>';
		// query to show content from the Locations page
			$locationsquery = new WP_Query( 'pagename=locations' );
			while ( $locationsquery->have_posts() ) : $locationsquery->the_post();
				the_content();
			endwhile;
			wp_reset_postdata();
		}

	//Main locations
	echo '<div class="adc-grid-content featured-clinics adc-section adc-locations-grid">';
	echo '<h3>Clinic Locations</h3>';
	if ( is_mobile()){
		adc_featured_locations_2();
	} else {
		adc_featured_locations();
	}
	echo '</div><!-- end .adc-grid-content .featured-clinics .adc-section-->';
	//Nephrology Satellites
	echo '<div class="adc-grid-content neph-clinics adc-section">';
	echo '<h3>Nephrology Satellites</h3>';
	adc_neph_locations();
	echo '</div><!-- end .adc-grid-content .neph-clinics .adc-section adc-locations-grid-->';
	
	//echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();