<?php
/**
 * Enqueues scripts and styles for front end.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_scripts_styles(){
	//Load Script	
	wp_enqueue_script('jquery.min', get_template_directory_uri() . '/js/jquery.min.js', 'jquery', '', true);
	wp_enqueue_script('bootstrap.min', get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery', '', true);	
	wp_enqueue_script('bootstrap-dropdownhover', get_template_directory_uri() . '/js/bootstrap-dropdownhover.js', 'jquery', '', true);	
	wp_enqueue_script('validator.min', get_template_directory_uri() . '/js/validator.min.js', 'jquery', '', true);
	wp_enqueue_script('owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', 'jquery', '', true);	
	wp_enqueue_script('jquery.matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', 'jquery', '', true);
	wp_enqueue_script('infinitescroll', get_template_directory_uri() . '/js/infinitescroll.js', 'jquery', '', true);
	wp_enqueue_script('masonry.pkgd.min', get_template_directory_uri() . '/js/masonry.pkgd.min.js', 'jquery', '', true);
	wp_enqueue_script('select2.min', get_template_directory_uri() . '/js/select2.min.js', 'jquery', '', true);
	wp_enqueue_script('classiera', get_template_directory_uri() . '/js/classiera.js', 'jquery', '', true);
	wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', 'jquery', '', true);	
	
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Add Open Sans and Bitter fonts, used in the main stylesheet.
	//wp_enqueue_style( 'classiera-fonts', classiera_fonts_url(), array(), null );
	
	// Load google maps js
    global $redux_demo;
	$googleApiKey = $redux_demo['classiera_google_api'];
	$mapLang = $redux_demo['classiera_map_lang_code'];
	
    wp_enqueue_script( 'classiera-google-maps-script', 'https://maps.googleapis.com/maps/api/js?key='.$googleApiKey.'&language='.$mapLang.'&v=3.exp', array( 'jquery' ), '2014-07-18', true );
	
	wp_enqueue_script('classiera-map', get_template_directory_uri() . '/js/classiera-map.js', 'jquery', '', true);	

    if( is_page_template('template-submit-ads.php') || is_page_template('template-submit-ads-v2.php') || is_page_template('template-edit-post.php')) {
        /* add javascript */
		wp_enqueue_script('getlocation-map-script', get_template_directory_uri() . '/js/getlocation-map-script.js', 'jquery', '', true);		
		wp_enqueue_script('select2.min', get_template_directory_uri() . '/js/select2.min.js', 'jquery', '', true);
		wp_enqueue_style( 'select2.min', get_template_directory_uri() . '/css/select2.min.css', array(), '1' );
    }
	wp_enqueue_style( 'select2.min', get_template_directory_uri() . '/css/select2.min.css', array(), '1' );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui.min.css', array(), '1' );
	
    // Load Classiera CSS
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '1' );
    wp_enqueue_style( 'animate.min', get_template_directory_uri() . '/css/animate.min.css', array(), '1' );
    wp_enqueue_style( 'bootstrap-dropdownhover.min', get_template_directory_uri() . '/css/bootstrap-dropdownhover.min.css', array(), '1' );
	wp_enqueue_style( 'classiera-components', get_template_directory_uri() . '/css/classiera-components.css', array(), '1' );
	wp_enqueue_style( 'classiera', get_template_directory_uri() . '/css/classiera.css', array(), '1' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '1' );
	wp_enqueue_style( 'material-design-iconic-font', get_template_directory_uri() . '/css/material-design-iconic-font.css', array(), '1' );	
	wp_enqueue_style( 'owl.carousel.min', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '1' );
	wp_enqueue_style( 'owl.theme.default.min', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), '1' );
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1' );
	wp_enqueue_style( 'classiera-map', get_template_directory_uri() . '/css/classiera-map.css', array(), '1' );
    wp_enqueue_style( 'bootstrap-slider', get_template_directory_uri() . '/css/bootstrap-slider.css', array(), '1' );

	if(is_rtl()){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '1' );
	}

	if(is_admin_bar_showing()) echo "<style type=\"text/css\">.navbar-fixed-top { margin-top: 28px; } </style>";

}