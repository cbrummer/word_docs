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
	
	//Main locations
	echo '<h3>Clinic Locations</h3>';
	echo '<div class="main-locations adc-grid-content">';
	$args = array(
		'post_type' =>'wpseo_locations',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'cliniclocation',
				'field' => 'slug',
				'terms' => 'neph-satellite',
				'operator' => 'NOT IN',
			),
		  ),
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
						echo genesis_get_custom_field( 'ecpt_address' );
						echo genesis_get_custom_field( 'ecpt_phone' );	
					echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end .adc-grid-content -->';
	//Nephrology Satellites
	echo '<h3>Nephrology Satellites</h3>';
	echo '<div class="neph-locations adc-grid-content">';
	$args = array(
		'post_type' => 'wpseo_locations',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'cliniclocation',
				'field' => 'slug',
				'terms' => array('north','south','west'),
				'operator' => 'NOT IN',
			),
		  ),
		'posts_per_page' => 10,
		'orderby' => 'title',
		'order' => 'ASC',
		);
	
	global $wp_query;
	$nephrologylist = new WP_Query( $args );
	if( $nephrologylist->have_posts() ): 
		while( $nephrologylist->have_posts() ): $nephrologylist->the_post(); global $post;
			$classes = 'one-third';
			if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
				$classes .= ' first';
					echo '<div class="'.  $classes . '">';
						echo '<div class="excerpt-thumb">'. adc_get_excerpt_thumb().'</div>';
						echo '<h4><a href="' . 
						get_permalink();
						echo '">';
						the_title();
						echo '</a></h4>';
						echo genesis_get_custom_field( 'ecpt_address' );
						echo genesis_get_custom_field( 'ecpt_phone' );	
					echo '</div>';
			
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end .adc-grid-content -->';
	
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();