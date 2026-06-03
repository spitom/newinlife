<?php
/**
 * Internationalization helpers.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_languages' ) ) {
	/**
	 * Return Polylang languages as a raw array.
	 *
	 * @return array
	 */
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
	/**
	 * Translate a registered Polylang string with fallback.
	 *
	 * @param string $fallback Fallback/source string.
	 *
	 * @return string
	 */
	function inlife_t( string $fallback ): string {
		if ( '' === $fallback ) {
			return '';
		}

		if ( function_exists( 'pll__' ) ) {
			return pll__( $fallback );
		}

		return $fallback;
	}
}