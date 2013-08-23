<?php
/**
 * Template name: Medical Services - archives
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

remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_medicalservice_archives_loop' );

function custom_do_medicalservice_archives_loop() {
    
	$medTerms = get_terms(array('medicalservice'), array('hierarchical'  => false));
	$locationTerms = get_terms(array('cliniclocation'), array('hierarchical'  => false));
	$catTerms = get_terms(array('category'), array('hierarchical'  => false));
	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	
	// Set menu for Isotope filters
	echo '<div id="filters">';
	echo '<div class="one-third first"><h5>Search by location</h5>';
	echo '<div class="multiselect">';
		echo '<label><input type="radio" name="loc" value="" checked>All Locations</label>';
		echo '<label><input type="radio" name="loc" value=".north">North Austin / Round Rock</label>';
		echo '<label><input type="radio" name="loc" value=".south">South Austin</label>';
		echo '<label><input type="radio" name="loc" value=".west">West Austin / Steiner Ranch</label>';
		echo '<label><input type="radio" name="loc" value=".neph-satellite">Nephrology satellite</label>';
	echo '</div><!-- end .multiselect -->';
	echo '<select id="adc-location-select"><option value="*">Choose a Location</option>';
	foreach($locationTerms as $locationTerm) {
		echo '<option value=".'. $locationTerm->slug .'">'. $locationTerm->name .'</option>';
	}
	echo '</select></div><!-- end .one-third first-->';
	echo '<div class="one-third"><h5>Search by need</h5>';
		echo '<div class="multiselect">';
		echo '<label><input type="radio" name="care" value="" checked>Any</label>';
		echo '<label><input type="radio" name="care" value=".primary-care">Primary care</label>';
		echo '<label><input type="radio" name="care" value=".specialty-care" class="current">Specialty care</label>';
		echo '<label><input type="radio" name="care" value=".services">Services</label>';
	echo '</div><!-- end .multiselect -->';
	echo '</div>';
	echo '<div class="one-third"><h5>Search by focus</h5>';
	echo '<div class="multiselect">';
		echo '<label><input type="checkbox" name="option" value=".womens-service">Specialties & services that treat women’s health conditions</label>';
		echo '<label><input type="checkbox" name="option" value=".childrens-service">Specialties & services that see children</label>';
	echo '</div><!-- end .multiselect .one-third -->';
	echo '</div>';
	echo '<div class="adc-clear-filters"><a href="#" id="adc-clear-filters" class="btn">Clear Filters</a></div>';
	echo '</div><!--end #filters-->';	
	
	
	//Show grid content
	echo '<div id="adc-grid-content" class="adc-grid-content">';
	$args = array(
		'post_type' =>array( 
					'specialty',
					'service' 
					),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'post_parent' => 0,
		'orderby' => 'title',
		'order' => 'ASC',
		'paged' => get_query_var( 'paged' ),
	);
	
	global $wp_query;
	$wp_query = new WP_Query( $args );
	
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
			$classes = 'one-third adc-service';
			$service = null;
			foreach( get_the_terms( $post->ID, 'medicalservice') as $term) {
				$classes .= ' ' . $term->slug;
				$service = str_ireplace('adc-', '', $term->slug);
			}
			foreach( get_the_terms( $post->ID, 'cliniclocation') as $location) {
				$classes .= ' ' . $location->slug;
			}
			foreach( get_the_terms( $post->ID, 'category') as $category) {
				$classes .= ' ' . $category->slug;
			}
			$classes .= ((genesis_get_custom_field( 'ecpt_adc_womens_service') == "on") ? " womens-service" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_adc_childrens_service') == "on") ? " childrens-service" : "");
			
			echo "<div class=\"$classes\" data-category=\"$service\">";
						echo '<a href="' . 
						get_permalink();
						echo '">';
						adc_get_excerpt_thumb();
						echo '</a>';
						echo '<h4><a href="' . 
						get_permalink();
						echo '">';
						the_title();
						echo '</a></h4>';
						echo '<ul><li><strong>Appointments</strong></li><li>';
						adc_display_appointment_phone();
						echo '</li></ul>';
					echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end #adc-grid-content .adc-grid-content -->';
	
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();
