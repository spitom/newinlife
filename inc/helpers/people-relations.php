<?php
defined( 'ABSPATH' ) || exit;

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

	return array_map( 'intval', $wpdb->get_col( $sql ) );
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
	function inlife_get_person_display_name( int $person_id ): string {
		$name  = get_the_title( $person_id );
		$title = function_exists( 'get_field' ) ? get_field( 'person_academic_title', $person_id ) : '';

		$title = is_string( $title ) ? trim( $title ) : '';
		$name  = is_string( $name ) ? trim( $name ) : '';

		if ( '' === $title ) {
			return $name;
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