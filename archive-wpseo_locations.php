<?php
/**
 * Template Name: Locations - Local SEO
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

get_header(); ?>
  <?php $post_link = get_post_meta($post->ID, 'section-header', true);
			if ($post_link) : ?>
			<div class="adc-section-header"><?php echo $post_link; ?></div>
			
  <?php endif; ?>
  			<div class="adc-announce location-alert">
            	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('lab-alert-widget') ) : ?>
				<?php endif; ?>
            </div>
		<div id="primary" class="adc-two-column">
			<div id="content" class="page-section" role="main">
			  
				<?php the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
               
                <!-- show locations thumbnails and address-->
             <section class="adc-service-col-1">
             
               <h3 class="adc-page-excerpt-heading"><?php _e( 'Our Clinics', 'twentyeleven-child' ); ?></h3>

			   <?php /* Start the Loop */ ?>
                
               <?php $locationslist = new WP_Query(array(
			   		'post_type' =>'location',
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
					)); ?>
					<?php while ( $locationslist->have_posts() ) : $locationslist->the_post(); ?>
                            <div class="adc-list-excerpt">
                              <div class="adc-list-excerpt-img">
                            	<?php //begin call for thumbnail
                                    if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
                                    echo get_the_post_thumbnail($post->ID,array(100,100, true), array('class' => 'excerpt-thumb') );
                                    } elseif (get_first_image($post->ID) != '')
                                        echo get_first_image($post->ID);
                                     else { ?>
                                        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/ADC-site-logo.jpg" width="100" height="100" alt="<?php the_title(); ?>" class="excerpt-thumb" />
                                 <?php } //end call for thumbnail ?>
                                </div><!--.adc-list-excerpt-img-->
                                <div class="adc-list-excerpt-info">
                                <?php echo '<h4>'; ?>
                                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php the_title(); ?></a>
                                <?php echo '</h4>'; ?>
                            	<ul>
		                       	 	<?php echo '<li>' . get_post_meta($post->ID, 'ecpt_address', true) . '</li>'; 
							 			  echo '<li>' . get_post_meta($post->ID, 'ecpt_phone', true) . '</li>';?>
                                </ul>
                             </div><!-- end .adc-list-excerpt-info-->
                         </div><!-- end .adc-list-excerpt-->
					<?php endwhile;
				// Reset Post Data
				wp_reset_query();
				?>
			</section><!-- .adc-content-col-1-->
              
            <section class="adc-service-col-2">
 			  <h3 class="adc-page-excerpt-heading"><?php _e( 'Nephrology Satellites', 'twentyeleven-child' ); ?></h3>

				<?php /* Start the Next Loop */ ?>
                
				<?php $args = array(
				    'post_type' => 'location',
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
				
				    $nephrologylist = new WP_Query($args) ?>
					<?php while ( $nephrologylist->have_posts() ) : $nephrologylist->the_post(); ?>
                            <div class="adc-list-excerpt">
                            <div class="adc-list-excerpt-img">
                            <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
  								echo get_the_post_thumbnail($post->ID,array(100,100, true), array('class' => 'excerpt-thumb') );
								} elseif (get_first_image($post->ID) != '')
   									echo get_first_image($post->ID);
								 else { ?>
									<img src="<?php bloginfo('stylesheet_directory'); ?>/images/ADC-site-logo.jpg" width="100" height="100" alt="<?php the_title(); ?>" class="excerpt-thumb" />
							<?php } ?>
                            </div><!--.adc-list-excerpt-img-->
                            <div class="adc-list-excerpt-info">
							<?php echo '<h4>'; ?>
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<?php the_title(); ?></a>
							<?php echo '</h4>'; ?>
                            <ul>
	                         <?php echo '<li>' . get_post_meta($post->ID, 'ecpt_address', true) . '</li>'; 
							 echo '<li>' . get_post_meta($post->ID, 'ecpt_phone', true) . '</li>';?>
                             </ul>
                         </div><!-- end .adc-list-excerpt-->
                      </div><!-- end .adc-list-excerpt-info-->
				<?php endwhile;
      

					// Reset Post Data
					wp_reset_query();
					?>
                </section><!-- .adc-service-col-2 -->
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar( 'location' ); ?>
<?php get_footer(); ?>