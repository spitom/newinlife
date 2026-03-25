<?php
defined( 'ABSPATH' ) || exit;

/**
 * Return Polylang languages raw array.
 *
 * @return array
 */

if ( ! function_exists( 'inlife_get_languages' ) ) {
	function inlife_get_languages(): array {
		if ( ! function_exists( 'pll_the_languages' ) ) {
			return array();
		}

		$languages = pll_the_languages(
			array(
				'raw'           => 1,
				'hide_if_empty' => 0,
				'hide_current'  => 0,
			)
		);

		return is_array( $languages ) ? $languages : array();
	}
}

if ( ! function_exists( 'inlife_t' ) ) {
	function inlife_t( string $fallback ): string {
		if ( function_exists( 'pll__' ) ) {
			return pll__( $fallback );
		}

		return $fallback;
	}
}