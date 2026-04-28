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
	 * @param string $field_name
	 * @param int    $post_id
	 * @param mixed  $default
	 * @return mixed
	 */
	function inlife_get_acf_field( $field_name, $post_id = 0, $default = null ) {
		if ( function_exists( 'get_field' ) ) {
			$value = get_field( $field_name, $post_id );

			if ( null !== $value && '' !== $value ) {
				return $value;
			}
		}

		return $default;
	}
}