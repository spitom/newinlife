<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_career_types_map' ) ) {
	/**
	 * Stable technical keys for Career entry types.
	 *
	 * PL slugs are the source terms. EN slugs remain safe fallbacks
	 * until the Polylang term translation is created and connected.
	 *
	 * @return array
	 */
	function inlife_get_career_types_map(): array {
		return array(
			'scientific' => array(
				'pl' => 'konkursy-naukowe',
				'en' => 'scientific-positions',
				'labels' => array(
					'pl' => 'Konkursy na stanowiska naukowe',
					'en' => 'Scientific positions',
				),
			),
			'jobs' => array(
				'pl' => 'ogloszenia-o-prace',
				'en' => 'job-vacancies',
				'labels' => array(
					'pl' => 'Ogłoszenia o pracę',
					'en' => 'Job vacancies',
				),
			),
			'results' => array(
				'pl' => 'wyniki-konkursow',
				'en' => 'competition-results',
				'labels' => array(
					'pl' => 'Wyniki konkursów',
					'en' => 'Competition results',
				),
			),
			'archive' => array(
				'pl' => 'archiwum',
				'en' => 'archive',
				'labels' => array(
					'pl' => 'Archiwum',
					'en' => 'Archive',
				),
			),
		);
	}
}

if ( ! function_exists( 'inlife_get_lang' ) ) {
	/**
	 * Return current Polylang language slug.
	 *
	 * @return string
	 */
	function inlife_get_lang(): string {
		return function_exists( 'pll_current_language' )
			? (string) pll_current_language( 'slug' )
			: 'pl';
	}
}

if ( ! function_exists( 'inlife_get_career_type_source_term' ) ) {
	/**
	 * Return the Polish source term for a stable Career type key.
	 *
	 * @param string $type_key Stable Career type key.
	 * @return WP_Term|null
	 */
	function inlife_get_career_type_source_term( string $type_key ): ?WP_Term {
		$map      = inlife_get_career_types_map();
		$type_key = sanitize_key( $type_key );

		if ( empty( $map[ $type_key ]['pl'] ) ) {
			return null;
		}

		$term = get_term_by(
			'slug',
			$map[ $type_key ]['pl'],
			'career_entry_type'
		);

		return $term instanceof WP_Term ? $term : null;
	}
}

if ( ! function_exists( 'inlife_get_career_type_term' ) ) {
	/**
	 * Return the actual taxonomy term for a Career type in a given language.
	 *
	 * @param string $type_key Stable Career type key.
	 * @param string $language Optional language slug.
	 * @return WP_Term|null
	 */
	function inlife_get_career_type_term(
		string $type_key,
		string $language = ''
	): ?WP_Term {
		$map      = inlife_get_career_types_map();
		$type_key = sanitize_key( $type_key );
		$language = $language ? sanitize_key( $language ) : inlife_get_lang();

		if ( empty( $map[ $type_key ] ) ) {
			return null;
		}

		$source_term = inlife_get_career_type_source_term( $type_key );

		if ( $source_term instanceof WP_Term ) {
			if ( 'pl' === $language ) {
				return $source_term;
			}

			if ( function_exists( 'pll_get_term' ) ) {
				$translated_term_id = (int) pll_get_term(
					$source_term->term_id,
					$language
				);

				if ( $translated_term_id > 0 ) {
					$translated_term = get_term(
						$translated_term_id,
						'career_entry_type'
					);

					if ( $translated_term instanceof WP_Term ) {
						$term_language = function_exists( 'pll_get_term_language' )
							? (string) pll_get_term_language(
								$translated_term->term_id,
								'slug'
							)
							: '';

						if (
							'' === $term_language ||
							$language === $term_language
						) {
							return $translated_term;
						}
					}
				}
			}
		}

		/*
		 * Transitional fallback: useful until EN term translations
		 * are created and connected in Polylang.
		 */
		$fallback_slug = $map[ $type_key ][ $language ] ?? '';

		if ( '' === $fallback_slug ) {
			return null;
		}

		$fallback_term = get_term_by(
			'slug',
			$fallback_slug,
			'career_entry_type'
		);

		if ( ! $fallback_term instanceof WP_Term ) {
			return null;
		}

		if ( function_exists( 'pll_get_term_language' ) ) {
			$term_language = (string) pll_get_term_language(
				$fallback_term->term_id,
				'slug'
			);

			if ( '' !== $term_language && $language !== $term_language ) {
				return null;
			}
		}

		return $fallback_term;
	}
}

if ( ! function_exists( 'inlife_get_career_type_slug' ) ) {
	/**
	 * Return the current-language slug for a stable Career type key.
	 *
	 * @param string $type_key Stable Career type key.
	 * @return string
	 */
	function inlife_get_career_type_slug( string $type_key ): string {
		$type_key = sanitize_key( $type_key );
		$term     = inlife_get_career_type_term( $type_key );

		if ( $term instanceof WP_Term ) {
			return (string) $term->slug;
		}

		$map  = inlife_get_career_types_map();
		$lang = inlife_get_lang();

		return isset( $map[ $type_key ][ $lang ] )
			? (string) $map[ $type_key ][ $lang ]
			: '';
	}
}

if ( ! function_exists( 'inlife_get_career_type_label' ) ) {
	/**
	 * Return the visible current-language label for a Career type.
	 *
	 * @param string $type_key Stable Career type key.
	 * @return string
	 */
	function inlife_get_career_type_label( string $type_key ): string {
		$type_key = sanitize_key( $type_key );
		$term     = inlife_get_career_type_term( $type_key );

		if ( $term instanceof WP_Term ) {
			return (string) $term->name;
		}

		$map  = inlife_get_career_types_map();
		$lang = inlife_get_lang();

		return $map[ $type_key ]['labels'][ $lang ] ?? ucfirst( $type_key );
	}
}

if ( ! function_exists( 'inlife_get_career_type_key_from_slug' ) ) {
	/**
	 * Resolve a stable Career type key from any translated term slug.
	 *
	 * @param string $slug Term slug.
	 * @return string|null
	 */
	function inlife_get_career_type_key_from_slug( string $slug ): ?string {
		$slug = sanitize_title( $slug );
		$map  = inlife_get_career_types_map();

		foreach ( $map as $type_key => $type_data ) {
			foreach ( array( 'pl', 'en' ) as $language ) {
				$term = inlife_get_career_type_term( $type_key, $language );

				if (
					$term instanceof WP_Term &&
					$slug === $term->slug
				) {
					return $type_key;
				}
			}

			if (
				$slug === $type_data['pl'] ||
				$slug === $type_data['en']
			) {
				return $type_key;
			}
		}

		return null;
	}
}

if ( ! function_exists( 'inlife_add_career_language_to_query_args' ) ) {
	/**
	 * Force Career custom queries to use the active Polylang language.
	 *
	 * @param array $query_args WP_Query arguments.
	 * @return array
	 */
	function inlife_add_career_language_to_query_args(
		array $query_args
	): array {
		$language = inlife_get_lang();

		if ( '' !== $language ) {
			$query_args['lang'] = $language;
		}

		$query_args['suppress_filters'] = false;

		return $query_args;
	}
}

if ( ! function_exists( 'inlife_get_announcements_base_slug' ) ) {
	function inlife_get_announcements_base_slug(): string {
		return 'en' === inlife_get_lang()
			? 'announcements'
			: 'komunikaty';
	}
}

if ( ! function_exists( 'inlife_get_announcements_type_base_slug' ) ) {
	function inlife_get_announcements_type_base_slug(): string {
		return 'en' === inlife_get_lang()
			? 'type'
			: 'typ';
	}
}

if ( ! function_exists( 'inlife_get_announcements_entry_base_slug' ) ) {
	function inlife_get_announcements_entry_base_slug(): string {
		return 'en' === inlife_get_lang()
			? 'entry'
			: 'wpis';
	}
}

if ( ! function_exists( 'inlife_get_career_term_archive_url' ) ) {
	/**
	 * Return a Career type archive URL in the active language.
	 *
	 * Uses get_term_link() when an actual Polylang term exists.
	 *
	 * @param string $type_key Stable Career type key.
	 * @return string
	 */
	function inlife_get_career_term_archive_url( string $type_key ): string {
		$term = inlife_get_career_type_term( $type_key );

		if ( $term instanceof WP_Term ) {
			$url = get_term_link( $term );

			if ( ! is_wp_error( $url ) ) {
				return (string) $url;
			}
		}

		/*
		 * Safe temporary fallback before EN term translations exist.
		 */
		$term_slug = inlife_get_career_type_slug( $type_key );

		if ( '' === $term_slug ) {
			return home_url( '/' );
		}

		$root_url = function_exists( 'pll_home_url' )
			? (string) pll_home_url()
			: home_url( '/' );

		$path = inlife_get_announcements_base_slug() .
			'/' .
			inlife_get_announcements_type_base_slug() .
			'/' .
			$term_slug;

		return trailingslashit( $root_url ) .
			ltrim( user_trailingslashit( $path ), '/' );
	}
}

if ( ! function_exists( 'inlife_get_career_type_behavior_source_term' ) ) {
	/**
	 * Return the Polish source term used for shared Career behavior.
	 *
	 * Functional settings are maintained only on the PL source term.
	 *
	 * @param WP_Term|int $term Career type term or ID.
	 * @return WP_Term|null
	 */
	function inlife_get_career_type_behavior_source_term( $term ): ?WP_Term {
		if ( is_numeric( $term ) ) {
			$term = get_term( (int) $term, 'career_entry_type' );
		}

		if (
			! $term instanceof WP_Term ||
			'career_entry_type' !== $term->taxonomy
		) {
			return null;
		}

		if (
			function_exists( 'pll_get_term' ) &&
			function_exists( 'pll_get_term_language' )
		) {
			$term_language = (string) pll_get_term_language(
				$term->term_id,
				'slug'
			);

			if ( 'pl' !== $term_language && '' !== $term_language ) {
				$polish_term_id = (int) pll_get_term(
					$term->term_id,
					'pl'
				);

				if ( $polish_term_id > 0 ) {
					$polish_term = get_term(
						$polish_term_id,
						'career_entry_type'
					);

					if ( $polish_term instanceof WP_Term ) {
						return $polish_term;
					}
				}
			}
		}

		return $term;
	}
}

if ( ! function_exists( 'inlife_get_career_type_legacy_behavior' ) ) {
	/**
	 * Preserve the current behavior until the ACF settings are saved
	 * on an existing Career type.
	 *
	 * @param WP_Term $source_term Polish source term.
	 * @return array
	 */
	function inlife_get_career_type_legacy_behavior(
		WP_Term $source_term
	): array {
		$defaults = array(
			'placement'       => 'hidden',
			'order'           => 100,
			'card_style'      => 'standard',
			'show_on_landing' => false,
			'show_deadline'   => true,
			'show_rodo'       => true,
			'show_share'      => true,
		);

		$type_key = function_exists( 'inlife_get_career_type_key_from_slug' )
			? inlife_get_career_type_key_from_slug( $source_term->slug )
			: null;

		$legacy = array(
			'scientific' => array(
				'placement'       => 'current',
				'order'           => 10,
				'card_style'      => 'scientific',
				'show_on_landing' => true,
				'show_deadline'   => true,
				'show_rodo'       => true,
				'show_share'      => true,
			),
			'jobs' => array(
				'placement'       => 'current',
				'order'           => 20,
				'card_style'      => 'jobs',
				'show_on_landing' => true,
				'show_deadline'   => true,
				'show_rodo'       => true,
				'show_share'      => true,
			),
			'results' => array(
				'placement'       => 'secondary',
				'order'           => 10,
				'card_style'      => 'standard',
				'show_on_landing' => false,
				'show_deadline'   => false,
				'show_rodo'       => false,
				'show_share'      => true,
			),
			'archive' => array(
				'placement'       => 'secondary',
				'order'           => 20,
				'card_style'      => 'standard',
				'show_on_landing' => false,
				'show_deadline'   => false,
				'show_rodo'       => false,
				'show_share'      => false,
			),
		);

		if ( $type_key && isset( $legacy[ $type_key ] ) ) {
			return array_merge( $defaults, $legacy[ $type_key ] );
		}

		return $defaults;
	}
}

if ( ! function_exists( 'inlife_get_career_type_behavior' ) ) {
	/**
	 * Return functional Career type configuration.
	 *
	 * Settings are read from the Polish source term. Until a term is
	 * explicitly configured in ACF, the legacy behavior is preserved.
	 *
	 * @param WP_Term|int $term Career type term or ID.
	 * @return array
	 */
	function inlife_get_career_type_behavior( $term ): array {
		$source_term = inlife_get_career_type_behavior_source_term( $term );

		if ( ! $source_term instanceof WP_Term ) {
			return array(
				'placement'       => 'hidden',
				'order'           => 100,
				'card_style'      => 'standard',
				'show_on_landing' => false,
				'show_deadline'   => true,
				'show_rodo'       => true,
				'show_share'      => true,
			);
		}

		$config = inlife_get_career_type_legacy_behavior( $source_term );

		/*
		 * ACF writes this meta only after the editor saves a given type.
		 * Before then we intentionally preserve the existing site behavior.
		 */
		$has_saved_configuration = metadata_exists(
			'term',
			$source_term->term_id,
			'career_type_placement'
		);

		if ( ! $has_saved_configuration ) {
			return $config;
		}

		$acf_context = 'career_entry_type_' . $source_term->term_id;

		$placement = function_exists( 'get_field' )
			? (string) get_field( 'career_type_placement', $acf_context )
			: '';

		$card_style = function_exists( 'get_field' )
			? (string) get_field( 'career_type_card_style', $acf_context )
			: '';

		$order = function_exists( 'get_field' )
			? (int) get_field( 'career_type_order', $acf_context )
			: 100;

		if ( in_array( $placement, array( 'current', 'secondary', 'hidden' ), true ) ) {
			$config['placement'] = $placement;
		}

		if ( in_array( $card_style, array( 'standard', 'scientific', 'jobs' ), true ) ) {
			$config['card_style'] = $card_style;
		}

		$config['order'] = max( 0, $order );

		$config['show_on_landing'] = function_exists( 'get_field' )
			? (bool) get_field( 'career_type_show_on_landing', $acf_context )
			: false;

		$config['show_deadline'] = function_exists( 'get_field' )
			? (bool) get_field( 'career_type_show_deadline', $acf_context )
			: true;

		$config['show_rodo'] = function_exists( 'get_field' )
			? (bool) get_field( 'career_type_show_rodo', $acf_context )
			: true;

		$config['show_share'] = function_exists( 'get_field' )
			? (bool) get_field( 'career_type_show_share', $acf_context )
			: true;

		return $config;
	}
}

if ( ! function_exists( 'inlife_get_career_entry_primary_type' ) ) {
	/**
	 * Return the Career type with the highest configured priority.
	 *
	 * @param int $post_id Career entry ID.
	 * @return WP_Term|null
	 */
	function inlife_get_career_entry_primary_type(
		int $post_id = 0
	): ?WP_Term {
		$post_id = $post_id ?: get_the_ID();

		$terms = get_the_terms( $post_id, 'career_entry_type' );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return null;
		}

		usort(
			$terms,
			static function ( WP_Term $first, WP_Term $second ): int {
				$first_behavior  = inlife_get_career_type_behavior( $first );
				$second_behavior = inlife_get_career_type_behavior( $second );

				$first_order  = (int) $first_behavior['order'];
				$second_order = (int) $second_behavior['order'];

				if ( $first_order === $second_order ) {
					return strcasecmp( $first->name, $second->name );
				}

				return $first_order <=> $second_order;
			}
		);

		return $terms[0] instanceof WP_Term ? $terms[0] : null;
	}
}

if ( ! function_exists( 'inlife_get_career_type_display_term' ) ) {
	/**
	 * Return a Career type term in the requested language.
	 *
	 * A missing translation intentionally returns null, so an EN page
	 * never falls back to displaying a Polish Career type.
	 *
	 * @param WP_Term $source_term Polish source term.
	 * @param string  $language    Optional Polylang language slug.
	 * @return WP_Term|null
	 */
	function inlife_get_career_type_display_term(
		WP_Term $source_term,
		string $language = ''
	): ?WP_Term {
		$language = $language
			? sanitize_key( $language )
			: inlife_get_lang();

		if (
			'' === $language ||
			'pl' === $language ||
			! function_exists( 'pll_get_term' )
		) {
			return $source_term;
		}

		$translated_term_id = (int) pll_get_term(
			$source_term->term_id,
			$language
		);

		if ( $translated_term_id <= 0 ) {
			return null;
		}

		$translated_term = get_term(
			$translated_term_id,
			'career_entry_type'
		);

		return $translated_term instanceof WP_Term
			? $translated_term
			: null;
	}
}

if ( ! function_exists( 'inlife_get_career_types_by_placement' ) ) {
	/**
	 * Return configured Career types for one presentation area.
	 *
	 * Each item contains:
	 * - source_term: Polish term holding functional ACF settings;
	 * - term: term in the active language;
	 * - behavior: normalized functional configuration.
	 *
	 * @param string $placement current, secondary or hidden.
	 * @param string $language  Optional language slug.
	 * @return array<int, array<string, mixed>>
	 */
	function inlife_get_career_types_by_placement(
		string $placement,
		string $language = ''
	): array {
		$allowed_placements = array( 'current', 'secondary', 'hidden' );

		if ( ! in_array( $placement, $allowed_placements, true ) ) {
			return array();
		}

		$language = $language
			? sanitize_key( $language )
			: inlife_get_lang();

		$terms = get_terms(
			array(
				'taxonomy'   => 'career_entry_type',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return array();
		}

		$items = array();
		$seen  = array();

		foreach ( $terms as $term ) {
			if ( ! $term instanceof WP_Term ) {
				continue;
			}

			$source_term = inlife_get_career_type_behavior_source_term(
				$term
			);

			if ( ! $source_term instanceof WP_Term ) {
				continue;
			}

			$source_term_id = (int) $source_term->term_id;

			if ( isset( $seen[ $source_term_id ] ) ) {
				continue;
			}

			$seen[ $source_term_id ] = true;

			$behavior = inlife_get_career_type_behavior( $source_term );

			if (
				empty( $behavior['placement'] ) ||
				$placement !== $behavior['placement']
			) {
				continue;
			}

			$display_term = inlife_get_career_type_display_term(
				$source_term,
				$language
			);

			/*
			 * A missing EN translation must not expose the PL type
			 * on the English Career pages.
			 */
			if ( ! $display_term instanceof WP_Term ) {
				continue;
			}

			$items[] = array(
				'source_term' => $source_term,
				'term'        => $display_term,
				'behavior'    => $behavior,
			);
		}

		usort(
			$items,
			static function ( array $first, array $second ): int {
				$first_order = isset( $first['behavior']['order'] )
					? (int) $first['behavior']['order']
					: 100;

				$second_order = isset( $second['behavior']['order'] )
					? (int) $second['behavior']['order']
					: 100;

				if ( $first_order === $second_order ) {
					$first_name = $first['term'] instanceof WP_Term
						? $first['term']->name
						: '';

					$second_name = $second['term'] instanceof WP_Term
						? $second['term']->name
						: '';

					return strcasecmp( $first_name, $second_name );
				}

				return $first_order <=> $second_order;
			}
		);

		return $items;
	}
}

if ( ! function_exists( 'inlife_get_career_current_types' ) ) {
	/**
	 * Return types that belong to the "Aktualne oferty" area.
	 *
	 * @param bool $landing_only Limit to types enabled on Career landing.
	 * @return array<int, array<string, mixed>>
	 */
	function inlife_get_career_current_types(
		bool $landing_only = false
	): array {
		$types = inlife_get_career_types_by_placement( 'current' );

		if ( ! $landing_only ) {
			return $types;
		}

		return array_values(
			array_filter(
				$types,
				static function ( array $type ): bool {
					return ! empty(
						$type['behavior']['show_on_landing']
					);
				}
			)
		);
	}
}

if ( ! function_exists( 'inlife_get_career_secondary_types' ) ) {
	/**
	 * Return types displayed in the "Wyniki i archiwum" area.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	function inlife_get_career_secondary_types(): array {
		return inlife_get_career_types_by_placement( 'secondary' );
	}
}

if ( ! function_exists( 'inlife_get_career_type_filter_key' ) ) {
	/**
	 * Return a stable DOM key for a Career type filter.
	 *
	 * @param WP_Term|int $term Career type term or term ID.
	 * @return string
	 */
	function inlife_get_career_type_filter_key( $term ): string {
		if ( is_numeric( $term ) ) {
			$term = get_term( (int) $term, 'career_entry_type' );
		}

		if (
			! $term instanceof WP_Term ||
			'career_entry_type' !== $term->taxonomy
		) {
			return '';
		}

		return 'type-' . (int) $term->term_id;
	}
}

if ( ! function_exists( 'inlife_get_career_entry_type_for_placement' ) ) {
	/**
	 * Return the highest-priority assigned Career type for one area.
	 *
	 * @param int    $post_id   Career entry ID.
	 * @param string $placement current, secondary or hidden.
	 * @return WP_Term|null
	 */
	function inlife_get_career_entry_type_for_placement(
		int $post_id,
		string $placement
	): ?WP_Term {
		$terms = get_the_terms( $post_id, 'career_entry_type' );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return null;
		}

		$matches = array();

		foreach ( $terms as $term ) {
			if ( ! $term instanceof WP_Term ) {
				continue;
			}

			$behavior = inlife_get_career_type_behavior( $term );

			if (
				empty( $behavior['placement'] ) ||
				$placement !== $behavior['placement']
			) {
				continue;
			}

			$matches[] = array(
				'term'     => $term,
				'behavior' => $behavior,
			);
		}

		if ( empty( $matches ) ) {
			return null;
		}

		usort(
			$matches,
			static function ( array $first, array $second ): int {
				$first_order = isset( $first['behavior']['order'] )
					? (int) $first['behavior']['order']
					: 100;

				$second_order = isset( $second['behavior']['order'] )
					? (int) $second['behavior']['order']
					: 100;

				if ( $first_order === $second_order ) {
					return strcasecmp(
						$first['term']->name,
						$second['term']->name
					);
				}

				return $first_order <=> $second_order;
			}
		);

		return $matches[0]['term'] instanceof WP_Term
			? $matches[0]['term']
			: null;
	}
}

if ( ! function_exists( 'inlife_get_career_type_secondary_description' ) ) {
	/**
	 * Return the translated secondary-card description for a Career type.
	 *
	 * This text is maintained separately on PL and EN term translations.
	 *
	 * @param WP_Term|int $term Career type term or term ID.
	 * @return string
	 */
	function inlife_get_career_type_secondary_description(
		$term
	): string {
		if ( is_numeric( $term ) ) {
			$term = get_term( (int) $term, 'career_entry_type' );
		}

		if (
			! $term instanceof WP_Term ||
			! function_exists( 'get_field' )
		) {
			return '';
		}

		$value = get_field(
			'career_type_secondary_description',
			'career_entry_type_' . $term->term_id
		);

		return is_string( $value )
			? trim( $value )
			: '';
	}
}