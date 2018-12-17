<?php
// Register menus
register_nav_menus(
	array(
		'primary' => esc_html__( 'Primary Menu', 'classiera' ),   // Main nav in header
		'mobile' => esc_html__( 'Mobile Menu', 'classiera' ),   // Main nav in header
		'footer' => esc_html__( 'Footer Menu', 'classiera' ),   // Main nav in header
	)
);
// The Top Menu
function classieraPrimaryNav(){
	wp_nav_menu( array(
		'menu'              => 'primary',
		'theme_location'    => 'primary',
		'depth'             => 3,
		'container'         => 'ul',
		'menu_class'        => 'nav navbar-nav navbar-right nav-margin-top flip nav-ltr',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}
// The Mobile Menu/
/*
function classieraMobileNav(){
	wp_nav_menu( array(
		'menu'              => 'mobile',
		'theme_location'    => 'mobile',
		'depth'             => 3,
		'container'         => 'div',
		'container_class'   => 'collapse navbar-collapse',
		'container_id'      => 'bs-example-navbar-collapse-1',
		'menu_class'        => 'nav navbar-nav navbar-right',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}*/
function classieraMobileNav(){
	wp_nav_menu( array(
		'menu'              => 'mobile',
		'theme_location'    => 'mobile',
		'depth'             => 3,
		'menu_class'        => 'nav navmenu-nav',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}
// The Footer Menu
function classieraFooterNav(){
	wp_nav_menu( array(
		'menu'              => 'footer',
		'theme_location'    => 'footer',
		'depth'             => 1,
		'container'         => 'ul',
		'container_class'   => '',
		'container_id'      => '',
		'menu_class'        => '',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}

?>