<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'inlife_enqueue_about_assets', 30 );

function inlife_enqueue_about_assets() {
	if ( is_page_template( 'page-templates/template-about-history.php' ) ) {
		$history_script = get_stylesheet_directory() . '/js/inlife-history-timeline.js';

		if ( file_exists( $history_script ) ) {
			wp_enqueue_script(
				'inlife-history-timeline',
				get_stylesheet_directory_uri() . '/js/inlife-history-timeline.js',
				[],
				filemtime( $history_script ),
				true
			);
		}
	}

	if ( is_page_template( 'page-templates/template-about-structure.php' ) ) {
		$structure_script = get_stylesheet_directory() . '/js/inlife-structure-lightbox.js';

		if ( file_exists( $structure_script ) ) {
			wp_enqueue_script(
				'inlife-structure-lightbox',
				get_stylesheet_directory_uri() . '/js/inlife-structure-lightbox.js',
				[],
				filemtime( $structure_script ),
				true
			);
		}
	}
}