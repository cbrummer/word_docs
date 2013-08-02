<?php
/**
 * Template Name: Testimonial Archive
 *
 * Description: Used to display archive of testimonials
 * 
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
add_action( 'genesis_loop', 'custom_do_testimonial_archives_loop' );

function custom_do_testimonial_archives_loop() {
    	
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	echo '<div class="adc-provider-excerpt .adc-grid-content">';
	$args = array(
		'post_type' => array( 'testimonial', 'post' ),
		'category__in' => array( 537, 1080 ),
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		//'tax_query' => array(
		//	array(
		//		'taxonomy' => 'staff',
		//		'field' => 'slug',
		//	),
		//  ),
		);
	
	global $wp_query;
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
			$classes = 'one-third';
			if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
				$classes .= ' first';
					echo '<div class="'.  $classes . '">';
						echo '<div class="excerpt-thumb">'. adc_get_excerpt_thumb().'</div>';
						echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
						the_excerpt();	
					echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end .adc-provider-excerpt .adc-grid-content -->';
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();