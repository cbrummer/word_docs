<?php
/*
 * Template Name: Contact Directory
 *
 * Description: A full-width layout template to be used with the directory page in the Contact section
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_contact_directory_archives_loop' );
function custom_do_contact_directory_archives_loop() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	
	//Table directory
	echo '<table class="directory adc-provider-directory" summary="List of phone numbers and links to individual ADC departments">';
	echo '<!-- Table header -->';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Specialty or Service</th>';
	echo '<th>Location</th>';
	echo '<th>Appointments</th>';
	echo '<th>Main Phone</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<!-- Table footer -->';
	echo '<tfoot>';
	echo '<tr>';
    echo '<td colspan="4"></td>';
    echo '</tr>';
    echo '</tfoot>';
    echo '<!-- Table body -->';
    echo '<tbody>';
    global $post;   
		$args = array(
			'post_type' => array( 
				'specialty',
				'service' 
				),
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);
		$directory = new WP_Query( $args );
			while ($directory->have_posts()) : $directory->the_post();
            	echo '<tr class="adc-directory-row">';
				echo '<td class="adc-directory-col1">';
				echo '<h4><a href="' . 
				get_permalink();
				echo '">';
				the_title();
				echo '</a></h4>';
				echo '</td>';
                echo '<td class="adc-directory-col2">';
                echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
                echo '</td>';
                echo '<td class="adc-directory-col3">';
				adc_display_appointment_phone();
				echo '<br />';
				adc_second_location_appt_phone();
                echo '</td>';
                echo '<td class="adc-directory-col4">';
				adc_display_main_phone();
				echo '<br />';
				adc_second_location_main_phone();
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
