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
		'people',
		'teams',
		'laboratories',
		'projects',
		'publications',
		'career_entry',
		'partners',
	];
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
		'people'       => inlife_t( 'Osoba' ),
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

	if ( 'people' === $post_type ) {
		$position = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';
		return wp_strip_all_tags( $position );
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

	if ( 'people' === $post_type && function_exists( 'inlife_get_people_type_label' ) ) {
		return inlife_get_people_type_label( $post_id );
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
 * Extend search WHERE clause for selected meta fields.
 */
function inlife_search_meta_where( $where, WP_Query $query ) {
	global $wpdb;

	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return $where;
	}

	$search_term = $query->get( 's' );

	if ( ! $search_term ) {
		return $where;
	}

	$like = '%' . $wpdb->esc_like( $search_term ) . '%';

	$post_types = array_map( 'esc_sql', inlife_get_search_post_types() );
	$post_types_sql = "'" . implode( "','", $post_types ) . "'";

	$meta_keys = [
		'publication_citation',
		'publication_authors',
		'publication_title_full',
		'publication_source',
		'publication_doi',
		'person_position',
		'person_specialization',
		'partner_location',
		'project_subtitle',
	];

	$meta_keys_sql = "'" . implode( "','", array_map( 'esc_sql', $meta_keys ) ) . "'";

	$where .= $wpdb->prepare(
		" OR (
			{$wpdb->posts}.post_type IN ($post_types_sql)
			AND {$wpdb->posts}.post_status = 'publish'
			AND inlife_search_meta.meta_key IN ($meta_keys_sql)
			AND inlife_search_meta.meta_value LIKE %s
		)",
		$like
	);

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
			WHEN 'people' THEN 2
			WHEN 'teams' THEN 3
			WHEN 'laboratories' THEN 4
			WHEN 'projects' THEN 5
			WHEN 'post' THEN 6
			WHEN 'career_entry' THEN 7
			WHEN 'partners' THEN 8
			WHEN 'publications' THEN 9
			ELSE 99
		END,
		{$wpdb->posts}.post_date DESC
	";
}
add_filter( 'posts_orderby', 'inlife_search_orderby', 10, 2 );