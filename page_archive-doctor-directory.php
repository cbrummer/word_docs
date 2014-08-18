<?php
/*
 * Template Name: Doctor Directory
 *
 * Description: A full-width layout template to be used with the directory page in the Doctors section
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
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_doctor_directory_archives_loop' );
function custom_do_doctor_directory_archives_loop() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	echo '<table class="directory adc-provider-directory" summary="List of phone numbers and links to individual ADC providers">';
	echo '<!-- Table header -->';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Provider</th>';
	echo '<th>Specialty or Service</th>';
	echo '<th>Location</th>';
	echo '<th>Appointments</th>';
	echo '<!--Add 5th column after build <th>FAX</th>-->';
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
			'category__not_in' => 550,
			'post_type' => array( 'biography' ),
			'posts_per_page' => -1,
			'meta_key' => 'ecpt_surname',
			'orderby' => 'meta_value',
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
				//echo ', ';
				adc_display_suffix();
				echo '</a></h4>';
				echo '</td>';
                echo '<td class="adc-directory-col2">';
                echo get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
                echo '</td>';
                echo '<td class="adc-directory-col3">';
				echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
                echo '</td>';
                echo '<td class="adc-directory-col4">';
				$specialtyphone = get_posts_related_by_taxonomy($post->ID, 'medicalservice');
                	if ($specialtyphone->have_posts()){
                    	while ($specialtyphone->have_posts()): $specialtyphone->the_post();
                        $apptphone = get_post_meta(get_the_ID(), 'ecpt_mainappointmentphone', true);
							if( strlen(trim($apptphone)) > 0 ) {
								echo $apptphone;
							}
                        endwhile;				  
                     }
                  wp_reset_query();
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
