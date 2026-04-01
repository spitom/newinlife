<?php
/**
 * Publications helpers.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_publication_year_overview' ) ) {
	/**
	 * Get available publication years with counts.
	 *
	 * @return array<int, array{year:string,count:int}>
	 */
	function inlife_get_publication_year_overview() {
		$posts = get_posts(
			array(
				'post_type'              => 'publications',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'fields'                 => 'ids',
				'lang'                   => '',
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);

		if ( empty( $posts ) ) {
			return array();
		}

		$years = array();

		foreach ( $posts as $post_id ) {
			$year = get_field( 'publication_year', $post_id );

			if ( empty( $year ) ) {
				continue;
			}

			$year = (string) $year;

			if ( ! isset( $years[ $year ] ) ) {
				$years[ $year ] = 0;
			}

			$years[ $year ]++;
		}

		if ( empty( $years ) ) {
			return array();
		}

		krsort( $years, SORT_NATURAL );

		$result = array();

		foreach ( $years as $year => $count ) {
			$result[] = array(
				'year'  => $year,
				'count' => (int) $count,
			);
		}

		return $result;
	}
}

if ( ! function_exists( 'inlife_get_publications_by_year' ) ) {
	/**
	 * Get publications for a specific year.
	 *
	 * @param string|int $year Year.
	 * @return array
	 */
	function inlife_get_publications_by_year( $year ) {
		$year = (string) $year;

		if ( '' === $year ) {
			return array();
		}

		return get_posts(
			array(
				'post_type'              => 'publications',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'meta_key'               => 'publication_year',
				'meta_value'             => $year,
				'orderby'                => array(
					'title' => 'ASC',
				),
				'order'                  => 'ASC',
				'lang'                   => '',
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);
	}
}

if ( ! function_exists( 'inlife_get_publication_year_from_page_title' ) ) {
	/**
	 * Try to extract 4-digit year from current page title.
	 *
	 * @param int|null $post_id Optional page ID.
	 * @return string
	 */
	function inlife_get_publication_year_from_page_title( $post_id = null ) {
		$post_id = $post_id ? (int) $post_id : get_the_ID();
		$title   = get_the_title( $post_id );

		if ( preg_match( '/\b(19|20)\d{2}\b/', (string) $title, $matches ) ) {
			return $matches[0];
		}

		return '';
	}
}

/**
 * Get grouped publications for a specific team.
 *
 * @param int         $team_id Team ID.
 * @param string|null $year Optional year filter.
 * @return array
 */
if ( ! function_exists( 'inlife_get_team_grouped_publications' ) ) {
	function inlife_get_team_grouped_publications( $team_id, $year = null ) {
		$team_id = (int) $team_id;

		if ( ! $team_id ) {
			return array();
		}

		$meta_query = array(
			array(
				'key'     => 'publication_teams',
				'value'   => '"' . $team_id . '"',
				'compare' => 'LIKE',
			),
		);

		if ( ! empty( $year ) ) {
			$meta_query[] = array(
				'key'   => 'publication_year',
				'value' => (string) $year,
			);
		}

		$posts = get_posts(
			array(
				'post_type'              => 'publications',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'meta_query'             => $meta_query,
				'orderby'                => array(
					'meta_value_num' => 'DESC',
					'title'          => 'ASC',
				),
				'meta_key'               => 'publication_year',
				'meta_type'              => 'NUMERIC',
				'lang'                   => '',
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);

		if ( empty( $posts ) ) {
			return array();
		}

		$grouped = array();

		foreach ( $posts as $post ) {
			$post_year = get_field( 'publication_year', $post->ID );
			$post_year = $post_year ? (string) $post_year : '—';

			if ( ! isset( $grouped[ $post_year ] ) ) {
				$grouped[ $post_year ] = array();
			}

			$grouped[ $post_year ][] = $post;
		}

		krsort( $grouped, SORT_NATURAL );

		return $grouped;
	}
}

/**
 * Get available publication years for a team.
 *
 * @param int $team_id Team ID.
 * @return array
 */
if ( ! function_exists( 'inlife_get_team_publication_years' ) ) {
	function inlife_get_team_publication_years( $team_id ) {
		$grouped = inlife_get_team_grouped_publications( $team_id );

		if ( empty( $grouped ) ) {
			return array();
		}

		return array_keys( $grouped );
	}
}

/**
 * Get current publications year filter from query var.
 *
 * @return string
 */
if ( ! function_exists( 'inlife_get_current_team_publication_year_filter' ) ) {
	function inlife_get_current_team_publication_year_filter() {
		if ( empty( $_GET['pub_year'] ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_GET['pub_year'] ) );
	}
}