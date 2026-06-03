<?php
/**
 * ACF field helper utilities.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_acf_field' ) ) {
	/**
	 * Safe ACF getter with fallback.
	 *
	 * Keeps valid falsy values such as 0, '0' and false.
	 *
	 * @param string $field_name ACF field name.
	 * @param int    $post_id    Post ID. Defaults to current post.
	 * @param mixed  $default    Default value when ACF is inactive or field is empty.
	 *
	 * @return mixed
	 */
	function inlife_get_acf_field( string $field_name, int $post_id = 0, $default = null ) {
		if ( '' === trim( $field_name ) ) {
			return $default;
		}

		if ( ! function_exists( 'get_field' ) ) {
			return $default;
		}

		$value = get_field( $field_name, $post_id );

		if ( null === $value || '' === $value ) {
			return $default;
		}

		return $value;
	}
}