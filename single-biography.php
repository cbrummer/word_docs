<?php
/**
 * Template Name: Single Biography
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
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );
remove_action ('genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop', 'custom_do_single_biography_loop' );

function custom_do_single_biography_loop() {
	global $paged;
	$args = array(
		'post_type' =>'biography',
	);
	$wp_query = new WP_Query( $args );
	if( $wp_query->have_posts() ): 
		while ( have_posts() ) : the_post();
			echo '<div class="page hentry entry entry-content adc-provider">';
			echo '<h1 class="entry-title">'. get_the_title();
			adc_display_suffix();
			adc_display_more_suffix();
			echo '</h1>';
			
			echo '<div class="two-thirds first">';
			//Check to see if provider is a hospitlist and display appropriate phone number
			adc_display_provider_appointment();
			echo '<div class="adc-specialty-link">';
			echo get_the_term_list( get_the_ID(), 'medicalservice', '', ' ', '' );
			echo '</div><!--end .adc-specialty-link-->';			  
			//Display metabox info for this provider
        	echo '<ul class="adc-provider-basic-info">';
			adc_display_accept_new_patients();
			adc_display_accept_medicare();
			adc_display_accept_new_medicare();
			adc_provider_spanish();
			adc_provider_other_language();
			echo '</ul>';
			adc_easycare_note();
			//Display the content of the editor for this provider
			the_content();
			//Display any extra information assigned to a metabox
			/* Place content here */
			//meet the doctor video
			adc_display_bio_video();
			echo '</div><!--end .two-thirds first-->';
			//Display doctor photo
			echo '<div class="one-third">';
			adc_featured_image_medium();
			//Display all of the locations assigned to this provider-->
            echo '<div class="adc-bio-locations"><h3><span class="icon-oxp-pin"></span> Locations</h3>';
			//echo adc_get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>', array(247,248,249,556) );
			output_doc_location_info();
            echo '</div><!-- end .adc-bio-locations-->';
			//Doctor start date
			adc_display_start_date();
			//Doctor quote
			adc_display_provider_quote();
			adc_display_doctor_honors();
			echo '</div><!-- end .one-third-->';
			//Related videos
			echo '<div class="adc-grid-content adc-section">';
			adc_provider_related_videos();
			echo '</div><!-- end .adc-grid-content -->';
			echo '</div><!-- end .page .hentry .entry .adc-provider-->';			
		endwhile;
	endif;
	wp_reset_query();

}
	
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();

