<?php
/**
 * Classiera back compat functionality.
 *
 * Prevents Classiera from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backwards compatible and relies on
 * many new functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Classiera 1.0
 */

/**
 * Prevent switching to Classiera on old versions of WordPress. Switches
 * to the default theme.
 *
 * @since Classiera 1.0
 *
 * @return void
 */
function classiera_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'classiera_upgrade_notice' );
}
add_action( 'after_switch_theme', 'classiera_switch_theme' );

/**
 * Prints an update nag after an unsuccessful attempt to switch to
 * Classiera on WordPress versions prior to 3.6.
 *
 * @since Classiera 1.0
 *
 * @return void
 */
function classiera_upgrade_notice() {
	$message = sprintf( __( 'Classiera requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'classiera' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Classiera 1.0
 *
 * @return void
 */
function classiera_customize() {
	wp_die( sprintf( __( 'Classiera requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'classiera' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'classiera_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Classiera 1.0
 *
 * @return void
 */
function classiera_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Classiera requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'classiera' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'classiera_preview' );