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
 
 add_action('wp_enqueue_scripts', 'bio_scripts');
 function bio_scripts() {
	 wp_register_script('adc-select2', get_stylesheet_directory_uri() . '/lib/js/select2/select2.js');
	 wp_enqueue_script('adc-select2');
	 wp_register_style('adc-select2-css', get_stylesheet_directory_uri() . '/lib/js/select2/select2.css');
	 wp_enqueue_style('adc-select2-css');
 };

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
	do_action('addthis_widget',get_permalink($post->ID), get_the_title($post->ID), 'small_toolbox');
	// Set menu for Isotope filters
	echo '<div id="filters">';
	echo '<div class="one-third first"><h5><span class="icon-oxp-pin"></span> Search by location</h5>';
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
	echo '</select></div><!--end .one-third .first-->';
	echo '<div class="multiselect one-third">';
		echo '<h5><span class="icon-oxp-avatar-01"></span> Search by provider</h5>';
		echo '<label><input type="radio" name="gender" value="" checked>Any</label>';
		echo '<label><input type="radio" name="gender" value=".female">Female</label>';
		echo '<label><input type="radio" name="gender" value=".male" class="current">Male</label>';
		echo '<label><input type="checkbox" name="option" value=".new-patients">Accepting New Patients</label>';
		echo '<label><input type="checkbox" name="option" value=".new-medicare">Accepting New Medicare Patients</label>';
		echo '<label><input type="checkbox" name="option" value=".spanish">Speaks Spanish</label>';
		echo '<input type="hidden" id="adcProviderSelect" value="*" style="width:100%">';
	echo '</div><!-- end .multiselect .one-third -->';
	echo '<div class="one-third"><h5><span class="icon-oxp-search"></span> Search by specialty</h5>';
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
	echo '<div class="adc-clear-filters"><a href="#" id="adc-clear-filters" class="btn">Reset Search Filters</a></div>';
	echo '</div><!--end #filters-->';

	echo '<div class="adc-no-results" style="display:none;">We are sorry. No providers match your filter selections. Please review or <a id="adc-clear-filters" href="#">reset</a> your filters.</div>';
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
	
	$providers = array();
	global $wp_query;
	$wp_query = new WP_Query( $args );
	
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
			$classes = 'one-fourth adc-provider';
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
			
			$classes .= ' ' . strtolower(genesis_get_custom_field( 'ecpt_gender'));
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewpatients') == "on") ? " new-patients" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_acceptsnewmedicarepatients') == "on") ? " new-medicare" : "");
			$classes .= ((genesis_get_custom_field( 'ecpt_spanish') == "on") ? " spanish" : "");
			$classes .= ' name-' . sanitize_title(get_the_title());
			
			array_push($providers,  array('id' => '.name-' . sanitize_title(get_the_title()), 'text' => get_the_title()));
			
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
					echo '<div class="btn"><a href="/request-appointment-provider/?adc-provider-name='.get_the_title().'" title="Request Appt Link"><span class="icon-oxp-calendar"></span> Request Appointment</a></div>';
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
					echo '<div class="btn"><a href="/request-appointment/?adc-provider-name='.get_the_title().'" title="Request Appt Link"><span class="icon-oxp-calendar"></span> Request Appointment</a></div>';
				}
				
			echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '<script type="text/javascript">var adcProviders = ' . json_encode($providers) . '; adcProviders.unshift({id:"*", text:"Choose a Provider"}); jQuery("#adcProviderSelect").select2({ data: adcProviders }); </script>';		
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
