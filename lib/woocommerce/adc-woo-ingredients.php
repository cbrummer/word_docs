<?php

/**
 * Custom Tabs for Custom Specifications Display. Compatible with WooCommerce 2.0+ only!
 * This version uses the code editor.
 * 
 * Outputs an extra tab to the default set of info tabs on the single product page.
 * This file needs to be called via your functions.php file.
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
function custom_tab_options_tab_spec() {
?>
	<li class="custom_tab3"><a href="#custom_tab_data3"><?php _e('Ingredients', 'woothemes'); ?></a></li>
<?php
}
add_action('woocommerce_product_write_panel_tabs', 'custom_tab_options_tab_spec'); 


/**
 * Custom Tab Options
 * 
 * Provides the input fields and add/remove buttons for custom tabs on the single product page.
 */
function custom_tab_options_spec() {
	global $post;
	
	$custom_tab_options_spec = array(
		'titlec' => get_post_meta($post->ID, 'custom_tab_title_spec', true),
		'contentc' => get_post_meta($post->ID, 'custom_tab_content_spec', true),
	);
	
?>
	<div id="custom_tab_data3" class="panel woocommerce_options_panel">
		<div class="options_group">

			<p class="form-field">
				<?php woocommerce_wp_checkbox( array( 'id' => 'custom_tab_enabled_spec', 'label' => __('Enable Custom Tab?', 'woothemes'), 'description' => __('Enable this option to enable the custom tab on the frontend.', 'woothemes') ) ); ?>
			</p>
		</div>
		
		<div class="options_group custom_tab_options">                								
			
			<p class="form-field">
				<?php _e('Ingredients:', 'woothemes'); ?>
           	</p>
			
			<table class="form-table">
				<tr>
					<td>
<?php
		$settings = array(
 						'text_area_name'=> 'custom_tab_content_spec',
 						'quicktags' 	=> true,
 						'tinymce' 		=> true,
 						'media_butons' 	=> false,
 						'textarea_rows' => 98,
 						'editor_class'  => 'contra',
 						'editor_css'	=> '<style>#wp-custom_tab_content_spec-editor-container .wp-editor-area{height:250px; width:100%;} #custom_tab_data3 .quicktags-toolbar input {width:auto;}</style>'
 						);
 						
 		$id = 'custom_tab_content_spec';

 wp_editor($custom_tab_options_spec['contentc'],$id,$settings);
 
 ?>	
					</td>
				</tr>   
			</table>
        </div>	
	</div>
<?php
}
add_action('woocommerce_product_write_panels', 'custom_tab_options_spec');


/**
 * Process meta
 * 
 * Processes the custom tab options when a post is saved
 */
function process_product_meta_custom_tab_spec( $post_id ) {
	update_post_meta( $post_id, 'custom_tab_enabled_spec', ( isset($_POST['custom_tab_enabled_spec']) && $_POST['custom_tab_enabled_spec'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, 'custom_tab_title_spec', $_POST['custom_tab_title_spec']);
	update_post_meta( $post_id, 'custom_tab_content_spec', $_POST['custom_tab_content_spec']);
}
add_action('woocommerce_process_product_meta', 'process_product_meta_custom_tab_spec', 10, 2);


/**
 * Display Tab
 * 
 * Display Custom Tab on Frontend of Website for WooCommerce 2.0
 */

add_filter( 'woocommerce_product_tabs', 'woocommerce_product_custom_tab_spec' );


	function woocommerce_product_custom_tab_spec( $tabs ) {
		global $post, $product;

		$custom_tab_options_spec = array(
			'enabled' => get_post_meta($post->ID, 'custom_tab_enabled_spec', true),
			'titlec' => get_post_meta($post->ID, 'custom_tab_title_spec', true),
			'contentc' => get_post_meta($post->ID, 'custom_tab_content_spec', true),			
		);
		
			if ( $custom_tab_options_spec['enabled'] != 'no' ){
				$tabs['custom-tab-second'] = array(
					'title'    => 'Ingredients',
					'priority' => 25,
					'callback' => 'custom_product_tabs_panel_content_spec',					
					'content'  => $custom_tab_options_spec['contentc']
				);
			}
		return $tabs;
	}

	/**
	 * Render the custom product tab panel content for the callback 'custom_product_tabs_panel_content_spec'
	 */
		 
   function custom_product_tabs_panel_content_spec( $key, $custom_tab_options_spec ) {

		global $post, $product;

		$custom_tab_options_spec = array(
			'enabled' => get_post_meta($post->ID, 'custom_tab_enabled_spec', true),
			'titlec' => get_post_meta($post->ID, 'custom_tab_title_spec', true),
			'contentc' => get_post_meta($post->ID, 'custom_tab_content_spec', true),			
		);   
   
		echo '<h2>Ingredients</h2>';
		echo $custom_tab_options_spec['contentc'];
		echo '<p><a href="http://www.hmrinfo.com/ingredients/" title="" target="_blank">Click here for more information on ingredients and allergens</a></p>';

	}


?>