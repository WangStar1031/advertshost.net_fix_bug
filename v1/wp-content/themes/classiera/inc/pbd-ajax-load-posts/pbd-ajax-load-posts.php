<?php
/**
 * Plugin Name: PBD AJAX Load Posts
 * Plugin URI: http://www.problogdesign.com/
 * Description: Load the next page of posts with AJAX.
 * Version: 0.1
 * Author: Pro Blog Design
 * Author URI: http://www.problogdesign.com/
 */
 
 /**
  * Initialization. Add our script if needed on this page.
  */
 function pbd_alp_init() {

 	$args = array(
	    'post_type' => 'post',
	    'showposts'=> 3,
	    'paged' => $paged,
	);

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
 
 	// Add code to index pages.
 	if( is_page_template('category.php') ) {	
 		// Queue JS and CSS
 		wp_enqueue_script(
 			'pbd-alp-load-posts',
 			get_template_directory_uri() . '/inc/pbd-ajax-load-posts/js/load-posts.js',
 			array('jquery'),
 			'1.0',
 			true
 		);
 		
 		wp_enqueue_style(
 			'pbd-alp-style',
 			get_template_directory_uri() . '/inc/pbd-ajax-load-posts/css/style.css',
 			false,
 			'1.0',
 			'all'
 		);
 		
 	
 		
 		// What page are we on? And what is the pages limit?
 		$max = $wp_query->max_num_pages;
 		$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
 		
 		// Add some parameters for the JS.
 		wp_localize_script(
 			'pbd-alp-load-posts',
 			'pbd_alp',
 			array(
 				'startPage' => $paged,
 				'maxPages' => $wp_query->max_num_pages,
 				'nextLink' => next_posts($max, false)
 			)
 		);
 	}


 }
 add_action('template_redirect', 'pbd_alp_init');
 
 ?>