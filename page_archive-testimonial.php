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
	$postId = get_the_ID();
	$categories = get_the_category($postId);
	$taxonomies = get_the_taxonomies($postId);

	$args = array(
		'post_type' => array( 'testimonial', 'post' ),
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'category__in' => array( 537, 1080 ) 
		//'tax_query' => array(
		//	array(
		//		'taxonomy' => 'staff',
		//		'field' => 'slug',
		//	),
		//  ),
		);
//		if (is_staff_only()) {
//			$args['post_type'] = array('testimonial');
//			$args['category__in'] = array( 537, 1080 );
//		};
//		if (is_HRM_tesimonial() { 
//		};
//		if (is_other_page()) {
//		};
		
	global $wp_query;
	$wp_query = new WP_Query( $args );
	output_testimonials($wp_query);
}

/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();