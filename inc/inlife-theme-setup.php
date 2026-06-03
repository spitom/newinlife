<?php
/**
 * Theme setup.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_theme_setup' ) ) {
	/**
	 * Register theme supports and navigation menus.
	 */
	function inlife_theme_setup(): void {
		register_nav_menus(
			array(
				'primary'         => __( 'Primary Menu', 'newinlife-child' ),
				'top'             => __( 'Top Utility Menu', 'newinlife-child' ),
				'footer_employee' => __( 'Footer Employee Menu', 'newinlife-child' ),
				'footer_info'     => __( 'Footer Info Menu', 'newinlife-child' ),
				'footer_social'   => __( 'Footer Social Menu', 'newinlife-child' ),
			)
		);

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );

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
				'navigation-widgets',
			)
		);
	}
}
add_action( 'after_setup_theme', 'inlife_theme_setup', 20 );