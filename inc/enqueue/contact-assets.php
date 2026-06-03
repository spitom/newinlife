<?php
/**
 * Contact page assets.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_contact_assets', 30 );

function inlife_enqueue_contact_assets(): void {
	if ( ! is_page_template( 'page-templates/template-contact.php' ) ) {
		return;
	}

	wp_enqueue_style(
		'leaflet',
		'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
		[],
		'1.9.4'
	);

	wp_enqueue_script(
		'leaflet',
		'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
		[],
		'1.9.4',
		true
	);

	$contact_map_script = get_stylesheet_directory() . '/js/inlife-contact-map.js';

	if ( file_exists( $contact_map_script ) ) {
		wp_enqueue_script(
			'inlife-contact-map',
			get_stylesheet_directory_uri() . '/js/inlife-contact-map.js',
			[ 'leaflet' ],
			filemtime( $contact_map_script ),
			true
		);
	}
}