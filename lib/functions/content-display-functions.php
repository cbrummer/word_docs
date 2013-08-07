<?php
/**
 * Functions for ADC Twenty Thirteen Content Display
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
 
/************************************************************
 /*Template display functions
*************************************************************/ 
/** Move primary nav menu */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );
/** Move secondary nav menu */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );
// ** Display thumbnail - featured image, first image or default ** //

function adc_display_post_thumbnail() {
if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
		echo get_the_post_thumbnail($post->ID,array(150,150, true), array('class' => 'excerpt-thumb') );
		} elseif (get_first_image($post->ID) != '')
			echo get_first_image($post->ID);
		 else { ?>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/ADC-site-logo.jpg" alt="<?php the_title(); ?>" class="alignleft" />
<?php }
}
// Replace header hook to include logo 
remove_action( 'genesis_header', 'genesis_do_header' ); 
add_action( 'genesis_header', 'genesis_do_new_header' ); 
function genesis_do_new_header() { 
    echo '<div id="title-area"><img class="adc-logo" src="' . get_stylesheet_directory_uri() . '/images/ADClogo_90.png" alt="The Austin Diagnostic Clinic" />'; 
    do_action( 'genesis_site_title' ); 
    do_action( 'genesis_site_description' ); 
    echo  '</div><!-- end #title-area -->' ; 
    if ( is_active_sidebar( 'header-right' ) || has_action( 'genesis_header_right' ) ) { 
        echo '<div class="widget-area">'; 
        do_action( 'genesis_header_right' ); 
        dynamic_sidebar( 'header-right' ); 
        echo '</div><!-- end .widget-area -->'; 
    } 
} 
// ** Execute shortcodes in a widget ** //
add_filter('widget_text', 'do_shortcode');

/** Force layouts on templates */
add_filter( 'genesis_pre_get_option_site_layout', 'child_do_layout' );
function child_do_layout( $opt ) {
    if ( is_single() ) { // Modify the conditions to apply the layout to here
        $opt = 'sidebar-content-sidebar'; // You can change this to any Genesis layout
        return $opt;
    } elseif ( is_page() ) {
		$opt = 'sidebar-content';
		return $opt;
	}

}

//Home Page tabs
add_action( 'genesis_after_footer', 'adc_add_easytabs' );
	function adc_add_easytabs() {
		if ( is_home () ){
			echo '<script>jQuery( function() { jQuery(".tab-container").easytabs() });</script>';	
		}
	}

/**
 * Grid Loop Pagination
 * Returns false if not grid loop.
 * Returns an array describing pagination if is grid loop
 *
 * @author Bill Erickson 
 * @link http://www.billerickson.net/a-better-and-easier-grid-loop/ 
 *
 * @param object $query 
 * @return bool is grid loop (true) or not (false) 
 */
function adc_grid_loop_pagination( $query = false ) {
 
	// If no query is specified, grab the main query
	global $wp_query;
	if( !isset( $query ) || empty( $query ) || !is_object( $query ) )
		$query = $wp_query;
		
	// Sections of site that should use grid loop	
	if( ! ( $query->is_archive() ) )
		return false;
		
	// Specify pagination
	return array(
		'features_on_front' => 5,
		'teasers_on_front' => 6,
		'features_inside' => 0,
		'teasers_inside' => 12,
	);
}
 
/**
 * Grid Loop Query Arguments
 *
 * @author Bill Erickson 
 * @link http://www.billerickson.net/a-better-and-easier-grid-loop/ 
 *
 * @param object $query 
 * @return null 
 */
function adc_grid_loop_query_args( $query ) {
	$grid_args = adc_grid_loop_pagination( $query );
	if( $query->is_main_query() && !is_admin() && $grid_args ) {
 
		// First Page
		$page = $query->query_vars['paged'];
		if( ! $page ) {
			$query->set( 'posts_per_page', ( $grid_args['features_on_front'] + $grid_args['teasers_on_front'] ) );
			
		// Other Pages
		} else {
			$query->set( 'posts_per_page', ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) );
			$query->set( 'offset', ( $grid_args['features_on_front'] + $grid_args['teasers_on_front'] ) + ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) * ( $page - 2 ) );
			// Offset is posts on first page + posts on internal pages * ( current page - 2 )
		}
 
	}
}
add_action( 'pre_get_posts', 'adc_grid_loop_query_args' );
 /*
 * Grid Loop Post Classes
 *
 * @author Bill Erickson 
 * @link http://www.billerickson.net/a-better-and-easier-grid-loop/ 
 *
 * @param array $classes 
 * @return array $classes 
 */
function adc_grid_loop_post_classes( $classes ) {
	global $wp_query;
	$grid_args = adc_grid_loop_pagination();
	if( ! $grid_args )
		return $classes;
		
	// First Page Classes
	if( ! $wp_query->query_vars['paged'] ) {
	
		// Features
		if( $wp_query->current_post < $grid_args['features_on_front'] ) {
			$classes[] = 'feature';
		
		// Teasers
		} else {
			$classes[] = '.one-half';
			if( 0 == ( $wp_query->current_post - $grid_args['features_on_front'] ) || 0 == ( $wp_query->current_post - $grid_args['features_on_front'] ) % 3 )
				$classes[] = 'first';
		}
		
	// Inner Pages
	} else {
 
		// Features
		if( $wp_query->current_post < $grid_args['features_inside'] ) {
			$classes[] = 'feature';
		
		// Teasers
		} else {
			$classes[] = '.one-half';
			if( 0 == ( $wp_query->current_post - $grid_args['features_inside'] ) || 0 == ( $wp_query->current_post - $grid_args['features_inside'] ) % 3 )
				$classes[] = 'first';
		}
	
	}
	
	return $classes;
}
add_filter( 'post_class', 'adc_grid_loop_post_classes' );
add_filter( 'pre_get_posts', 'adc_archive_query' );
/**
 * Archive Query
 *
 * Sets all archives to 27 per page
 * @since 1.0.0
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 *
 * @param object $query
 */
function adc_archive_query( $query ) {
	if( $query->is_main_query() && $query->is_archive() ) {
		$query->set( 'posts_per_page', 27 );
	}
}
/**
 * Grid Image Sizes 
 *
 */
function adc_grid_image_sizes() {
	add_image_size( 'adc_grid', 175, 120, true );
	add_image_size( 'adc_feature', 570, 333, true );
}
add_action( 'genesis_setup', 'adc_grid_image_sizes', 20 );
 
/**
 * Grid Loop Featured Image
 *
 * @param string image size 
 * @return string 
 */
function adc_grid_loop_image( $image_size ) {
	global $wp_query;
	$grid_args = adc_grid_loop_pagination();
	if( ! $grid_args )
		return $image_size;
		
	// Feature
	if( ( ! $wp_query->query_vars['paged'] && $wp_query->current_post < $grid_args['features_on_front'] ) || ( $wp_query->query_vars['paged'] && $wp_query->current_post < $grid_args['features_inside'] ) )
		$image_size = 'be_feature';
		
	if( ( ! $wp_query->query_vars['paged'] && $wp_query->current_post > ( $grid_args['features_on_front'] - 1 ) ) || ( $wp_query->query_vars['paged'] && $wp_query->current_post > ( $grid_args['features_inside'] - 1 ) ) )
		$image_size = 'be_grid';
		
	return $image_size;
}
add_filter( 'genesis_pre_get_option_image_size', 'adc_grid_loop_image' );
 
/**
 * Fix Posts Nav
 *
 * The posts navigation uses the current posts-per-page to 
 * calculate how many pages there are. If your homepage
 * displays a different number than inner pages, there
 * will be more pages listed on the homepage. This fixes it.
 *
 */
function adc_fix_posts_nav() {
	
	if( get_query_var( 'paged' ) )
		return;
		
	global $wp_query;
	$grid_args = adc_grid_loop_pagination();
	if( ! $grid_args )
		return;
 
	$max = ceil ( ( $wp_query->found_posts - $grid_args['features_on_front'] - $grid_args['teasers_on_front'] ) / ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) ) + 1;
	$wp_query->max_num_pages = $max;
	
}
add_filter( 'genesis_after_endwhile', 'adc_fix_posts_nav', 5 );

/**
 * Gets the custom field value if available and places it in a defined pattern.
 * Place %value% where the custom field value should be if custom field is returned.
 *
 * @uses genesis_get_custom_field()
 * @param string $field the id of the custom field to check/retrieve.
 * @param string $wrap HTML to return if custom field is returned.
 * @param boolean $echo default false. echo wraped field value if available and set to true.
 * @returns string/boolean the custom field/wrap output or false if nothing
 *
 * Source: http://designsbynickthegeek.com/tutorials/how-i-make-custom-fields-easier
*/
function adc_get_custom_field( $field, $wrap = '%value%', $echo = false ){
 
    $custom_wrap = false;
 
    if( $value = genesis_get_custom_field( $field ) )
        $custom_wrap = str_replace( '%value%', $value, $wrap );
 
        if( $echo && $custom_wrap )
            echo $custom_wrap;
 
        return $custom_wrap;
 
}
/************************************************************
 /* LOOP
*************************************************************/ 
/* This adds a function to get custom posts related by taxonomy
 * Note: The function assumes only one term for per post in this taxonomy
 * @link http://stackoverflow.com/questions/12257090/how-to-display-custom-posts-from-a-related-custom-taxonomy
*/	
function get_posts_related_by_taxonomy($post_id,$taxonomy,$args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id, $taxonomy);
  if (count($terms)) {
	  
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, // The assumes the post types match
      'post__in' => $post_ids,
      'post__not_in' => $post->ID,
	  'posts_per_page' => -1,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug,
	  'orderby' => 'title',
	  'order' => 'ASC',
    ));
    $query = new WP_Query($args);
  }
  return $query;
}

/* This adds a function to get blog posts related by taxonomy
 * Note: The function assumes only one term for per post in this taxonomy
*/	
function get_blog_posts_related_by_taxonomy($post_id,$taxonomy,$args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id,$taxonomy);
  if (count($terms)) {
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, // The assumes the post types match
      'post__in' => $post_ids,
      'post__not_in' => $post->ID,
	  'posts_per_page' => -1,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug
    ));
    $query = new WP_Query($args);
  }
  return $query;
}
/* This adds a function to get biography posts related by taxonomy
 * Note: The function assumes only one term for per post in this taxonomy
*/	
function get_provider_posts_related_by_taxonomy($post_id,$taxonomy,$args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id,$taxonomy);
  if (count($terms)) {
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, // The assumes the post types match
      'post__in' => $post_ids,
      'post__not_in' => $post->ID,
	  'posts_per_page' => -1,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug,
	  'meta_key' => 'ecpt_surname',
      'orderby' => 'meta_value',
      'order' => 'ASC'
    ));
    $query = new WP_Query($args);
  }
  return $query;
}
// This function displays a post from the news taxonomy tagged "staff heroes"
function adc_leader_story() {
 $adcleader = new WP_Query( 
 		array ( 
			'posts_per_page' => '1', 
			//'orderby' => 'rand',
			'orderby' => 'date', 
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'news',
					'field' => 'slug',
					'terms' => 'staff-heroes' 
				)
			)
			)
		);
			   echo "<ul>";
				while ( $adcleader->have_posts() ) : $adcleader->the_post();
					echo the_post_thumbnail( array(150,150), array('class' => 'excerpt-thumb') );
					echo "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>";
				echo "</ul>";
				endwhile;
            wp_reset_postdata();	
			echo '<ul><li><a href="';
			echo get_tag_link( 679 ); 
			echo '">Read more staff stories</a></li></ul>';
}

//This function checks to see if a provider is a hospitalist and displays the right phone number if not
function adc_check_if_hospitalist() {
	$hospitalist = genesis_get_custom_field('ecpt_hospitalist');
	if( ($hospitalist) ) { //check to see if this doctor is a hospitalist
		echo 'howdy';
	} elseif (pa_in_taxonomy('otherdepartment', 'administration')) {
		echo '<div class="adc-provider-appt"><h3>Information</h3>512-901-1111</div>';
	} else {
		echo '<div class="adc-provider-appt">';
		$providerphone = get_posts_related_by_taxonomy($post->ID,'provider');
		if ($providerphone->have_posts()){
			while ($providerphone->have_posts()): $providerphone->the_post();
				if ( is_singular( 'specialty' ) ) {
					if ( is_single( array( 447, 3342, 3352, 3389, 3130 )) ) {
						echo '<h3>Appointments</h3>' . genesis_get_custom_field('ecpt_secondarylocationappointmentphone');
					} else {
						echo '<h3>Appointments</h3>' . genesis_get_custom_field('ecpt_mainappointmentphone');
					}
				}  elseif ( is_singular( 'service' )) {
					echo '<h3>Appointments</h3>' . genesis_get_custom_field('ecpt_mainphone_2');
				}
			endwhile; 
		} 
		wp_reset_query();
		echo '</div>';
	 } //end check to see if hospitalist
}
// Display Imaging service links
function adc_display_imaging_links(){
	$args = array(
		'post_parent' => 2085,
		'post_type' => 'service',
		'posts_per_page' => -1,
		'orderby' => 'title', 
		'order' => 'ASC'
	); 
	$imagingservices = new WP_Query($args);
	if ($imagingservices->have_posts()){
		$first = true;
			while ($imagingservices->have_posts()): $imagingservices->the_post();
					if ($first == true) { echo '<h4>All Imaging Services</h4><ul class="adc-num-list">';
						$first = false;
					 }
				echo '<li><a href="';
				the_permalink(); 
				echo '" title="';
				printf( esc_attr__( 'Link to %s', 'adc-twenty-thirteen' ),the_title_attribute( 'echo=0' ) ); 
				echo '" rel="bookmark">';
				the_title();
				echo '</a></li>';	
			endwhile;
			echo '</ul>';
			} else { 
		}
 wp_reset_query();
}

//Grid loop post display

/**
 /*EDITING
 */
/*This function adds a shortcode to display child pages from a page
*/
function adc_subpage_peek() {
	global $post;

	//query subpages
	$args = array(
		'post_parent' => $post->ID,
		'post_type' => 'page',
		'post__not_in' => array(7000, 6067),
		'orderby' => 'title', 
		'order' => 'DESC'
	);
	$subpages = new WP_query($args);

	// create output
	if ($subpages->have_posts()) :
		$output = '<ul>';
		while ($subpages->have_posts()) : $subpages->the_post();

			$output .= '<li><h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
						<p>'.get_the_excerpt().'<br />
						<a href="'.get_permalink().'">More Information →</a></p></li>';
		endwhile;
		$output .= '</ul>';
	else :
		$output = '';
	endif;

	// reset the query
	wp_reset_postdata();

	// return something
	return $output;
}
    add_shortcode('adc_subpage_peek', 'adc_subpage_peek');
// SHORTCODES - these functions were working up until July 30, when they stopped
// Display forms list with shortcode
function adc_forms_list() {
	global $post;
	$args = array(
	  'post_type' => 'post',
	  'category__in' => 46,
	  'posts_per_page' => -1,
	  'orderby' => 'name',
	  'order' => 'asc',
	  );
	$attachments = new WP_query($args);
	if ($attachments->have_posts()) :
		$output = '<ul>';
		while ($attachments->have_posts()) : $attachments->the_post();
	    	$output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
	  endwhile;
	  $output .= '</ul>';
	else :
		$output = '';
	endif;

	echo '</ul>';
	wp_reset_query();
	// return something
	return $output;
}
// Display surveys list with shortcode
function adc_surveys_list() {
	global $post;
	$args = array(
	    'cat' => 1039,
		'order' => 'ASC',
		'orderby' => 'title',
		'posts_per_page'=>-1
	  );
	$surveys = new WP_Query($args); 
		$output = '<ul>';
		while($surveys->have_posts()) : $surveys->the_post();
	    	$output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
	  endwhile;
	  $output .= '</ul>';

	echo '</ul>';
	wp_reset_query();
	// return something
	return $output;
}

// Display blogs list with shortcode
function adc_blogs_list( $atts) {
	extract( shortcode_atts( array( 
		'limit' => '-1',  
        'orderby' => 'title', 
	), $atts ) );
	$adcblogs = new WP_Query( array('post_parent'  => 9554, 'posts_per_page' => $limit, 'order' => 'ASC', 'orderby' => $orderby ) );
	if ($adcblogs){
		while($adcblogs->have_posts()) {
			$adcblogs->the_post(); 
			$output .= '<ul>';
	    	$output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			$output .= '</ul>';
		}
	}
	else
	// return something
	return $output;
}
//Register custom shortcodes
function register_shortcodes(){
	add_shortcode('adc_forms_list', 'adc_forms_list');
	add_shortcode('adc_surveys_list', 'adc_surveys_list');
	add_shortcode('adc_blogs', 'adc_blogs_list');
}
/************************************************************/
/*********************** MEDIA *********************
/*************************************************************/ 

//This function calls the first uploaded image of a post	
//Source: http://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
function get_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if(empty($first_img)) {
    $first_img = get_stylesheet_directory_uri() . '/images/ADC-site-logo.jpg';
  }
  return '<img src="' . $first_img . '" class="excerpt-thumb" />';
}

//Get a thumbnail image from a post - 100px
function adc_get_related_post_thumb() {
	if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
  		echo get_the_post_thumbnail($post->ID,array(100,100, true), array('class' => 'excerpt-thumb') );
	} elseif (get_first_image($post->ID) != '')
   		echo get_first_image($post->ID);
	}

//Get a thumbnail image from a post - 150px

function adc_get_excerpt_thumb() {
	if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
  		echo get_the_post_thumbnail($post->ID,array(150,150, true), array('class' => 'excerpt-thumb') );
	} elseif (get_first_image($post->ID) != '')
   		echo get_first_image($post->ID);
	}
//Get a thumbnail image from a post - 269x149px

function adc_get_excerpt_bio_thumb() {
	if (  '' != get_the_post_thumbnail()  ) {
  		echo get_the_post_thumbnail( $post->ID ,array(250, 250, true), array('class' => 'adc_portrait_thumb') );
	} elseif (get_first_image($post->ID) != '')
   		echo get_first_image($post->ID);
	}
//Get a medium featured image from a post
function adc_featured_image_medium() {
	if ( has_post_thumbnail()) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
		the_post_thumbnail('medium');
		echo '</a>';
	}
}
//Video in biography
	// Get the video URL and put it in the $video variable
function adc_display_bio_video() {
	$videoID = genesis_get_custom_field( 'ecpt_videourl' );
	// Check if there is in fact a video URL
	if ($videoID) {
		echo '<div class="video-container">';
		// Echo the embed code via oEmbed
		echo wp_oembed_get( 'http://www.youtube.com/watch?v=' . $videoID ); 
		echo '</div>';
	}
}
//Video for testimonials - show at end of testimonial
function adc_display_video_4() {
	$videosite = genesis_get_custom_field( 'ecpt_videosite_4' );
	$videoid = genesis_get_custom_field( 'ecpt_videoid_4' );
	if (is_singular('testimonial')) {
		if( genesis_get_custom_field( 'ecpt_videoid_4' ) ) {
			if ($videosite == 'YouTube')
			{
				echo '<div class="video-container"><iframe width="560" height="315" src="http://www.youtube.com/embed/'.$videoid.'" frameborder="0" modestbranding="1" showinfo="0" theme="light" allowfullscreen></iframe></div>';
			}
			else if ($videosite == 'Vimeo')
			{
				echo '<div class="video-container"><iframe src="http://player.vimeo.com/video/'.$videoid.'" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
			}
			else{ 
			}
		}
	}
}
//Video on specialty and service pages
// Get the video URL and put it in the $video variable
function adc_display_video_3() {
$videoID = genesis_get_custom_field( 'ecpt_videoid_3');
// Check if there is in fact a video URL
	if ($videoID) {
		echo '<div class="adc-video-container">';
	// Echo the embed code via oEmbed
		$embed_code = wp_oembed_get('http://www.youtube.com/watch?v=' . $videoID, array('width'=>420, 'height'=>236) );
		echo $embed_code;
		echo '</div>';
	} 
	wp_reset_query();
}
// Display video at top of post if present

add_action( 'genesis_before_post_content', 'adc_display_blog_video', 12 );
function adc_display_blog_video() {
	if ( in_category( array( 39,44,50 ) ) && is_singular()) {
    	$videosite = genesis_get_custom_field(  'ecpt_videosite' );
		$videoid = genesis_get_custom_field( 'ecpt_videoid', true);
			if( $videoid ) {
				if ($videosite == 'YouTube')
				{
					echo '<div class="video-container">';
					echo wp_oembed_get( 'http://www.youtube.com/watch?v='.$videoid );
					echo '</div>';
				}
				else if ($videosite == 'Vimeo')
				{
					echo '<div class="video-container">';
					echo '<iframe src="http://player.vimeo.com/video/'.$videoid.'" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
					echo '</div>';
				}
				else if ($videosite == 'KXAN')
				{
					echo '<div class="video-container">';
					echo '<iframe width="560" height="410" src="http://www.youtube.com/embed/'.$videoid.'" frameborder="0" modestbranding="1" showinfo="0" theme="light" allowfullscreen></iframe>';
					echo '</div>';
				}
				else
				{
				}
		
			}
	}
}
// Videos in Sidebar Widgets
// http://www.billerickson.net/?p=4458
	global $wp_embed;
	add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
	add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );
	
//Display video icon on video format posts
function adc_video_post(){
	if ( has_post_format( 'video' )) {
    	$output= '<span class="adc-post-highlight">Video</span>';
		
    }	
	return $output;
}
// Display next HRM event
function adc_next_HRM_event() {
	global $post;
	$all_events = tribe_get_events(array(
		'eventCat'=> '505',
		'eventDisplay'=>'upcoming',
		'posts_per_page'=>'1'
	));
	foreach($all_events as $post) {
	setup_postdata($post);
		echo '<h4 class="adc-event-title"><a href="';
		the_permalink();
		echo '">';
		the_title();
		echo '</a></h4>';
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
			echo '<a href="';
			the_permalink(); 
			echo '">';
			the_post_thumbnail('thumbnail', array('class' => 'alignright') );
			echo '</a><p>';
			echo tribe_get_start_date( $post->ID, true, 'D. M j, Y' );
			echo '</p></div>';
		} else {
			echo '<p>';
			echo tribe_get_start_date( $post->ID, true, 'D. M j, Y' );
			echo '</p>';
		}
		wp_reset_query();
	}
}
/************************************************************/
/*********************** METABOXES *********************
/*************************************************************/ 
//Display appointment phone fields
function adc_display_appointment_phone() {
    if( genesis_get_custom_field( 'ecpt_mainappointmentphone' ) )
		echo '<a href="tel://';
		echo genesis_get_custom_field( 'ecpt_mainappointmentphone' );
		echo '" title="Dial phone number from a mobile device">';
        echo genesis_get_custom_field( 'ecpt_mainappointmentphone' );
		echo '</a>';
}
function adc_second_location_appt_phone() {
    if( genesis_get_custom_field( 'ecpt_secondarylocationappointmentphone' ) )
        echo genesis_get_custom_field( 'ecpt_secondarylocationappointmentphone' );
}
function adc_display_main_phone() {
    if( genesis_get_custom_field( 'ecpt_mainphone_2' ) )
        echo genesis_get_custom_field( 'ecpt_mainphone_2' );
}
function adc_second_location_main_phone() {
    if( genesis_get_custom_field( 'ecpt_secondarylocationphone' ) )
        echo genesis_get_custom_field( 'ecpt_secondarylocationphone' );
}
//Biography information
//Display just the suffix
function adc_display_suffix() {
    if( genesis_get_custom_field( 'ecpt_suffix' ) )
        echo ', ' . genesis_get_custom_field( 'ecpt_suffix' );
}
//Display just the extra suffix
function adc_display_more_suffix() {
    if( genesis_get_custom_field( 'ecpt_othersuffix' ) )
        echo '<p>' . genesis_get_custom_field( 'ecpt_othersuffix' ) . '</p>';
}
//Display both suffix and extra suffix
function adc_display_provider_suffix_all() {
	$suffix = genesis_get_custom_field('ecpt_suffix');
	$moresuffix = genesis_get_custom_field('ecpt_othersuffix');
	if( $moresuffix) {
		echo $suffix;
		echo ', ' . $moresuffix . ' <br />';
	} elseif( $suffix) {
		echo $suffix. ' <br />';
	} else {
	}			
}
//Display accepting new patients
function adc_display_accept_new_patients() {
    if( genesis_get_custom_field( 'ecpt_acceptsnewpatients' ) ){
        echo '<li><span class="icon-oxp-check"></span> Accepting New Patients</li>';
	} else {
	}
}
function adc_display_accept_medicare() {
    if( genesis_get_custom_field( 'ecpt_acceptsmedicare' ) ) {
        echo '<li><span class="icon-oxp-check"></span> Accepts Medicare</li>';
	} else {
	}
}
function adc_display_accept_new_medicare() {
    if( genesis_get_custom_field( 'ecpt_acceptsnewmedicarepatients' ) ) {
        echo '<li><span class="icon-oxp-check"></span> Accepts New Medicare Patients</li>';
	} else {
	}
}
//Does provider speak Spanish?
function adc_provider_spanish() {
    if( genesis_get_custom_field( 'ecpt_spanish' ) && genesis_get_custom_field( 'ecpt_spanishnotes' ) ) {
	echo '<li>Speaks Spanish (' . genesis_get_custom_field( 'ecpt_spanishnotes' ) . ')</li>';
		}elseif ( genesis_get_custom_field( 'ecpt_spanish' ) ){
			echo '<li><span class="icon-oxp-check"></span> Speaks Spanish</li>';	
		} else {
		}
}
//Other languages
function adc_provider_other_language() {
    if( genesis_get_custom_field( 'ecpt_otherlanguages' ) ) {
        echo '<li><span class="icon-oxp-check"></span> Also speaks: ' . genesis_get_custom_field( 'ecpt_otherlanguages' ) . '</li>';
	}
}
//EasyCare notes
function adc_easycare_note() {
	if( genesis_get_custom_field( 'ecpt_easycare' ) ) {
        echo '<p><span class="adc-special-note">EasyCare providers are not available as primary care providers.</span></p>';
	}
}
function adc_easycare_note_page() {
	if( is_single( 'easycare-after-hours' ) ) {
        echo '<p><span class="adc-special-note">EasyCare providers are not available as primary care providers.</span></p>';
	}
}
//Staff information
function adc_staff_info() {
	$department = get_the_term_list( $post->ID, 'medicalservice', '', ' ', '' );
	$otherdepartment = get_the_term_list( $post->ID, 'otherdepartment', '', ' ', '' );
	if( genesis_get_custom_field( 'ecpt_position' ) ) {
        echo genesis_get_custom_field( 'ecpt_position' ) . ', ' . $department . $otherdepartment;
	}
}
function adc_start_date() {
	if( genesis_get_custom_field( 'ecpt_startdate' ) ) {
        echo 'Team member since ' . genesis_get_custom_field( 'ecpt_startdate' );
	}
}
//Locations metabox functions
// Location 1 list
function adc_display_location_1_list(){
	$mainphone = genesis_get_custom_field( 'ecpt_mainphone_2'); 
	$fax = genesis_get_custom_field( 'ecpt_fax_3' );
	$hours = genesis_get_custom_field( 'ecpt_hours' );
	$floor = genesis_get_custom_field( 'ecpt_floor_2' );
	$wing = genesis_get_custom_field( 'ecpt_wing_2');
	 if( $floor) {	
		echo '<li><strong>Floor:</strong> ' . $floor . '</li>';
	 }
	 if( $wing ) {	
		echo '<li><strong>Wing:</strong> ' . $wing . '</li>';
	 }
	 if( ( $mainphone ) ) {	
	 echo '<li><strong>Main Phone:</strong> ';
		adc_display_main_phone();
	 echo '</li>';
	 }
	 if( $fax ) {	
		echo '<li><strong>FAX:</strong> ' . $fax . '</li>';
	 }
	 if( $hours ) {	
		echo '<li><strong>Hours:</strong> ' . $hours . '</li>';
	 }	
}
function adc_display_location_2_list() {
	$apptphone2 = genesis_get_custom_field(  'ecpt_secondarylocationappointmentphone' );
	$mainphone2 = genesis_get_custom_field( 'ecpt_secondarylocationphone' ); 
	$fax2 = genesis_get_custom_field( 'ecpt_secondarylocationfax' );
	$hours2 = genesis_get_custom_field( 'ecpt_secondarylocationhours' );
	 if( $apptphone2 ) {
		echo '<li><strong>Appointments: </strong> ' . $apptphone2 . '</li>';
	}
	 if( $mainphone2 )  {	
		echo '<li><strong>Main line:</strong> ' . $mainphone2 . '</li>';
	 }
	 if( $fax2 ) {	
		echo '<li><strong>FAX:</strong> ' . $fax2 . '</li>';
	 }
	 if( $hours2 ) {	
		echo '<li><strong>Hours:</strong> ' . $hours2 . '</li>';
	 }	
}
function adc_display_location_3_list(){
	$mainphone3 = genesis_get_custom_field( 'ecpt_thirdlocationphone' ); 
	$fax3 = genesis_get_custom_field( 'ecpt_thirdlocationfax' );
	$hours3 = genesis_get_custom_field( 'ecpt_thirdlocationhours' );
	 if( $mainphone3 ) {	
		echo '<li><strong>Main line:</strong> ' . $mainphone3 . '</li>';
	 }
	 if( $fax3 ) {	
		echo '<li><strong>FAX:</strong> ' . $fax3 . '</li>';
	 }
	 if( $hours3 ) {	
		echo '<li><strong>Hours:</strong> ' . $hours3 . '</li>';
	 }	
}
function adc_display_location_4_list(){
	$mainphone4 = genesis_get_custom_field( 'ecpt_fourthlocationphone' ); 
	$fax4 = genesis_get_custom_field( 'ecpt_fourthlocationfax' );
	$hours4 = genesis_get_custom_field( 'ecpt_fourthlocationhours' );
	 if( $mainphone4 ) {	
	 echo '<li><strong>Main line:</strong> ' . $mainphone4 . '</li>';
	 }
	 if( $fax4 ) {	
	 echo '<li><strong>FAX:</strong> ' . $fax4 . '</li>';
	 }
	 if( $hours4 ) {	
	 echo '<li><strong>Hours:</strong> ' . $hours4 . '</li>';
	 }	
}
function adc_display_location_5_list(){
	$mainphone5 = genesis_get_custom_field( 'ecpt_fifthlocationphone' ); 
	$fax5 = genesis_get_custom_field( 'ecpt_fifthlocationfax' );
	$hours5 = genesis_get_custom_field( 'ecpt_fifthlocationhours' );
	 if( $mainphone5 ) {	
	 echo '<li><strong>Main line:</strong> ' . $mainphone5 . '</li>';
	 }
	 if( $fax5 ) {	
	 echo '<li><strong>FAX:</strong> ' . $fax5 . '</li>';
	 }
	 if( $hours5 ) {	
	 echo '<li><strong>Hours:</strong> ' . $hours5 . '</li>';
	 }	
}
//Display insurance meta fields
function adc_display_insurance_notes() {
    if( genesis_get_custom_field( 'ecpt_notes' ) )
        echo genesis_get_custom_field( 'ecpt_notes' );
}
function adc_display_insurance_acceptance() {
    if( genesis_get_custom_field( 'ecpt_acceptance' ) ) {
        echo 'All ADC Providers';
	} elseif ( genesis_get_custom_field( 'ecpt_provider' ) ) {
	echo genesis_get_custom_field( 'ecpt_provider' );
	}
}
function adc_display_insurance_url() {
    if( genesis_get_custom_field( 'ecpt_website' ) )
		$insuranceurl = genesis_get_custom_field( 'ecpt_website' );
        echo '<a href="'. $insuranceurl .'" title="" target="_blank">' . the_title() .' website</a>';
}
//Testimonial excerpts
function adc_display_staff_position() {
    if( genesis_get_custom_field( 'ecpt_position' ) )
		$position = genesis_get_custom_field( 'ecpt_position' );
        echo $position;
}
/***********************************************************/
/**********************Blog/Article Display*****************/
/***********************************************************/
//* Customize the post info function
add_action( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	if (is_single() ) {
		if ( genesis_get_custom_field( 'ecpt_physicianapproval' ) ){
			$articlereview = ' Reviewed by ' . genesis_get_custom_field(  'ecpt_physicianapproval' );
			} 
		$post_info = 'By [post_author_posts_link] [post_date] [post_comments]<br />' . $articlereview ;
		return $post_info;
	}
}
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
//Conditionally remove authorbox
add_action( 'genesis_after_post_content', 'adc_conditional_authorbox', 8 );
/**
 * Remove authorbox from category 20
 *
 * @author Jen Baumann
 * @link http://dreamwhisperdesigns.com/?p=424
 */
function adc_conditional_authorbox(){
	if( ! in_category(array('39', '44')) ){
		remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );
	}
}
//* Customize the author box title
add_filter( 'genesis_author_box_title', 'custom_author_box_title' );
function custom_author_box_title() {
	return '<strong>About the Author</strong>';
}
add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {
	return '100';
}
//Add related posts to bottom of posts
add_action( 'genesis_after_post', 'adc_related_posts', 15 );
/**
 * Outputs related posts with thumbnail
 * Only shows related posts on single posts in Clinic News or Your health life categories
 * 
 * @author Nick the Geek
 * @url http://designsbynickthegeek.com/tutorials/related-posts-genesis
 * @global object $post 
 */
function adc_related_posts() {     
    if ( in_category( array( 39, 44 )) ) {
        global $post;
 
        $count = 0;
        $postIDs = array( $post->ID );
        $related = '';
        $tags = wp_get_post_tags( $post->ID );
        $cats = wp_get_post_categories( $post->ID );         
        if ( $tags ) {            
            foreach ( $tags as $tag ) {                 
                $tagID[] = $tag->term_id;                 
            }             
            $args = array(
                'tag__in'               => $tagID,
                'post__not_in'          => $postIDs,
                'showposts'             => 4,
                'ignore_sticky_posts'   => 1,
                'tax_query'             => array(
                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote'
                                            ),
                                        'operator'  => 'NOT IN'
                    )
                )
            );
            $tag_query = new WP_Query( $args );             
            if ( $tag_query->have_posts() ) {                 
                while ( $tag_query->have_posts() ) {                     
                    $tag_query->the_post(); 
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'adc_related_post_thumb' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/ADC-site-logo.jpg" width="100" height="100" alt="' . get_the_title() . '" />';
 
                    $related .= '<li class="related-thumb"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . get_the_title() . '">' . $img . get_the_title() . '</a></li>';                     
                    $postIDs[] = $post->ID; 
                    $count++;
                }
            }
        } 
        if ( $count <= 3 ) {             
            $catIDs = array( ); 
            foreach ( $cats as $cat ) {                
                if ( 2 == $cat )
                    continue;
                $catIDs[] = $cat;                
            }             
            $showposts = 4 - $count;
             $args = array(
                'category__in'          => $catIDs,
                'post__not_in'          => $postIDs,
                'showposts'             => $showposts,
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'rand',
                'tax_query'             => array(
                                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote' ),
                                        	'operator' => 'NOT IN'
                                    )
                )
            );
 
            $cat_query = new WP_Query( $args );             
            if ( $cat_query->have_posts() ) {                 
                while ( $cat_query->have_posts() ) {                    
                    $cat_query->the_post();
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'adc_related_post_thumb' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/ADC-site-logo.jpg" width="100" height="100" alt="' . get_the_title() . '" />';
                    $related .= '<li class="related-thumb"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to ' . get_the_title() . '">' . $img . get_the_title() . '</a></li>';
                }
            }
        }
        if ( $related ) {           
            printf( '<div class="adc-related-content"><h3 class="related-title">Related Posts</h3><ul>%s</ul></div>', $related );       
        }     
        wp_reset_query();         
    }
}

function output_testimonials($wp_query) {
	// Intro Text (from page content)
	echo '<div class="page hentry entry">';
	echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
	echo '<div class="entry-content">' . get_the_content() ;
	echo '<div class="adc-provider-excerpt .adc-grid-content">';
	if( $wp_query->have_posts() ): 
		while( $wp_query->have_posts() ): $wp_query->the_post(); global $post;
				$classes = 'one-third';
				if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 3 )
					$classes .= ' first';
						echo '<div class="'.  $classes . '">';
							echo '<div class="excerpt-thumb">'. adc_get_excerpt_thumb().'</div>';
							echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
							the_excerpt();	
						echo '</div>';
			endwhile;
			genesis_posts_nav();
		endif;
		wp_reset_query();
	echo '</div><!-- end .adc-provider-excerpt .adc-grid-content -->';
	echo '</div><!-- end .entry-content -->';
	echo '</div><!-- end .page .hentry .entry -->';
}
function output_location_info() {
	$location1 = genesis_get_custom_field( 'ecpt_location1' );
		echo '<h4 class="adc-info-numbers"><a href="';
		echo bloginfo('url') . '/locations/' . sanitize_title( $location1 ) .'/';
		echo '">';
		echo $location1;
		echo '</a></h4>';
		echo '<ul class="adc-num-list">';
		adc_display_location_1_list();
		echo'</ul><!--end location 1 important numbers list-->';
	$location2 = genesis_get_custom_field( 'ecpt_location2' );	
		if( $location2 ) {
			echo '<h4 class="adc-info-numbers"><a href="';
			echo bloginfo('url') . '/locations/' . sanitize_title( $location2 ) . '/';
			echo '">';
			echo $location2;
			echo '</a></h4>';
			echo '<ul class="adc-num-list">';
			adc_display_location_2_list();
			echo '</ul><!--end location 2 important numbers list-->';
		}
	$location3 = genesis_get_custom_field( 'ecpt_location3' );
		if( $location3 ) {
			echo '<h4 class="adc-info-numbers"><a href="';
			echo bloginfo('url') . '/locations/' . sanitize_title( $location3 ) . '/';
			echo '">';
			echo $location3;
			echo '</a></h4>';
			echo '<ul class="adc-num-list">';
			adc_display_location_3_list();
			echo '</ul><!--end location 3 important numbers list-->';
		}
	 $location4 = genesis_get_custom_field( 'ecpt_location4' );
		if( $location4 ) {
			echo '<h4 class="adc-info-numbers"><a href="';
			echo bloginfo('url') . '/locations/' . sanitize_title( $location4 ) . '/';
			echo '">';
			echo $location4;
			echo '</a></h4>';
			echo '<ul class="adc-num-list">';
			adc_display_location_4_list();
			echo '</ul><!--end important numbers list-->';
		}	
	 $location5 = genesis_get_custom_field( 'ecpt_location5' );
		if( $location5 ) {
			echo '<h4 class="adc-info-numbers"><a href="';
			echo bloginfo('url') . '/locations/' . sanitize_title( $location4 ) . '/';
			echo '">';
			echo $location4;
			echo '</a></h4>';
			echo '<ul class="adc-num-list">';
			adc_display_location_5_list();
			echo '</ul><!--end important numbers list-->';
		}	
}
//Show list of patient visit materials EXCEPT those in patient education category 
function output_patient_visit_links(){
	$visitinfo = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
		if ($visitinfo->have_posts()){
			$first = true;
				while ($visitinfo->have_posts()): $visitinfo->the_post();
					if ( in_category( array('instructions', 'patient-forms', 'procedure-preparations', 'resource-materials', 'office-policies', 'patient-surveys') )) {					
					if ($first == true) { 
						echo '<h3>Prepare for your visit</h3><ul class="adc-col-list">';
						$first = false;
					 }
						echo '<li><a href="' ;
						the_permalink();
						echo '">';
						the_title();
						echo '</a></li>';
					}
			endwhile;
		} else { 
			}
		echo '</ul>';
	wp_reset_query();	
}
//Show list of related educational materials EXCEPT those in patient education category
function output_related_education_links(){
	$education = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
	if ($education->have_posts()){
		$first = true;
			while ($education->have_posts()): $education->the_post();
				if ( in_category( 'patient-education' )) {
					if ($first == true) { 
						echo '<h3>Educational Materials</h3><ul class="adc-col-list">';
					$first = false;
				 }
					echo '<li><a href="' ;
					the_permalink();
					echo '">';
					the_title();
					echo '</a></li>';
				}
		endwhile;
	} else {
		}
	echo '</ul>';
	wp_reset_query(); 
}
//Related blog links
function output_related_blog_links(){
$healtharticles = get_blog_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');	
if ($healtharticles->have_posts()){
		$first = true;
			while ($healtharticles->have_posts()): $healtharticles->the_post();
			static $counter = 0;
				if ( in_category( 'health-articles' )) {	
			
				if ($first == true) { echo '<h3>Related Health News</h3><ul class="adc-col-list">';
					$first = false;
				 }
				 if ($counter == "5") { break;
				 } else {
					echo '<li><a href="' ;
					the_permalink();
					echo '">';
					the_title();
					echo '</a></li>';
				$counter++;
				};
			}
		endwhile;
	} else { 
		}
	echo '</ul>';
	wp_reset_query();	
}
//Show list of related quality reports
function output_quality_reports_links(){
$qareports = get_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
if ($qareports->have_posts()){
	$first = true;
		while ($qareports->have_posts()): $qareports->the_post();
			if ( 'qualityreports' == get_post_type()) {
				if ($first == true) { echo '<h4>Quality Reports</h4><ul class="adc-col-list">';
				$first = false;
			 }
				echo '<li><a href="' ;
				the_permalink();
				echo '">';
				the_title();
				echo '</a></li>';
			}
	endwhile;
} else {
	}
echo '</ul>';
wp_reset_query();	
}
//Show list of doctors with thumbnail, title, clinic locations and if they accept new patients
function output_doctor_list_1() {
$providers = get_provider_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
if ($providers->have_posts()){
	echo '<h3>Doctors &amp; Providers</h3>';
		while ($providers->have_posts()): $providers->the_post();
			$classes = 'one-fourth adc-provider';
			if( 0 == $providers->current_post || 0 == $providers->current_post % 4 )
					$classes .= ' first';
			if ( 'biography' == get_post_type()) {
				echo '<div class="'.  $classes . '">';
				adc_get_excerpt_bio_thumb();
				echo '<h4><a href="';
				the_permalink();
				echo '">';
				the_title();
				adc_display_suffix();
				echo '</a></h4>';
				echo '<ul class="adc-provider-basic-info">';
				adc_display_accept_new_patients();
				echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
				echo '</ul>';
				echo '</div><!-- end .$classes-->';
			}
	  	endwhile;
	  }
	wp_reset_query();
}
function output_doctor_list_2() {
$providers = get_provider_posts_related_by_taxonomy(get_the_ID(), 'medicalservice');
if ($providers->have_posts()){
	echo '<h3>Providers</h3>';
		while ($providers->have_posts()): $providers->the_post();
			$classes = 'one-fourth adc-provider';
			if( 0 == $providers->current_post || 0 == $providers->current_post % 4 )
					$classes .= ' first';
			if ( 'biography' == get_post_type()) {
				echo '<div class="'.  $classes . '">';
				adc_get_excerpt_bio_thumb();
				echo '<h4><a href="';
				the_permalink();
				echo '">';
				the_title();
				adc_display_suffix();
				echo '</a></h4>';
				echo '<ul class="adc-provider-basic-info">';
				adc_display_accept_new_patients();
				echo get_the_term_list( $post->ID, 'cliniclocation', '<p>', '<br />', '</p>' );
				echo '</ul>';
				echo '</div><!-- end .$classes-->';
			}
	  	endwhile;
	  }
	wp_reset_query();
}
/************************************************************/
/*********************** ECOMMERCE *********************
/*************************************************************/ 

/** Enable Genesis connect for Woocommerce */
add_theme_support( 'genesis-connect-woocommerce' );
add_action( 'wp_enqueue_scripts', 'child_manage_woo_styles', 99 );

/**

* Remove WooCommerce styles and scripts unless inside the store.
*
* @author Greg Rickaby
* @since 1.0.0
*/

function child_manage_woo_styles() {

if ( 'product' !== get_post_type() && !is_page( 'cart' ) && !is_page( 'checkout' ) ) {
wp_dequeue_style( 'woocommerce_frontend_styles' );
wp_dequeue_style( 'woocommerce_fancybox_styles' );
wp_dequeue_style( 'woocommerce_chosen_styles' );
wp_dequeue_script( 'woocommerce' );
wp_dequeue_script( 'wc_price_slider' );

// wp_dequeue_script( 'fancybox' ); Not using fancybox? Then uncomment this line!
// wp_dequeue_script( 'jqueryui' ); Not using jquery-ui? Then uncomment this line!
	}
}