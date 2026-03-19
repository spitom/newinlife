<?php
defined( 'ABSPATH' ) || exit;

/**
 * Google Fonts – SUSE
 */
add_action( 'wp_enqueue_scripts', 'inlife_enqueue_google_fonts', 20 );
function inlife_enqueue_google_fonts() {
	wp_enqueue_style(
		'inlife-google-fonts',
		'https://fonts.googleapis.com/css2?family=SUSE:wght@400;500;600;700&display=swap',
		[],
		null
	);
}

/**
 * Bootstrap Icons
 */
add_action( 'wp_enqueue_scripts', 'inlife_enqueue_bootstrap_icons', 20 );
function inlife_enqueue_bootstrap_icons() {
	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
		[],
		'1.11.3'
	);
}