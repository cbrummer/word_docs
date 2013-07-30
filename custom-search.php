<?php
/*
/**
 * Template Name: Custom Search
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */
 
	remove_action('genesis_loop', 'genesis_do_loop');
	
	add_action('genesis_loop', 'adc_search_archives');
	function adc_search_archives() {
	global $paged;
		$biographylist = new WP_Query(array(
			'post_type' =>'biography',
			'post_status' => 'publish',
			'posts_per_page' => 20,
			'meta_key' => 'ecpt_surname',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'paged'=>$paged
			)); ?>
	<?php while ( $biographylist->have_posts() ) : $biographylist->the_post(); ?>
				<div class="adc-provider-excerpt adc-doc-float sm">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
					echo get_the_post_thumbnail($post->ID,array(100,100, true), array('class' => 'excerpt-thumb') );
					} elseif (get_first_image($post->ID) != '')
						echo get_first_image($post->ID);
					 else { ?>
						<img src="<?php bloginfo('stylesheet_directory'); ?>/images/ADC-site-logo.jpg" width="100" height="100" alt="<?php the_title(); ?>" class="excerpt-thumb" />
			<?php }
				echo '<h4 class="adc-provider-title">'; ?>
					<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s biography' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php the_title();
					$suffix= get_post_meta($post->ID, 'ecpt_suffix', true); 
					if( strlen(trim($suffix)) > 0 ) {
						echo ', ' . $suffix;
					}
					?>
					</a>
				<?php echo '</h4>';
			 echo get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
			 echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' ); ?>
			 </div>
	<?php endwhile;
		genesis_custom_loop( $biographylist );
	}
	
	genesis();
?>