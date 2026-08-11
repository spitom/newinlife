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

	inlife_enqueue_theme_style(
		'leaflet',
		'/assets/vendor/leaflet/leaflet.css'
	);

	inlife_enqueue_theme_script(
		'leaflet',
		'/assets/vendor/leaflet/leaflet.js'
	);

	inlife_enqueue_theme_script(
		'inlife-contact-map',
		'/js/inlife-contact-map.js',
		[ 'leaflet' ]
	);
}