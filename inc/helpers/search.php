<?php
/**
 * Search helpers.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types included in public site search.
 */
function inlife_get_search_post_types(): array {
	return [
		'post',
		'page',
		'teams',
		'laboratories',
		'projects',
		'publications',
		'career_entry',
		'partners',
	];
}

/**
 * Find teams and laboratories related to people matching the search term.
 *
 * People remain excluded from public search results. Their records are used
 * only as an internal relation index for teams and laboratories.
 *
 * @param string $search_term Search phrase.
 * @return int[]
 */
function inlife_get_search_related_unit_ids( string $search_term ): array {
	global $wpdb;

	$search_term = trim( wp_strip_all_tags( $search_term ) );

	if ( '' === $search_term ) {
		return [];
	}

	$search_tokens = preg_split(
		'/\s+/u',
		$search_term,
		-1,
		PREG_SPLIT_NO_EMPTY
	);

	$search_tokens = array_values(
		array_unique(
			array_filter(
				array_map( 'trim', (array) $search_tokens )
			)
		)
	);

	if ( empty( $search_tokens ) ) {
		return [];
	}

	/*
	 * Search every language version of People.
	 *
	 * Each entered word must occur in the post title, but the order of words
	 * does not matter. This handles both "Jan Kowalski" and "Kowalski Jan".
	 */
	$title_conditions = [];
	$title_values     = [];

	foreach ( $search_tokens as $token ) {
		$title_conditions[] = "{$wpdb->posts}.post_title LIKE %s";
		$title_values[]     = '%' . $wpdb->esc_like( $token ) . '%';
	}

	$people_sql = "
		SELECT DISTINCT {$wpdb->posts}.ID
		FROM {$wpdb->posts}
		WHERE {$wpdb->posts}.post_type = 'people'
		AND {$wpdb->posts}.post_status = 'publish'
		AND " . implode( ' AND ', $title_conditions );

	$person_ids = array_map(
		'intval',
		$wpdb->get_col(
			$wpdb->prepare(
				$people_sql,
				...$title_values
			)
		)
	);

	if ( empty( $person_ids ) ) {
		return [];
	}

	$person_ids_sql = implode(
		',',
		array_map( 'intval', $person_ids )
	);

	$team_meta_key_like =
		$wpdb->esc_like( 'team_memberships' ) . '\\_%\\_team';

	$laboratory_meta_key_like =
		$wpdb->esc_like( 'laboratory_memberships' ) . '\\_%\\_laboratory';

	$unit_ids = array_map(
		'intval',
		$wpdb->get_col(
			$wpdb->prepare(
				"
				SELECT DISTINCT unit.ID
				FROM {$wpdb->postmeta} membership
				INNER JOIN {$wpdb->posts} unit
					ON unit.ID = CAST(membership.meta_value AS UNSIGNED)
				WHERE membership.post_id IN ($person_ids_sql)
				AND unit.post_status = 'publish'
				AND (
					(
						membership.meta_key LIKE %s
						AND unit.post_type = 'teams'
					)
					OR (
						membership.meta_key LIKE %s
						AND unit.post_type = 'laboratories'
					)
				)
				",
				$team_meta_key_like,
				$laboratory_meta_key_like
			)
		)
	);

	/*
	 * Relations may point to the Polish unit. Convert every related unit
	 * to its translation in the language of the current search page.
	 */
	if (
		! empty( $unit_ids ) &&
		function_exists( 'pll_current_language' ) &&
		function_exists( 'pll_get_post' )
	) {
		$current_language = (string) pll_current_language( 'slug' );

		if ( '' !== $current_language ) {
			$translated_unit_ids = [];

			foreach ( $unit_ids as $unit_id ) {
				$translated_id = (int) pll_get_post(
					$unit_id,
					$current_language
				);

				if ( $translated_id <= 0 ) {
					continue;
				}

				if ( 'publish' !== get_post_status( $translated_id ) ) {
					continue;
				}

				if (
					! in_array(
						get_post_type( $translated_id ),
						[ 'teams', 'laboratories' ],
						true
					)
				) {
					continue;
				}

				$translated_unit_ids[] = $translated_id;
			}

			$unit_ids = $translated_unit_ids;
		}
	}

	return array_values(
		array_unique(
			array_filter(
				array_map( 'intval', $unit_ids )
			)
		)
	);
}

/**
 * Apply search post types to main frontend search query.
 */
function inlife_filter_main_search_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$query->set( 'post_type', inlife_get_search_post_types() );
	$query->set( 'post_status', 'publish' );
	$query->set( 'posts_per_page', 12 );
}
add_action( 'pre_get_posts', 'inlife_filter_main_search_query' );

/**
 * Human readable post type label for search results.
 */
function inlife_get_search_type_label( int $post_id ): string {
	$post_type = get_post_type( $post_id );

	$labels = [
		'post'         => inlife_t( 'Aktualność' ),
		'page'         => inlife_t( 'Strona' ),
		'teams'        => inlife_t( 'Zespół badawczy' ),
		'laboratories' => inlife_t( 'Laboratorium' ),
		'projects'     => inlife_t( 'Projekt' ),
		'publications' => inlife_t( 'Publikacja' ),
		'career_entry' => inlife_t( 'Kariera' ),
		'partners'     => inlife_t( 'Partner' ),
	];

	return $labels[ $post_type ] ?? inlife_t( 'Wynik' );
}

/**
 * Search result summary.
 */
function inlife_get_search_result_summary( int $post_id ): string {
	$post_type = get_post_type( $post_id );

	if ( 'publications' === $post_type ) {
		$citation = function_exists( 'get_field' ) ? get_field( 'publication_citation', $post_id ) : '';
		$authors  = function_exists( 'get_field' ) ? get_field( 'publication_authors', $post_id ) : '';
		$source   = function_exists( 'get_field' ) ? get_field( 'publication_source', $post_id ) : '';

		return wp_strip_all_tags( $citation ?: trim( $authors . ' ' . $source ) );
	}

	if ( 'partners' === $post_type ) {
		$location = function_exists( 'get_field' ) ? get_field( 'partner_location', $post_id ) : '';
		return wp_strip_all_tags( $location );
	}

	if ( has_excerpt( $post_id ) ) {
		return wp_strip_all_tags( get_the_excerpt( $post_id ) );
	}

	$content = get_post_field( 'post_content', $post_id );

	return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $content ) ), 28 );
}

/**
 * Optional secondary meta line.
 */
function inlife_get_search_result_meta( int $post_id ): string {
	$post_type = get_post_type( $post_id );

	if ( 'post' === $post_type || 'career_entry' === $post_type ) {
		return get_the_date( '', $post_id );
	}

	if ( 'projects' === $post_type ) {
		$terms = get_the_terms( $post_id, 'project_type' );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			return $terms[0]->name;
		}
	}

	return '';
}

/**
 * Links to publication pages.
 */
function inlife_get_search_result_url( int $post_id ): string {
	$post_type = get_post_type( $post_id );

	if ( 'publications' === $post_type ) {
		$archive_url = home_url( '/badania/publikacje/' );

		$search_query = get_search_query();

		if ( $search_query ) {
			$archive_url = add_query_arg(
				[
					'publication_search' => rawurlencode( $search_query ),
				],
				$archive_url
			);
		}

		return $archive_url;
	}

	return get_permalink( $post_id );
}

/**
 * Extend search into selected ACF/meta fields.
 */
function inlife_search_join_postmeta( $join, WP_Query $query ) {
	global $wpdb;

	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return $join;
	}

	if ( false === strpos( $join, $wpdb->postmeta ) ) {
		$join .= " LEFT JOIN {$wpdb->postmeta} AS inlife_search_meta ON ({$wpdb->posts}.ID = inlife_search_meta.post_id)";
	}

	return $join;
}
add_filter( 'posts_join', 'inlife_search_join_postmeta', 10, 2 );

/**
 * Extend search WHERE clause for selected ACF/meta fields.
 */
function inlife_search_meta_where( $where, WP_Query $query ) {
	global $wpdb;

	if (
		is_admin() ||
		! $query->is_main_query() ||
		! $query->is_search()
	) {
		return $where;
	}

	$search_term = trim( (string) $query->get( 's' ) );

	if ( '' === $search_term ) {
		return $where;
	}

	$post_types = array_map(
		'esc_sql',
		inlife_get_search_post_types()
	);

	$post_types_sql = "'" . implode(
		"','",
		$post_types
	) . "'";

	/*
	 * Ordinary, non-repeater ACF fields.
	 */
	$meta_keys = [
		'publication_citation',
		'publication_authors',
		'publication_title_full',
		'publication_source',
		'publication_doi',
		'partner_location',
		'project_subtitle',
	];

	$meta_keys_sql = "'" . implode(
		"','",
		array_map( 'esc_sql', $meta_keys )
	) . "'";

	/*
	 * Dynamic ACF repeater keys.
	 *
	 * Examples:
	 * about_directorate_0_name
	 * structure_sections_0_section_items_2_item_name
	 */
	$meta_key_patterns = [
		$wpdb->esc_like( 'about_directorate_' )
			. '%'
			. $wpdb->esc_like( '_name' ),

		$wpdb->esc_like( 'about_directorate_' )
			. '%'
			. $wpdb->esc_like( '_role' ),

		$wpdb->esc_like( 'structure_sections_' )
			. '%'
			. $wpdb->esc_like( '_section_title' ),

		$wpdb->esc_like( 'structure_sections_' )
			. '%'
			. $wpdb->esc_like( '_section_items_' )
			. '%'
			. $wpdb->esc_like( '_item_title' ),

		$wpdb->esc_like( 'structure_sections_' )
			. '%'
			. $wpdb->esc_like( '_section_items_' )
			. '%'
			. $wpdb->esc_like( '_item_name' ),

		$wpdb->esc_like( 'structure_sections_' )
			. '%'
			. $wpdb->esc_like( '_section_items_' )
			. '%'
			. $wpdb->esc_like( '_item_position' ),
	];

	$meta_key_conditions = [
		"inlife_search_meta.meta_key IN ($meta_keys_sql)",
	];

	$prepare_values = [];

	foreach ( $meta_key_patterns as $meta_key_pattern ) {
		$meta_key_conditions[] = 'inlife_search_meta.meta_key LIKE %s';
		$prepare_values[]      = $meta_key_pattern;
	}

	/*
	 * Require every entered word, but do not require the same word order.
	 */
	$search_tokens = preg_split(
		'/\s+/u',
		$search_term,
		-1,
		PREG_SPLIT_NO_EMPTY
	);

	$search_tokens = array_values(
		array_unique(
			array_filter(
				array_map( 'trim', (array) $search_tokens )
			)
		)
	);

	$meta_value_conditions = [];

	foreach ( $search_tokens as $token ) {
		$meta_value_conditions[] =
			'inlife_search_meta.meta_value LIKE %s';

		$prepare_values[] =
			'%' . $wpdb->esc_like( $token ) . '%';
	}

	$language_condition = '';
	$current_language    = '';

	if ( function_exists( 'pll_current_language' ) ) {
		$current_language = (string) pll_current_language( 'slug' );

		if ( '' !== $current_language ) {
			$language_condition = "
				AND EXISTS (
					SELECT 1
					FROM {$wpdb->term_relationships} inlife_search_language_rel
					INNER JOIN {$wpdb->term_taxonomy} inlife_search_language_tax
						ON inlife_search_language_tax.term_taxonomy_id =
							inlife_search_language_rel.term_taxonomy_id
					INNER JOIN {$wpdb->terms} inlife_search_language_term
						ON inlife_search_language_term.term_id =
							inlife_search_language_tax.term_id
					WHERE inlife_search_language_rel.object_id =
						{$wpdb->posts}.ID
					AND inlife_search_language_tax.taxonomy = 'language'
					AND inlife_search_language_term.slug = %s
				)
			";
		}
	}

	if ( ! empty( $meta_value_conditions ) ) {
		$meta_prepare_values = $prepare_values;

		if ( '' !== $language_condition ) {
			$meta_prepare_values[] = $current_language;
		}

		$where .= $wpdb->prepare(
			"
			OR (
				{$wpdb->posts}.post_type IN ($post_types_sql)
				AND {$wpdb->posts}.post_status = 'publish'
				AND (
					" . implode( ' OR ', $meta_key_conditions ) . "
				)
				AND (
					" . implode( ' AND ', $meta_value_conditions ) . "
				)
				{$language_condition}
			)
			",
			...$meta_prepare_values
		);
	}

	/*
	 * Add teams and laboratories indirectly matched through People.
	 */
	$related_unit_ids = inlife_get_search_related_unit_ids(
		$search_term
	);

	if ( ! empty( $related_unit_ids ) ) {
		$related_unit_ids_sql = implode(
			',',
			array_map( 'intval', $related_unit_ids )
		);

		$related_units_where = "
			OR (
				{$wpdb->posts}.ID IN ($related_unit_ids_sql)
				AND {$wpdb->posts}.post_type IN ('teams', 'laboratories')
				AND {$wpdb->posts}.post_status = 'publish'
				{$language_condition}
			)
		";

		if ( '' !== $language_condition ) {
			$where .= $wpdb->prepare(
				$related_units_where,
				$current_language
			);
		} else {
			$where .= $related_units_where;
		}
	}

	return $where;
}

add_filter( 'posts_where', 'inlife_search_meta_where', 10, 2 );

/**
 * Prevent duplicate search results caused by postmeta joins.
 */
function inlife_search_distinct( $distinct, WP_Query $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return $distinct;
	}

	return 'DISTINCT';
}
add_filter( 'posts_distinct', 'inlife_search_distinct', 10, 2 );

/**
 * Prioritize important content types in search.
 */
function inlife_search_orderby( $orderby, WP_Query $query ) {
	global $wpdb;

	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return $orderby;
	}

	return "
		CASE {$wpdb->posts}.post_type
			WHEN 'page' THEN 1
			WHEN 'teams' THEN 2
			WHEN 'laboratories' THEN 3
			WHEN 'projects' THEN 4
			WHEN 'post' THEN 5
			WHEN 'career_entry' THEN 6
			WHEN 'partners' THEN 7
			WHEN 'publications' THEN 8
			ELSE 99
		END,
		{$wpdb->posts}.post_date DESC
	";
}
add_filter( 'posts_orderby', 'inlife_search_orderby', 10, 2 );