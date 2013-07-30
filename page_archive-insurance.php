<?php
/**
 * Template Name: Insurance List
 * Description: A Page Template for the Insurance list in the Patient Tools section pages
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_insurance_list_archives_loop' );
function custom_do_insurance_list_archives_loop() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	
	//Table directory

	echo '<table class="directory adc-provider-directory" summary="List of insurances, which providers accept them and links to each plans website">';
	echo '<!-- Table header -->';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Plan</th>';
	echo '<th>Notes</th>';
	echo '<th>Accepted by</th>';
	echo '<th>Plan URL</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<!-- Table footer -->';
	echo '<tfoot>';
	echo '<tr>';
	$url = site_url('/patient-tools/insurance/insurances-accepted/medicare/');
    echo '<td colspan="4"><a href="'. $url.'">Special note about Medicare</a></td>';
    echo '</tr>';
    echo '</tfoot>';
    echo '<!-- Table body -->';
    echo '<tbody>';
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
            	echo '<tr class="adc-directory-row">';
				echo '<td>';
				echo '<strong>' . the_title() . '</strong>';
				echo '</td>';
                echo '<td>';
                adc_display_insurance_notes();
                echo '</td>';
                echo '<td>';
				adc_display_insurance_acceptance();
                echo '</td>';
                echo '<td>';
				adc_display_insurance_url();
                echo '</td>';
                echo '</tr>';
			 endwhile;
		 // Reset Post Data
	wp_reset_postdata();
	echo '</tbody>';
	echo '</table>';	
 	echo '</div><!--.entry-content-->';               
}
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();