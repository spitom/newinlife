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

if ( ! function_exists( 'inlife_get_term_translation_from_default_slug' ) ) {
	/**
	 * Return a taxonomy term translated into the requested/current language,
	 * starting from the slug of the default-language term.
	 *
	 * The default-language term remains the stable internal reference.
	 *
	 * @param string $taxonomy     Taxonomy key.
	 * @param string $default_slug Slug of the default-language term.
	 * @param string $language     Optional target language slug.
	 *
	 * @return WP_Term|null
	 */
	function inlife_get_term_translation_from_default_slug(
		string $taxonomy,
		string $default_slug,
		string $language = ''
	): ?WP_Term {
		if (
			'' === $taxonomy ||
			'' === $default_slug ||
			! taxonomy_exists( $taxonomy )
		) {
			return null;
		}

		$default_language = function_exists( 'pll_default_language' )
			? (string) pll_default_language( 'slug' )
			: '';

		$current_language = $language;

		if ( '' === $current_language && function_exists( 'pll_current_language' ) ) {
			$current_language = (string) pll_current_language( 'slug' );
		}

		$args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'slug'       => $default_slug,
			'number'     => 1,
		);

		/*
		 * Find the canonical/default-language term first.
		 * Polylang ignores the `lang` argument safely when inactive.
		 */
		if ( '' !== $default_language ) {
			$args['lang'] = $default_language;
		}

		$terms = get_terms( $args );

		if (
			is_wp_error( $terms ) ||
			empty( $terms ) ||
			! isset( $terms[0] ) ||
			! ( $terms[0] instanceof WP_Term )
		) {
			return null;
		}

		$default_term = $terms[0];

		/*
		 * Non-Polylang fallback: return the source/default term.
		 */
		if ( '' === $current_language || ! function_exists( 'pll_get_term' ) ) {
			return $default_term;
		}

		$translated_term_id = (int) pll_get_term(
			$default_term->term_id,
			$current_language
		);

		/*
		 * On a non-default language, hide an untranslated area instead of
		 * displaying the Polish term or creating a broken filter.
		 */
		if ( $translated_term_id <= 0 ) {
			return $current_language === $default_language ? $default_term : null;
		}

		$translated_term = get_term( $translated_term_id, $taxonomy );

		if ( ! $translated_term instanceof WP_Term || is_wp_error( $translated_term ) ) {
			return null;
		}

		return $translated_term;
	}
}

if ( ! function_exists( 'inlife_get_team_area_filter_map' ) ) {
	/**
	 * Stable URL/filter keys for team areas.
	 *
	 * Keys in the array are default-language taxonomy slugs.
	 * Values are language-neutral filter identifiers used in URLs and JS.
	 *
	 * @return array<string, string>
	 */
	function inlife_get_team_area_filter_map(): array {
		return array(
			'zywnosc'   => 'food',
			'zwierzeta' => 'animals',
			'zdrowie'   => 'health',
		);
	}
}

if ( ! function_exists( 'inlife_get_team_area_filter_key_from_term' ) ) {
	/**
	 * Resolve a stable team-area filter key from a term in any language.
	 *
	 * @param WP_Term|mixed $term Team area term.
	 *
	 * @return string
	 */
	function inlife_get_team_area_filter_key_from_term( $term ): string {
		if (
			! ( $term instanceof WP_Term ) ||
			'team_area' !== $term->taxonomy
		) {
			return '';
		}

		$source_term = $term;

		if (
			function_exists( 'pll_get_term' ) &&
			function_exists( 'pll_default_language' )
		) {
			$default_language = (string) pll_default_language( 'slug' );

			if ( '' !== $default_language ) {
				$default_term_id = (int) pll_get_term(
					$term->term_id,
					$default_language
				);

				if ( $default_term_id > 0 ) {
					$default_term = get_term( $default_term_id, 'team_area' );

					if (
						$default_term instanceof WP_Term &&
						! is_wp_error( $default_term )
					) {
						$source_term = $default_term;
					}
				}
			}
		}

		$filter_map = inlife_get_team_area_filter_map();

		return isset( $filter_map[ $source_term->slug ] )
			? $filter_map[ $source_term->slug ]
			: '';
	}
}

if ( ! function_exists( 'inlife_get_team_area_archive_url' ) ) {
	/**
	 * Build a Teams archive URL with a stable, language-independent
	 * team-area filter key.
	 *
	 * The source slug must be the default-language team_area slug.
	 * The resulting query value is identical in every language:
	 * food, animals or health.
	 *
	 * @param string $source_slug Default-language team_area slug.
	 * @param string $archive_url Teams archive URL for the current language.
	 *
	 * @return string
	 */
	function inlife_get_team_area_archive_url(
		string $source_slug,
		string $archive_url
	): string {
		if ( '' === $source_slug || '' === $archive_url ) {
			return $archive_url;
		}

		$filter_map = inlife_get_team_area_filter_map();

		if ( ! isset( $filter_map[ $source_slug ] ) ) {
			return $archive_url;
		}

		return add_query_arg(
			'area',
			$filter_map[ $source_slug ],
			$archive_url
		);
	}
}

if ( ! function_exists( 'inlife_get_archive_title' ) ) {
	/**
	 * Return the translated public title for a supported post type archive.
	 *
	 * This title is used consistently in archive heroes, browser titles
	 * and breadcrumbs.
	 *
	 * @param string $post_type Optional post type key.
	 *
	 * @return string
	 */
	function inlife_get_archive_title( string $post_type = '' ): string {
		if ( '' === $post_type && is_post_type_archive() ) {
			$queried_object = get_queried_object();

			if ( $queried_object instanceof WP_Post_Type ) {
				$post_type = $queried_object->name;
			}
		}

		$archive_titles = array(
			'teams'        => 'Zespoły badawcze',
			'laboratories' => 'Laboratoria',
			'people'       => 'Ludzie',
			'projects'     => 'Projekty',
			'publications' => 'Publikacje',
			'partners'     => 'Partnerzy',
			'career_entry' => 'Komunikaty',
		);

		if ( isset( $archive_titles[ $post_type ] ) ) {
			return inlife_t( $archive_titles[ $post_type ] );
		}

		$post_type_object = get_post_type_object( $post_type );

		if (
			$post_type_object &&
			isset( $post_type_object->labels->name )
		) {
			return (string) $post_type_object->labels->name;
		}

		return '';
	}
}

if ( ! function_exists( 'inlife_filter_archive_document_title' ) ) {
	/**
	 * Use central translated archive titles in browser tabs.
	 *
	 * @param array<string, string> $title_parts Document title parts.
	 *
	 * @return array<string, string>
	 */
	function inlife_filter_archive_document_title(
		array $title_parts
	): array {
		if ( ! is_post_type_archive() ) {
			return $title_parts;
		}

		$archive_title = inlife_get_archive_title();

		if ( '' !== $archive_title ) {
			$title_parts['title'] = $archive_title;
		}

		return $title_parts;
	}
}

add_filter(
	'document_title_parts',
	'inlife_filter_archive_document_title',
	20
);