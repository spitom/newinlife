<?php
/**
 * ACF helpers
 */

defined('ABSPATH') || exit;

if (!function_exists('inlife_get_acf_field')) {
	function inlife_get_acf_field($field_name, $post_id = 0, $default = null) {
		if (function_exists('get_field')) {
			$value = get_field($field_name, $post_id);

			if ($value !== null && $value !== '') {
				return $value;
			}
		}

		return $default;
	}
}

if (!function_exists('inlife_have_rows')) {
	function inlife_have_rows($field_name, $post_id = 0) {
		return function_exists('have_rows') && have_rows($field_name, $post_id);
	}
}


/**
 * Save ACF JSON to theme folder.
 */
add_filter(
	'acf/settings/save_json',
	function () {
		return get_stylesheet_directory() . '/acf-json';
	}
);

/**
 * Load ACF JSON from theme folder.
 */
add_filter('acf/settings/load_json', function ($paths) {
	unset($paths[0]);
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
});

add_action( 'acf/init', 'inlife_register_options_pages' );

function inlife_register_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		[
			'page_title' => 'Ustawienia InLife',
			'menu_title' => 'Ustawienia InLife',
			'menu_slug'  => 'inlife-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		]
	);
}