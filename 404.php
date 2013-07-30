<?php
/**
 * Handles display of 404 page.
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/** Remove default loop **/
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() { ?>

	<div class="post hentry">

		<h1 class="entry-title"><?php _e( 'Shhhhhhh. Looks like someone fell asleep....', 'adc_twenty_thirteen' ); ?></h1>
		<div class="entry-content">
        	<div class="alignright"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/404-sleeping-boy.jpg" alt="Sleeping boy" />
</div>
			<p><?php printf( __( 'We couldn\'t find the page you were looking for. Chances are, it was us, not you. But just to be on the safe side, would you mind checking the URL? There might be a typo. If there isn\'t, you could try searching our website for the content you were looking for: ', 'adc_twenty_thirteen' ), home_url() ); ?></p>
            <?php get_search_form(); ?>
            <p><?php printf( __( 'You can also try returning back to our <a href="%s">homepage</a> and see if you can find what you are looking for.', 'adc_twenty_thirteen' ), home_url() ); ?></p>

			<p><?php printf( __( 'If you would be so kind, would you tell us about this error so that we can fix it?', 'adc_twenty_thirteen' ), home_url() ); ?></p>
			<p><?php gravity_form(9, true, true, false, '', false); ?></p>
		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

genesis();
