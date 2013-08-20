<?php
/*
/**
 * Functions for ADC Twenty Thirteen
 *
 * @package      adc-twenty-thirteen
 * @since        1.0.0
 * @link         http://www.adclinic.com
 * @author       Cindy Brummer <cindybrummer@standardbeagle.com. cbrummer@adclinic.com>
 * @copyright    Copyright (c) 2013, Cindy Brummer
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Theme Setup
 * @since 1.0.0
 *
 * This setup function attaches all of the site-wide functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */
 add_action('genesis_setup','child_theme_setup', 15);
 function child_theme_setup() {
	// ** Backend **	

	// Image Sizes
	add_image_size( 'adc_related_post_thumb', 100, 100, true );
	add_image_size( 'adc_sidebar_thumb', 120, 120, true );
	add_image_size( 'adc_excerpt_thumb', 150, 150, true); //Thumbnails for excerpts
	add_image_size( 'adc_portrait_thumb', 250, 250, true ); // Doctor thumbs
	add_image_size( 'adc_portrait_thumb', 250, 325 ); // Soft proportions
	add_image_size( 'adc_post_thumb', 500, 9999 ); // Unlimited Height Mode
	add_image_size( 'adc_singlepost_thumb', 590, 9999 ); // Unlimited Height Mode
	add_image_size( 'adc_slider', 750, 450, true );
	// Add Viewport meta tag for mobile browsers (requires Genesis 2.0)
	add_theme_support( 'genesis-responsive-viewport' ); 
	// Integrate WooCommerce plugin with genesis theme**/
	add_theme_support( 'genesis-connect-woocommerce' );
	// Structural Wraps
	add_theme_support( 
		'genesis-structural-wraps', 
		array( 
			'header', 
			'nav', 
			'subnav', 
			'inner', 
			'footer-widgets', 
			'footer' 
		) 
	);	
	/*** Add support for more post formats **/
	add_theme_support('post-formats', array('aside','audio','chat','gallery','image','link','video'));

	//Menus
	// Remove Default Custom Menu support
	remove_theme_support ( 'genesis-menus' );
	//Add Custom Menus
	add_theme_support( 
		'genesis-menus', 
		array( 
			'primary' => 'Primary Navigation Menu', 
			'secondary' => 'Secondary Navigation Menu',
			'secondary' => __( 'Secondary Menu (Below the Header)'),
			'mobile' => __( 'Mobile Menu (Combined Global and secondary on mobile devices)'),
			'submenu-1' => __( 'About SubMenu (Vertical side nav)'),
			'submenu-2' => __( 'Careers SubMenu (Vertical side nav)'),
			'submenu-3' => __( 'Contact SubMenu (Vertical side nav)'),
			'submenu-4' => __( 'Community/Outreach SubMenu (Vertical side nav)'),
			'submenu-5' => __( 'Doctors SubMenu (Vertical side nav)'),
			'submenu-6' => __( 'Locations SubMenu (Vertical side nav)'),
			'submenu-7' => __( 'Specialties SubMenu (Vertical side nav)'),
			'submenu-8' => __( 'Tools SubMenu (Vertical side nav)'),
			'submenu-9' => __( 'Billing SubMenu (Vertical side nav)'),
			'submenu-10' => __( 'Staff SubMenu (Vertical side nav)'),
			'submenu-11' => __( 'Services SubMenu (Vertical side nav)' ),
			'submenu-12' => __( 'Default SubMenu (Vertical side nav)' ),
			'submenu-13' => __( 'Patient Education SubMenu (Vertical side nav)' ) 
		) 
	);
	add_action( 'init', 'register_shortcodes');
 	// Sidebars
	add_theme_support( 'genesis-footer-widgets', 3 );
	
	/**
	 * Customize text inside of search box and search button text
	 *
	 * @author WPSyntax
	 * @link http://www.wpsyntax.com
	 */
	add_filter('genesis_search_text', 'child_custom_search_text');
	function child_custom_search_text($text) {
		return esc_attr('Search this site...');
	}
	add_filter('genesis_search_button_text', 'child_custom_search_button_text');
	function child_custom_search_button_text($text) {
		return esc_attr('Search');
	}
	
	
	//Post formats
	add_action ('adc_post_formats', 11);
	
	//Page excerpts
	add_post_type_support( 'page', 'excerpt' );
	
	// Remove Unused Page Layouts
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'content-sidebar' );

	// Remove Unused User Settings
	add_filter( 'user_contactmethods', 'adc_contactmethods' );
	remove_action( 'show_user_profile', 'genesis_user_options_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
	remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
	remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );

	// Setup Theme Settings
	include_once( CHILD_DIR . '/lib/functions/child-theme-settings.php' );
	include_once( CHILD_DIR . '/lib/functions/content-display-functions.php');
	include_once( CHILD_DIR . '/lib/functions/custom-menus.php');
	include_once( CHILD_DIR . '/lib/functions/sidebars.php');
	include_once( CHILD_DIR . '/lib/functions/sidebar-display.php');
	// Include admin customizations
	include_once( CHILD_DIR . '/lib/functions/admin-display-functions.php');
	
	// Remove Genesis Widgets
	add_action( 'widgets_init', 'adc_remove_genesis_widgets', 20 );

	// ** Frontend **		

	// Remove Edit link
	add_filter( 'genesis_edit_post_link', '__return_false' );

	// Responsive Meta Tag
	add_action( 'genesis_meta', 'adc_viewport_meta_tag' );

	// Footer
	add_filter( 'genesis_footer_backtotop_text', 'adc_footer_backtotop_text' );
	add_filter( 'genesis_footer_creds_text', 'adc_footer_creds_text' );
 }
/**************************************************************************
/ ** Backend Functions ** /
***************************************************************************/
/**
 * Customize Contact Methods
 * This filter sets new contact fields under the user profiles
 * It removes the unused YIM, AIM and JABBER and adds Twitter username, ADC extension and alternative phone number
 * @since 1.0.0
 *
 * @author Bill Erickson
 * @link http://sillybean.net/2010/01/creating-a-user-directory-part-1-changing-user-contact-fields/
 *
 * @param array $contactmethods
 * @return array
 */
function adc_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );

	$contactmethods['twitter'] = 'Twitter Handle';
  	$contactmethods['extension'] = 'ADC Extension';
  	$contactmethods['phone'] = 'Alternative Phone Number';

	return $contactmethods;
}
/**************************************************************************
/ ** Frontend Functions ** /
***************************************************************************/
/**
 * Viewport Meta Tag for Mobile Browsers
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/responsive-meta-tag
 */
function adc_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}
/** Include search box for mobile display**/

add_action( 'genesis_before', 'adc_include_search', 11 );
	function adc_include_search() {
		echo '<div class="adc-mobile-search search">';
		get_search_form();
		echo '</div>';
}
/**
 * Footer 
 *
 */
 function adc_footer_backtotop_text($backtotop) {
    $backtotop = 'The Austin Diagnostic Clinic &middot; Copyright &copy; ' . date( 'Y' ) . '<br /> Call 512-901-1111 or Toll Free 800-925-8899 &middot; Austin, Texas <br /> [footer_backtotop text="Go to Top"]';
    return '<div id="one-half first">' . $backtotop. '</div>';
}
 
function adc_footer_creds_text() {
	echo '<div id="footer-right">' . wpautop( genesis_get_option( 'footer-right', 'child-settings' ) ) . '</div>';
}

//This filter adds a new default avatar for users. It's a tree avatar.
	function new_avatar($avatar_defaults) {
		$new_avatar = get_stylesheet_directory_uri() . '/images/ADC-avatar.png';
		$avatar_defaults[$new_avatar] = "ADC";
		$new_avatar = get_stylesheet_directory_uri() . '/images/tree-default-avatar.png';
    	$avatar_defaults[$new_avatar] = "Tree";
		return $avatar_defaults;
	}
	add_filter( 'avatar_defaults', 'new_avatar' );

//Display post thumbnail in Edit Post and Page Overview
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
// for post and page
add_theme_support('post-thumbnails', array( 'post', 'page', 'biography', 'directory', 'job', 'location', 'service', 'specialty') );
function fb_AddThumbColumn($cols) {
	$cols['thumbnail'] = __('Thumbnail');
	return $cols;
}

function fb_AddThumbValue($column_name, $post_id) {
    $width = (int) 35;
    $height = (int) 35;
    if ( 'thumbnail' == $column_name ) {
        // thumbnail of WP 2.9
        $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

        // image from gallery
        $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );

        if ($thumbnail_id)
            $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
        elseif ($attachments) {
            foreach ( $attachments as $attachment_id => $attachment ) {
            $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
        }
    }
	if ( isset($thumb) && $thumb ) { echo $thumb; }
	else { echo __('None'); }
	}
}

// for posts
add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );

// for pages
add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
} 
 /*--------------------------------------------------------------------------------*/
/*Redirect term archives to posts
/*--------------------------------------------------------------------------------*/	
//Source: http://justintadlock.com/archives/2010/08/20/linking-terms-to-a-specific-post
add_action( 'template_redirect', 'adc_redirect_term_to_post' );

function adc_redirect_term_to_post() {
            global $wp_query;
            if ( is_tax() ) {
                        $term = $wp_query->get_queried_object();
                        if ( 'cliniclocation' == $term->taxonomy ) {
                                    $post_id = adc_get_post_id_by_slug( $term->slug, 'wpseo_locations' );
                                    if ( !empty( $post_id ) )
                                                wp_redirect( get_permalink( $post_id ), 301 );
                        } elseif ( 'medicalservice' == $term->taxonomy ) {
                                    $post_id = adc_get_post_id_by_slug( $term->slug, 'specialty' );
                                    if ( !empty( $post_id ) )
                                                wp_redirect( get_permalink( $post_id ), 301 );
                                    $post_id = adc_get_post_id_by_slug( $term->slug, 'service' );
                                    if ( !empty( $post_id ) )
                                                wp_redirect( get_permalink( $post_id ), 301 );
                        }
            }
}
function adc_get_post_id_by_slug( $slug, $post_type ) {
	global $wpdb;

	$slug = rawurlencode( urldecode( $slug ) );
	$slug = sanitize_title( basename( $slug ) );

	$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = %s", $slug, $post_type ) );

	if ( is_array( $post_id ) )
		return $post_id[0];
	elseif ( !empty( $post_id ) );
		return $post_id;

	return false;
}

/* Conditional function to check if post belongs to term in a custom taxonomy.
 * @param    tax        string                taxonomy to which the term belons
 * @param    term    int|string|array    attributes of shortcode
 * @param    _post    int                    post id to be checked
 * @return             BOOL                True if term is matched, false otherwise
 Source: http://alex.leonard.ie/2011/06/30/wordpress-check-if-post-is-in-custom-taxonomy/
*/	
function pa_in_taxonomy($tax, $term, $_post = NULL) {
// if neither tax nor term are specified, return false
if ( !$tax || !$term ) { return FALSE; }
// if post parameter is given, get it, otherwise use $GLOBALS to get post
if ( $_post ) {
$_post = get_post( $_post );
} else {
$_post =& $GLOBALS['post'];
}
// if no post return false
if ( !$_post ) { return FALSE; }
// check whether post matches term belongin to tax
$return = is_object_in_term( $_post->ID, $tax, $term );
// if error returned, then return false
if ( is_wp_error( $return ) ) { return FALSE; }
return $return;
}

//Check if page is parent or child or grandchild
// Source: http://codex.wordpress.org/Conditional_Tags
function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;               // load details about this page
    if ( is_page($pid) )
        return true;            // we're at the page or at a sub page

    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if( is_page() && $ancestor == $pid ) {
            return true;
        }
    }

    return false;  // we arn't at the page, and the page is not an ancestor
}
//Exclude some terms from term list
function adc_get_the_term_list( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array() ) {
	$terms = get_the_terms( $id, $taxonomy );

	if ( is_wp_error( $terms ) )
		return $terms;

	if ( empty( $terms ) )
		return false;

	foreach ( $terms as $term ) {

		if(!in_array($term->term_id,$exclude)) {
			$link = get_term_link( $term, $taxonomy );
			if ( is_wp_error( $link ) )
				return $link;
			$term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
		}
	}

	$term_links = apply_filters( "term_links-$taxonomy", $term_links );

	return $before . join( $sep, $term_links ) . $after;
}
//Redirect archives page to a page
function adc_archive_redirect(){
	if( is_post_type_archive ('biography')) {
		$pagelink = get_page_link (17);
		header("Location: $pagelink" , TRUE , 301);
	}	
	if( is_post_type_archive ('specialty') || is_post_type_archive( 'service' ) ) {
		$pagelink = get_page_link (19);
		header("Location: $pagelink" , TRUE , 301);
	}
	if(is_category( 'health-articles' )) {
		$pagelink=get_page_link (9449);
		header("Location: $pagelink",TRUE,301);
	}
	if(is_category( 'clinic-news' )) {
		$pagelink=get_page_link (9444);
		header("Location: $pagelink",TRUE,301);
	}
	if(is_category( 'patient-education' )) {
		$pagelink=get_page_link (9447);
		header("Location: $pagelink",TRUE,301);
	}			
}
add_action( 'genesis_header', 'adc_archive_redirect' );
/************************************************************
 /* SCRIPTS
*************************************************************/
add_action( 'wp_enqueue_scripts', 'script_managment', 100);
	/**
	 * Change the location of jQuery to Google CDN.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function script_managment() {
		  wp_deregister_script( 'jquery' );
		  wp_deregister_script( 'jquery-ui' );
		  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' );
		  wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array( 'jquery' ), '4.0', false );
} 

	// Add a style sheet for icon fonts
add_action( 'wp_enqueue_scripts', 'adc_add_style_sheet' );
	function adc_add_style_sheet() {
		wp_enqueue_style( 'pictonic', get_stylesheet_directory_uri() . '/lib/pictonic/css/pictonic.css', array(), '1.0' );	
}
 
// Add scripts for icon fonts, add this, toggle, tabs, responsive navigation
add_action( 'genesis_meta', 'adc_load_javascript_files' );
	function adc_load_javascript_files() {
		$suffix = ( WP_DEBUG || WP_SCRIPT_DEBUG ) ? '.js' : '.min.js';
		wp_register_script( 'selectnav.min', get_bloginfo('stylesheet_directory') . '/lib/js/selectnav/selectnav.min.js' , array(), null, true ); 
		wp_enqueue_script( 'selectnav.min' );
		wp_register_script( 'selectnav', get_bloginfo('stylesheet_directory') . '/lib/js/selectnav/selectnav.js' , array(), null, true ); 
		wp_enqueue_script( 'selectnav' );		
		wp_register_script( 'respond.min', get_bloginfo('stylesheet_directory') . '/lib/js/respond/respond.min.js' , array(), null, true ); 
		wp_enqueue_script( 'respond.min' );
		wp_register_script( 'adc-icon-fonts', get_bloginfo('stylesheet_directory').'/lib/pictonic/js/pictonic.min.js' , array(), null, true );
		wp_enqueue_script ( 'adc-icon-fonts' );
		wp_register_script( 'adc-add-this', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fc273066d9aa72e' , array(), null, true ); 
		wp_enqueue_script( 'adc-add-this' );
		wp_register_script( 'adc-toggle', get_bloginfo('stylesheet_directory') . '/lib/js/adc-toggle.js', array( 'jquery' ), '2012-04-03', true ); 
		if ( is_page( '2599' )  ) {
			wp_enqueue_script('adc-toggle');
		}
		wp_register_script( 'jquery.easytabs', get_bloginfo('stylesheet_directory').'/lib/js/jquery.easytabs.js', array( 'jquery' ), '2013-05-30', true );
		wp_register_script( 'jquery.bbq.min', get_bloginfo('stylesheet_directory').'/lib/js/jquery.bbq.min.js', array( 'jquery' ), '2013-05-30', true);
		if ( is_home () ){
			wp_enqueue_script( 'jquery.bbq.min' );
			wp_enqueue_script( 'jquery.easytabs' );
		}
// Register Isotope, so it can be called anytime
// Prefix everything!
		wp_register_script( 'adc-isotope', get_bloginfo('stylesheet_directory') . '/lib/js/isotope/jquery.isotope' . $suffix, array( 'jquery' ), '1.5.21', true );
  
// Register Isotope Parameters, so it can be called anytime
// Create minified isotope-parameters version at http://jscompress.com
// isotope-parameters file named: isotope-parameters.min.js
		wp_register_script( 'adc-isotope-common', get_bloginfo('stylesheet_directory') . '/lib/js/adc-isotope-common.js', array( 'adc-isotope' ), '1.5.21', true );
		wp_register_script( 'adc-isotope-parameters', get_bloginfo('stylesheet_directory') . '/lib/js/adc-isotope-parameters.js', array( 'adc-isotope', 'adc-isotope-common', 'jquery.bbq.min' ), '1.5.21', true );
		wp_register_script( 'adc-isotope-parameters-2', get_bloginfo('stylesheet_directory') . '/lib/js/adc-isotope-parameters-2.js', array( 'adc-isotope', 'adc-isotope-common', 'jquery.bbq.min' ), '1.5.21', true );
		if ( is_page ('doctors') ){
			wp_enqueue_script('adc-isotope');
			wp_enqueue_script('adc-isotope-common');
			wp_enqueue_script('jquery.bbq.min');
			wp_enqueue_script('adc-isotope-parameters');
		}
		
		if ( is_page ('medical-services') ) {
			wp_enqueue_script('adc-isotope');
			wp_enqueue_script('adc-isotope-common');
			wp_enqueue_script('jquery.bbq.min');
			wp_enqueue_script('adc-isotope-parameters-2');
		}
}
// Enqueue Gravity Forms scripts in header
//add_action('genesis_header', 'gforms_add_in_header');
//	function gforms_add_in_header () {
//		gravity_form_enqueue_scripts(12, false);
//	}


/************************************************************
//Load scripts right before opening body tag
*************************************************************/
/**Polyfill responsiveness to older browsers
	add_action( 'genesis_after_footer', 'adc_add_respond' );
	function adc_add_respond() {
		echo '<script>jQuery( function() { respond.min; });</script>';
	}
**/
/************************************************************
//Load scripts after footer
*************************************************************/
//Mobile menu select
add_action( 'genesis_before', 'adc_add_selectnav', 2 );
	function adc_add_selectnav() {
		echo '<script>jQuery( function() { selectnav("menu-mobile", { 
			label: " -- Click here for Navigation -- "
			}); 
		});</script>';
	}
add_action( 'genesis_after', 'adc_add_isotope_parameters' );
	function adc_add_isotope_parameters() {
		if ( is_page ('doctors') || is_page ('medical-services') ){
			wp_enqueue_script('adc-isotope-parameters');
		}
	}