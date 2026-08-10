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

	inlife_enqueue_theme_script(
		'inlife-contact-map',
		'/js/inlife-contact-map.js',
		[ 'leaflet' ]
	);
}