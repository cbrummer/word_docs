<?php
/**
 * Template name: Biography archives
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
add_action( 'genesis_loop', 'custom_do_biography_archives_loop' );

function custom_do_biography_archives_loop() {
	
	$medTerms = get_terms(array('medicalservice'), array('hierarchical'  => false));
	$locationTerms = get_terms(array('cliniclocation'), array('hierarchical'  => false));
	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">All Provider Biographies</h1>';
	echo '<div class="entry-content">';
	// Set menu for Isotope filters
	echo '<div id="filters">';
	echo '<h3 class="one-half first">Search for a Provider</h3>';
	echo '<h4 class="one-half"><a href="#" data-filter="*">Show all providers</a></h4>';
	
	echo '<div class="multiselect one-third first">';
		echo '<label><input type="checkbox" name="option[]" value=".Female">Female</label>';
		echo '<label><input type="checkbox" name="option[]" value=".Male" class="current">Male</label>';
		echo '<label><input type="checkbox" name="option[]" value=".new-patients">Accepting New Patients</label>';
		echo '<label><input type="checkbox" name="option[]" value=".new-medicare">Accepting New Medicare Patients</label>';
		echo '<label><input type="checkbox" name="option[]" value=".spanish">Speaks Spanish</label>';
	echo '</div><!-- end .multiselect .one-third .first -->';
	echo '<select id="adc-specialty-select" class="one-third"><option value="*">Choose a Specialty</option>';
	foreach($medTerms as $medTerm) {
		//echo '<li><a href="#" data-filter=".'. $medTerm->slug .'" class="current">'. $medTerm->name .'</a></li>';
		echo '<option value=".'. $medTerm->slug .'">'. $medTerm->name .'</option>';
	}
	echo '</select>';
	echo '<select id="adc-location-select" class="one-third"><option value="*">Choose a Location</option>';
	foreach($locationTerms as $locationTerm) {
		echo '<option value=".'. $locationTerm->slug .'">'. $locationTerm->name .'</option>';
	}
	echo '</select>';
	echo '<div class="adc-clear-filters"><a href="#" id="adc-clear-filters" class="btn">Clear Filters</a></div>';
	echo '</div><!--end #filters-->';


	//Show grid content
	echo '<div id="adc-grid-content" class="adc-grid-content">';
	$args = array(
		'post_type' =>'biography',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_key' => 'ecpt_surname',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'paged' => get_query_var( 'paged' ),
		'cat'=>'-550' 
	);
	
	global $wp_query;
	$wp_query = new WP_Query( $args );
	
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
			$classes = 'one-third adc-provider';
			foreach( get_the_terms( $post->ID, 'medicalservice') as $term) {
				$classes .= ' ' . $term->slug;
			}
			foreach( get_the_terms( $post->ID, 'cliniclocation') as $location) {
				$classes .= ' ' . $location->slug;
			}
			
			$classes .= ' ' . genesis_get_custom_field( 'ecpt_gender');
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewpatients') == "on") ? " new-patients" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewmedicarepatients') == "on") ? " new-medicare" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_spanish') == "on") ? " spanish" : "");
			
			echo '<div class="'.  $classes . '">';
				echo '<div class="excerpt-thumb">'. adc_get_excerpt_bio_thumb().'</div>';
				echo '<h4><a href="' . 
				get_permalink();
				echo '">';
				the_title();
				adc_display_suffix();
				echo '</a></h4>';
				echo get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
				echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
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
