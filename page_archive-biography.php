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
	$catTerms = get_terms(array('category'), array('hierarchical'  => false));
	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	// Set menu for Isotope filters
	echo '<div id="filters">';
	
	echo '<div class="multiselect one-third first">';
		echo '<h5>Search by provider</h5>';
		echo '<label><input type="radio" name="gender" value="" checked>Any</label>';
		echo '<label><input type="radio" name="gender" value=".Female">Female</label>';
		echo '<label><input type="radio" name="gender" value=".Male" class="current">Male</label>';
		echo '<label><input type="checkbox" name="option" value=".new-patients">Accepting New Patients</label>';
		echo '<label><input type="checkbox" name="option" value=".new-medicare">Accepting New Medicare Patients</label>';
		echo '<label><input type="checkbox" name="option" value=".spanish">Speaks Spanish</label>';
	echo '</div><!-- end .multiselect .one-third .first -->';
	echo '<div class="one-third"><h5>Search by specialty</h5>';
		echo '<div class="multiselect">';
		echo '<label><input type="radio" name="care" value="" checked>Any</label>';
		echo '<label><input type="radio" name="care" value=".primary-care">Primary care</label>';
		echo '<label><input type="radio" name="care" value=".specialty-care" class="current">Specialty care</label>';
		echo '<label><input type="radio" name="care" value=".services">Services</label>';
	echo '</div><!-- end .multiselect -->';
	echo '<select id="adc-specialty-select"><option value="*">Choose a Specialty</option>';
	foreach($medTerms as $medTerm) {
		//echo '<li><a href="#" data-filter=".'. $medTerm->slug .'" class="current">'. $medTerm->name .'</a></li>';
		echo '<option value=".'. $medTerm->slug .'">'. $medTerm->name .'</option>';
	}
	echo '</select></div>';
	echo '<div class="one-third"><h5>Search by location</h5>';
	echo '<div class="multiselect">';
		echo '<label><input type="checkbox" name="loc" value=".north">North Austin / Round Rock</label>';
		echo '<label><input type="checkbox" name="loc" value=".south">South Austin</label>';
		echo '<label><input type="checkbox" name="loc" value=".west">West Austin / Steiner Ranch</label>';
		echo '<label><input type="checkbox" name="loc" value=".neph-satellite">Nephrology satellite</label>';
	echo '</div><!-- end .multiselect -->';
	echo '<select id="adc-location-select"><option value="*">Choose a Location</option>';
	foreach($locationTerms as $locationTerm) {
		echo '<option value=".'. $locationTerm->slug .'">'. $locationTerm->name .'</option>';
	}
	echo '</select></div>';
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
			
			$classes .= ' ' . genesis_get_custom_field( 'ecpt_gender');
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewpatients') == "on") ? " new-patients" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewmedicarepatients') == "on") ? " new-medicare" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_spanish') == "on") ? " spanish" : "");
			
			echo "<div class=\"$classes\" data-category=\"$service\">";
				if ( is_mobile()){
					//adc_get_related_post_thumb();
					echo '<h4><a href="' . 
					get_permalink();
					echo '">';
					the_title();
					adc_display_suffix();
					echo '</a></h4>';
					echo get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
					echo adc_get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>', array(247,248,249,556) );
				} else {
					echo '<a href="' . 
					get_permalink();
					echo '">';
					adc_get_lazy_bio_thumb();
					echo '</a>';
					echo '<h4><a href="' . 
					get_permalink();
					echo '">';
					the_title();
					adc_display_suffix();
					echo '</a></h4>';
					echo get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
					echo adc_get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>', array(247,248,249,556) );
				}
				
			echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end #adc-grid-content .adc-grid-content -->';
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}

function adc_get_lazy_bio_thumb() {
//	echo '<img src="' . get_bloginfo('stylesheet_directory') . '/images/adc-gray-box.png" >';
	if ('' != get_the_post_thumbnail()) {
  		echo get_the_post_thumbnail( $post->ID ,array(250, 250, true), array('class' => 'adc_portrait_thumb') );
	} elseif (get_first_image($post->ID) != '') {
   		echo get_first_image($post->ID);
	}
}

	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();
