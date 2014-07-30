<?php 
/**
 * Template Name: Page of Posts Archive 1
 * ADC Twenty Thirteen
 *
 * Description: Archive that allows you to define posts from certain category through custom field in page. This will display a thumbnail and an excerpt. 
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
add_action( 'genesis_loop', 'adc_page_of_posts_archive_one' );
 
function adc_page_of_posts_archive_one() {
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	
 	echo '<div class="adc-grid-content">';
	global $wp_query;
	if ( is_page() ) {
		$category = genesis_get_custom_field('adc-category');
		$tagid = genesis_get_custom_field('adc-tag-id');
		$taxid = genesis_get_custom_field('adc-tax-id');
	}
	if ($category) {
		$cat = get_cat_ID($category);
		$post_per_page = 15;
		$do_not_show_stickies = 0; // 0 to show sticky posts
		$args=array(
		'post_type' => 'post',
		'category__in' => array($cat),
		'paged' => get_query_var( 'paged' ),
		'posts_per_page' => $post_per_page,
		'caller_get_posts' => $do_not_show_stickies,
		'order' => 'DESC',
		'orderby' => 'date',
		);
/** The following two lines were commented out on october 10, 2013 after the grid stopped showing on the production site.**/
//		$temp = $wp_query; // assign orginal query to temp variable for later use
//		$wp_query = null;
	 
		$wp_query = new WP_Query( $args );
		if( $wp_query->have_posts() ): 
			while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
				$classes = 'one-third';
				if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
					$classes .= ' first';
						echo '<div class="'.  $classes . '">';
							if ( has_post_format( 'video' )) {
								adc_get_excerpt_bio_thumb();
								echo '<h4>' . adc_video_post() . ' <a href="' . 
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
		} // end if ($category)
		elseif ($tagid) {
			$post_per_page = 15;
			$do_not_show_stickies = 0; // 0 to show sticky posts
			$args=array(
			'post_type' => 'post',
			'tag__in' => array($tagid),
			'paged' => get_query_var( 'paged' ),
			'posts_per_page' => $post_per_page,
			'caller_get_posts' => $do_not_show_stickies,
			'order' => 'DESC',
			'orderby' => 'date',
			);
/** The following two lines were commented out on october 10, 2013 after the grid stopped showing on the production site.**/
//			$temp = $wp_query; // assign orginal query to temp variable for later use
//			$wp_query = null;
		 
			$wp_query = new WP_Query( $args );
			if( $wp_query->have_posts() ): 
				while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
					$classes = 'one-third';
					if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
						$classes .= ' first';
							echo '<div class="'.  $classes . '">';
								if ( has_post_format( 'video' )) {
									adc_get_excerpt_bio_thumb();
									echo '<h4>' . adc_video_post() . ' <a href="' . 
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
		}// end if ($tagid)
		elseif ($taxid) {
			$post_per_page = 15;
			$do_not_show_stickies = 0; // 0 to show sticky posts
			$args=array(
			'post_type' => 'post',
			'news' => $taxid,
			'paged' => get_query_var( 'paged' ),
			'posts_per_page' => $post_per_page,
			'caller_get_posts' => $do_not_show_stickies,
			'order' => 'DESC',
			'orderby' => 'date',
			);
		 
			$wp_query = new WP_Query( $args );
			if( $wp_query->have_posts() ): 
				while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
					$classes = 'one-third';
					if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
						$classes .= ' first';
							echo '<div class="'.  $classes . '">';
								if ( has_post_format( 'video' )) {
									adc_get_excerpt_bio_thumb();
									echo '<h4>' . adc_video_post() . ' <a href="' . 
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
		}// end if ($taxid)	
	echo '</div><!-- end .adc-grid-content -->';
	
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}

genesis();