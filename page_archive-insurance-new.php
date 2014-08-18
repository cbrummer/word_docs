<?php
/**
 * Template Name: Insurance
 * Description: A Page Template for the Insurance page in the Patient Tools section pages
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_insurance_list_archives_loop' );
function custom_do_insurance_list_archives_loop() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content();
	echo '<ul>';
    global $post;   
		$args = array(
			'post_type' => 'insurance',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_status' => 'publish'
		);
		$acceptedinsurances = new WP_Query( $args );
			while ($acceptedinsurances->have_posts()) : $acceptedinsurances->the_post();
				echo '<li>'; 
				adc_display_insurance_url();
				echo '</li>';
			 endwhile;
		 // Reset Post Data
	wp_reset_postdata();
	echo '</ul>';	
 	echo '</div><!--.entry-content--></div><!--page hentry entry-->';               
}
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();