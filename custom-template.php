<?php
/* 
Template Name: Template Name Here
*/

//custom hooks below here...

// Just an example.
remove_action('genesis_loop', 'genesis_do_loop');
/**
 * Example function that replaces the default loop with a custom loop querying 'PostType' CPT.
 * Remove this function (along with the remove action hook) to show default page content.
 * Or feel free to update the $args to make it work for you.
*/
add_action('genesis_loop', 'gt_custom_loop');
function gt_custom_loop() {

    global $paged;
    $args = array('post_type' => 'PostType');
	// Accepts WP_Query args (http://codex.wordpress.org/Class_Reference/WP_Query)
    genesis_custom_loop( $args );

}


genesis(); // <- everything important: make sure to include this. 