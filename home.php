<?php 
/**
 * Template: Home
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


remove_action( 'genesis_loop', 'genesis_do_loop' ); // Remove default loop
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' ); // Set homepage width to FULL
add_action( 'genesis_loop', 'child_home_loop_helper' ); // Execute custom child loop
/**
 * Remove default loop. Execute child loop instead.
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function child_home_loop_helper() { ?>
<div id="home-top-bg">
	<div id="home-content-top">
 
		<div class="home-content-top-left">
			<?php if (!dynamic_sidebar('Home Top Left')) : ?>
			<div class="widget">
				<h4><?php _e("Home Top Left", 'genesis'); ?></h4>
				<p><?php _e("This is a widgeted area which is called Home Top Left.", 'genesis'); ?></p>
 
			</div>
			<?php endif; ?>
		</div><!-- end .home-content-top-left -->
 
		<div class="home-content-top-right">
			<?php if (!dynamic_sidebar('Home Top Right')) : ?>
			<div class="widget">
 
			</div>
			<?php endif; ?> </div><!-- end .home-content-top-right -->
	</div><!-- end #home-content-top -->
</div><!-- end #home-top-bg -->
 
<div id="home-middle-bg">
	<div id="home-middle">
 
		<div class="home-middle-1"> <?php if (!dynamic_sidebar('Home Middle #1')) : ?>
			<div class="widget">
				<h4><?php _e("Home Middle #1 Widget", 'genesis'); ?></h4>
				<p><?php _e("This is a widgeted area Home Middle #1.", 'genesis'); ?></p>
			</div>
			<?php endif; ?>
		</div><!-- end .home-middle-1 -->
 
		<div class="home-middle-2">
			<?php if (!dynamic_sidebar('Home Middle #2')) : ?>
			<div class="widget">
				<h4><?php _e("Home Middle #2 Widget", 'genesis'); ?></h4>
				<p><?php _e("This is a widgeted area Home Middle #2.", 'genesis'); ?></p>
			</div>
			<?php endif; ?>
		</div><!-- end .home-middle-2 -->

</div><!-- end #home-middle-bg --> 

<?php }




genesis(); 


