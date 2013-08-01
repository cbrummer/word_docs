<?php 
/**
 * Template Name: Landing - Custom
 * ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
 
// Force layout on Landing Pages
add_filter('genesis_pre_get_option_site_layout', 'landing_page_layout');
function landing_page_layout($layout) {
if ( 'landing' == get_post_type() )
$layout = 'full-width-content';
return $layout;
}
// Remove Header
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_header_markup_close', 15);
remove_action('genesis_header', 'genesis_do_header');
// Remove Navigation
remove_action('genesis_before_header', 'news_do_topnav');
remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');
remove_action('genesis_after_header', 'custom_do_subnav');
// Remove Title
remove_action('genesis_post_title', 'genesis_do_post_title');
remove_theme_support('genesis-post-format-images');
// Remove Info Boxes
remove_action('genesis_after_loop', 'include_info_boxes', 1);
remove_action('genesis_after_loop', 'genesis_do_author_box_single', 9);
// Remove Breadcrumbs
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
// Remove Bottom Sidebars
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');
// Remove Post Info
remove_action('genesis_before_post_content', 'genesis_post_info');
// Remove Post Meta
remove_action('genesis_after_post_content', 'genesis_post_meta');
// Remove SubNAV
remove_action('genesis_before_header', 'genesis_do_subnav');
remove_action('genesis_before_header', 'custom_do_subnav');
// Remove Breadcrumbs
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
// Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
genesis();