<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_network_assets' );

function inlife_enqueue_network_assets() {
	if ( ! is_page_template( 'page-templates/template-network.php' ) ) {
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

	wp_enqueue_script(
		'inlife-network-map',
		get_stylesheet_directory_uri() . '/js/network-map.js',
		[ 'leaflet' ],
		filemtime( get_stylesheet_directory() . '/js/network-map.js' ),
		true
	);
}