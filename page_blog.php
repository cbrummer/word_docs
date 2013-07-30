<?php 
/**
 * Template Name: Blog Archive
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Force Sidebar-Content-Sidebar Layout
add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );
add_action('genesis_post_content','the_content');  // Adds your custom page code/content before loop
// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'adc_category_page_clinic_news' );
 
function adc_category_page_clinic_news() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	echo do_shortcode("[adc_blogs]");
	
 	echo '<div class="adc-grid-content">';
	$post_per_page = 15;
    $args = array(
		'order' => 'ASC',
		'orderby' => 'title',
        'posts_per_page' => $post_per_page,
		'paged' => get_query_var( 'paged' ),
    );
 
    global $wp_query;
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
			$classes = 'one-third';
			if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
				$classes .= ' first';
					echo '<div class="'.  $classes . '">';
						if ( has_post_format( 'video' )) {
							adc_get_excerpt_bio_thumb();
							echo '<h4><a href="' . 
							get_permalink();
							echo '">';
							the_title();
							echo '</a></h4>';
							the_excerpt();
						} else {
							adc_get_excerpt_bio_thumb();
							echo '<h4><a href="' . 
							get_permalink();
							echo '">';
							the_title();
							echo '</a></h4>';
							the_excerpt();	
						}
					echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end .adc-grid-content -->';
	
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}

genesis();