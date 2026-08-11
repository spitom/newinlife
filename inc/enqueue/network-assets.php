<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_network_assets' );

function inlife_enqueue_network_assets() {
	if ( ! is_page_template( 'page-templates/template-network.php' ) ) {
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
}