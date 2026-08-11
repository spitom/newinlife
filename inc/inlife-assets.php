<?php
/**
 * Global frontend assets.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue a local theme script if the file exists.
 *
 * @param string $handle        Script handle.
 * @param string $relative_path Path relative to the child theme directory.
 * @param array  $deps          Script dependencies.
 */
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

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_bootstrap_icons', 20 );
/**
 * Enqueue Bootstrap Icons.
 */
function inlife_enqueue_bootstrap_icons(): void {
	$relative_path = '/assets/icons/bootstrap-icons/bootstrap-icons.min.css';
	$path          = get_stylesheet_directory() . $relative_path;

	if ( ! file_exists( $path ) ) {
		return;
	}

	wp_enqueue_style(
		'bootstrap-icons',
		get_stylesheet_directory_uri() . $relative_path,
		[],
		filemtime( $path )
	);
}