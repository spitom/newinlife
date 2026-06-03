<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_about_assets', 30 );

function inlife_enqueue_about_assets() {
	if ( is_page_template( 'page-templates/template-about-history.php' ) ) {
		inlife_enqueue_theme_script(
			'inlife-history-timeline',
			'/js/inlife-history-timeline.js'
		);
	}

	if ( is_page_template( 'page-templates/template-about-structure.php' ) ) {
		inlife_enqueue_theme_script(
			'inlife-structure-lightbox',
			'/js/inlife-structure-lightbox.js'
		);
	}
}

function inlife_enqueue_theme_script( string $handle, string $relative_path, array $deps = [] ): void {
	$path = get_stylesheet_directory() . $relative_path;

	if ( ! file_exists( $path ) ) {
		return;
	}

	wp_enqueue_script(
		$handle,
		get_stylesheet_directory_uri() . $relative_path,
		$deps,
		filemtime( $path ),
		true
	);
}