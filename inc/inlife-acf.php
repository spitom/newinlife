<?php
/**
 * ACF integration.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_have_rows' ) ) {
	/**
	 * Safe ACF repeater checker.
	 *
	 * @param string $field_name ACF field name.
	 * @param int    $post_id    Post ID. Defaults to current post.
	 *
	 * @return bool
	 */
	function inlife_have_rows( string $field_name, int $post_id = 0 ): bool {
		if ( '' === trim( $field_name ) ) {
			return false;
		}

		return function_exists( 'have_rows' ) && have_rows( $field_name, $post_id );
	}
}

/**
 * Save ACF Local JSON to the child theme.
 */
add_filter(
	'acf/settings/save_json',
	function(): string {
		return get_stylesheet_directory() . '/acf-json';
	}
);

/**
 * Load ACF Local JSON from the child theme.
 */
add_filter(
	'acf/settings/load_json',
	function( array $paths ): array {
		unset( $paths[0] );

		$paths[] = get_stylesheet_directory() . '/acf-json';

		return $paths;
	}
);

add_action( 'acf/init', 'inlife_register_options_pages' );

if ( ! function_exists( 'inlife_register_options_pages' ) ) {
	/**
	 * Register ACF options pages.
	 */
	function inlife_register_options_pages(): void {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => 'Ustawienia InLife',
				'menu_title' => 'Ustawienia InLife',
				'menu_slug'  => 'inlife-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			)
		);
	}
}