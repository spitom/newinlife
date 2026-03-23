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