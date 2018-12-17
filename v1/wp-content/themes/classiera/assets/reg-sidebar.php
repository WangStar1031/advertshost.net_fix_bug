<?php
/**
 * Registers two widget areas.
 *
 * @since classiera 1.0
 *
 * @return void
 */
function classiera_widgets_init() {
	global $redux_demo;
	$classieraFooterStyle = $redux_demo['classiera_footer_style'];
	register_sidebar( array(
		'name'          => esc_html__( 'Pages Sidebar', 'classiera' ),
		'id'            => 'pages',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'classiera' ),
		'before_widget' => '<div class="col-lg-12 col-md-12 col-sm-6 match-height"><div class="widget-box">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) ); 
	if($classieraFooterStyle == 'three'){
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget ', 'classiera' ),
			'id'            => 'footer-one',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'classiera' ),
			'before_widget' => '<div class="col-lg-4 col-sm-6 match-height"><div class="widget-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
	}elseif($classieraFooterStyle == 'four'){
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget ', 'classiera' ),
			'id'            => 'footer-one',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'classiera' ),
			'before_widget' => '<div class="col-lg-3 col-sm-6 match-height"><div class="widget-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );
	}
    register_sidebar( array(
        'name'          => esc_html__( 'Forum Widget Area', 'classiera' ),
        'id'            => 'forum',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'classiera' ),
        'before_widget' => '<div class="cat-widget"><div class="cat-widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="cat-widget-title"><h4>',
        'after_title'   => '</h4></div>',
    ) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Single Ad Sidebar', 'classiera' ),
		'id'            => 'single',
		'description'   => esc_html__( 'Appears on Ad Details Sidebar.', 'classiera' ),
		'before_widget' => '<div class="col-lg-12 col-md-12 col-sm-6 match-height"><div class="widget-box">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'classiera' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'Appears on Blog sidebar.', 'classiera' ),
		'before_widget' => '<div class="col-lg-12 col-md-12 col-sm-6 match-height"><div class="widget-box">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar', 'classiera' ),
		'id'            => 'woocommerce',
		'description'   => esc_html__( 'Appears on only woocommerce single product page', 'classiera' ),
		'before_widget' => '<div class="col-lg-12 col-md-12 col-sm-6 match-height"><div class="widget-box">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );     
}