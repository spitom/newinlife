<?php
/**
 * People relations helpers (ACF-based).
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_person_team_memberships' ) ) {
	/**
	 * Get normalized team memberships for a person.
	 *
	 * ACF structure:
	 * repeater: team_memberships
	 *  - team (post object -> teams)
	 *  - is_team_leader (true/false)
	 *
	 * @param int $person_id
	 * @return array<int, array{
	 *   team_id:int,
	 *   is_team_leader:bool,
	 *   row_index:int
	 * }>
	 */
	function inlife_get_person_team_memberships( int $person_id ): array {

		if ( $person_id <= 0 || ! function_exists( 'get_field' ) ) {
			return array();
		}

		$rows = get_field( 'team_memberships', $person_id );

		if ( empty( $rows ) || ! is_array( $rows ) ) {
			return array();
		}

		$memberships = array();

		foreach ( $rows as $index => $row ) {

			$team_value = $row['team'] ?? null;

			if ( empty( $team_value ) ) {
				continue;
			}

			$team_id = is_object( $team_value )
				? (int) $team_value->ID
				: (int) $team_value;

			if ( $team_id <= 0 ) {
				continue;
			}

			$memberships[] = array(
				'team_id'        => $team_id,
				'is_team_leader' => ! empty( $row['is_team_leader'] ),
				'row_index'      => (int) $index,
			);
		}

		return $memberships;
	}
}

if ( ! function_exists( 'inlife_get_person_teams' ) ) {
	/**
	 * Get WP_Post objects of teams for a person.
	 *
	 * @param int $person_id
	 * @return WP_Post[]
	 */
	function inlife_get_person_teams( int $person_id ): array {

		$memberships = inlife_get_person_team_memberships( $person_id );

		if ( empty( $memberships ) ) {
			return array();
		}

		$team_ids = array();

		foreach ( $memberships as $membership ) {
			if ( ! empty( $membership['team_id'] ) ) {
				$team_ids[] = (int) $membership['team_id'];
			}
		}

		$team_ids = array_values( array_unique( $team_ids ) );

		if ( empty( $team_ids ) ) {
			return array();
		}

		$teams = get_posts(
			array(
				'post_type'      => 'teams',
				'post_status'    => 'publish',
				'post__in'       => $team_ids,
				'posts_per_page' => -1,
				'orderby'        => 'post__in',
			)
		);

		return is_array( $teams ) ? $teams : array();
	}
}

if ( ! function_exists( 'inlife_is_person_leader_in_team' ) ) {
	/**
	 * Check if person is leader in given team.
	 *
	 * @param int $person_id
	 * @param int $team_id
	 * @return bool
	 */
	function inlife_is_person_leader_in_team( int $person_id, int $team_id ): bool {

		$memberships = inlife_get_person_team_memberships( $person_id );

		foreach ( $memberships as $membership ) {

			if ( (int) $membership['team_id'] !== $team_id ) {
				continue;
			}

			return ! empty( $membership['is_team_leader'] );
		}

		return false;
	}
}

if ( ! function_exists( 'inlife_get_person_laboratory_memberships' ) ) {
	/**
	 * Get normalized laboratory memberships for a person.
	 *
	 * ACF structure:
	 * repeater: laboratory_memberships
	 *  - laboratory (post object -> laboratories)
	 *  - is_laboratory_manager (true/false)
	 *
	 * @param int $person_id
	 * @return array<int, array{
	 *   laboratory_id:int,
	 *   is_manager:bool,
	 *   row_index:int
	 * }>
	 */
	function inlife_get_person_laboratory_memberships( int $person_id ): array {

		if ( $person_id <= 0 || ! function_exists( 'get_field' ) ) {
			return array();
		}

		$rows = get_field( 'laboratory_memberships', $person_id );

		if ( empty( $rows ) || ! is_array( $rows ) ) {
			return array();
		}

		$memberships = array();

		foreach ( $rows as $index => $row ) {

			$lab_value = $row['laboratory'] ?? null;

			if ( empty( $lab_value ) ) {
				continue;
			}

			$lab_id = is_object( $lab_value )
				? (int) $lab_value->ID
				: (int) $lab_value;

			if ( $lab_id <= 0 ) {
				continue;
			}

			$memberships[] = array(
				'laboratory_id' => $lab_id,
				'is_manager'    => ! empty( $row['is_laboratory_manager'] ),
				'row_index'     => (int) $index,
			);
		}

		return $memberships;
	}
}

if ( ! function_exists( 'inlife_is_person_manager_in_laboratory' ) ) {
	/**
	 * Check if person is manager in given laboratory.
	 *
	 * @param int $person_id
	 * @param int $lab_id
	 * @return bool
	 */
	function inlife_is_person_manager_in_laboratory( int $person_id, int $lab_id ): bool {

		$memberships = inlife_get_person_laboratory_memberships( $person_id );

		foreach ( $memberships as $membership ) {

			if ( (int) $membership['laboratory_id'] !== $lab_id ) {
				continue;
			}

			return ! empty( $membership['is_manager'] );
		}

		return false;
	}
}