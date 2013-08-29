<?php
/**
 * This file handles the search results page.
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

add_action( 'genesis_before_loop', 'genesis_do_search_title' );
/**
 * Echo the title with the search term.
 *
 * @since 1.9.0
 */

function genesis_do_search_title() {

	$title = sprintf( '<h1 class="archive-title">%s %s</h1>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'adc-twenty-thirteen' ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

}
remove_action( 'genesis_after_post', 'adc_related_posts', 15 );

genesis();