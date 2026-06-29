<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_filter_people_ids_by_current_language' ) ) {
	/**
	 * Keep only People posts assigned to the current Polylang language.
	 *
	 * When Polylang is inactive, returns the original IDs unchanged.
	 *
	 * @param int[] $people_ids People post IDs.
	 *
	 * @return int[]
	 */
	function inlife_filter_people_ids_by_current_language( array $people_ids ): array {
		$people_ids = array_values(
			array_unique(
				array_filter(
					array_map( 'intval', $people_ids )
				)
			)
		);

		if (
			empty( $people_ids ) ||
			! function_exists( 'pll_current_language' ) ||
			! function_exists( 'pll_get_post_language' )
		) {
			return $people_ids;
		}

		$current_language = (string) pll_current_language( 'slug' );

		if ( '' === $current_language ) {
			return $people_ids;
		}

		return array_values(
			array_filter(
				$people_ids,
				static function ( int $person_id ) use ( $current_language ): bool {
					return $current_language === (string) pll_get_post_language(
						$person_id,
						'slug'
					);
				}
			)
		);
	}
}

function inlife_get_people_by_team( int $team_id ): array {
	global $wpdb;

	$meta_key_like = $wpdb->esc_like( 'team_memberships' ) . '\_%\_team';

	$sql = $wpdb->prepare(
		"
		SELECT DISTINCT pm.post_id
		FROM {$wpdb->postmeta} pm
		INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
		WHERE p.post_type = 'people'
		AND p.post_status = 'publish'
		AND pm.meta_key LIKE %s
		AND pm.meta_value = %s
		",
		$meta_key_like,
		(string) $team_id
	);

	$people_ids = array_map( 'intval', $wpdb->get_col( $sql ) );

	return inlife_filter_people_ids_by_current_language( $people_ids );
}

function inlife_get_team_leader( int $team_id ): ?int {
	$people_ids = inlife_get_people_by_team( $team_id );

	foreach ( $people_ids as $person_id ) {
		if ( have_rows( 'team_memberships', $person_id ) ) {
			while ( have_rows( 'team_memberships', $person_id ) ) : the_row();

				if (
					(int) get_sub_field( 'team' ) === $team_id &&
					get_sub_field( 'is_team_leader' )
				) {
					return $person_id;
				}

			endwhile;
		}
	}

	return null;
}

function inlife_get_team_members( int $team_id ): array {
	$leader = inlife_get_team_leader( $team_id );
	$all    = inlife_get_people_by_team( $team_id );

	return array_values(
		array_filter( $all, fn( $id ) => $id !== $leader )
	);
}

if ( ! function_exists( 'inlife_get_person_display_name' ) ) {
	/**
	 * Return a person's display name with language-appropriate
	 * academic-title placement.
	 *
	 * PL: dr hab. Kowalik Magdalena
	 * EN: Magdalena Kowalik, Ph.D., D.Sc.
	 *
	 * @param int $person_id Person post ID.
	 *
	 * @return string
	 */
	function inlife_get_person_display_name( int $person_id ): string {
		$name  = get_the_title( $person_id );
		$title = function_exists( 'get_field' )
			? get_field( 'person_academic_title', $person_id )
			: '';

		$name  = is_string( $name ) ? trim( $name ) : '';
		$title = is_string( $title ) ? trim( $title ) : '';

		if ( '' === $title ) {
			return $name;
		}

		$language = function_exists( 'pll_get_post_language' )
			? (string) pll_get_post_language( $person_id, 'slug' )
			: '';

		if ( 'en' === $language ) {
			return trim( $name . ', ' . $title );
		}

		return trim( $title . ' ' . $name );
	}
}


if ( ! function_exists( 'inlife_get_person_team_memberships' ) ) {
	/**
	 * Get normalized team memberships for a given person.
	 *
	 * Source of truth:
	 * people -> team_memberships (repeater)
	 *   - team (post object -> teams)
	 *   - is_team_leader (true/false)
	 *
	 * Returns normalized rows:
	 * [
	 *   [
	 *     'team_id'        => 123,
	 *     'is_team_leader' => true,
	 *   ],
	 * ]
	 *
	 * @param int $person_id Person post ID.
	 * @return array<int, array{team_id:int, is_team_leader:bool}>
	 */
	function inlife_get_person_team_memberships( int $person_id ): array {
		if ( $person_id <= 0 ) {
			return array();
		}

		if ( ! function_exists( 'have_rows' ) ) {
			return array();
		}

		if ( ! have_rows( 'team_memberships', $person_id ) ) {
			return array();
		}

		$memberships = array();

		while ( have_rows( 'team_memberships', $person_id ) ) {
			the_row();

			$team = get_sub_field( 'team' );

			$team_id = 0;

			if ( $team instanceof WP_Post ) {
				$team_id = (int) $team->ID;
			} elseif ( is_array( $team ) && ! empty( $team['ID'] ) ) {
				$team_id = (int) $team['ID'];
			} elseif ( is_numeric( $team ) ) {
				$team_id = (int) $team;
			}

			if ( $team_id <= 0 ) {
				continue;
			}

			$memberships[] = array(
				'team_id'        => $team_id,
				'is_team_leader' => (bool) get_sub_field( 'is_team_leader' ),
			);
		}

		return $memberships;
	}
}