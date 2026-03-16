<?php
defined( 'ABSPATH' ) || exit;

/**
 * Theme setup.
 */
function inlife_theme_setup() {

	register_nav_menus(
		array(
			'primary'  => __( 'Primary Menu', 'understrap-child' ),
			'top'      => __( 'Top Utility Menu', 'understrap-child' ),
			'footer_1' => __( 'Footer Menu 1', 'understrap-child' ),
			'footer_2' => __( 'Footer Menu 2', 'understrap-child' ),
		)
	);

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

}
add_action( 'after_setup_theme', 'inlife_theme_setup', 20 );