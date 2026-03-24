<?php
/**
 * Team helpers.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_people_ids_by_team' ) ) {
	/**
	 * Get raw people IDs assigned to a given team via ACF repeater in People CPT.
	 *
	 * Source of truth:
	 * people -> team_memberships (repeater)
	 *   - team (post object -> teams)
	 *   - is_team_leader (true/false)
	 *
	 * @param int $team_id Team post ID.
	 * @return int[]
	 */
	function inlife_get_people_ids_by_team( int $team_id ): array {
		global $wpdb;

		if ( $team_id <= 0 ) {
			return array();
		}

		$meta_key_like = $wpdb->esc_like( 'team_memberships_' ) . '%_team';

		$sql = $wpdb->prepare(
			"
			SELECT DISTINCT p.ID
			FROM {$wpdb->posts} p
			INNER JOIN {$wpdb->postmeta} pm
				ON p.ID = pm.post_id
			WHERE p.post_type = %s
				AND p.post_status = %s
				AND pm.meta_key LIKE %s
				AND CAST(pm.meta_value AS UNSIGNED) = %d
			ORDER BY p.menu_order ASC, p.post_title ASC
			",
			'people',
			'publish',
			$meta_key_like,
			$team_id
		);

		$results = $wpdb->get_col( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		if ( empty( $results ) ) {
			return array();
		}

		return array_map( 'intval', $results );
	}
}

if ( ! function_exists( 'inlife_get_team_people' ) ) {
	/**
	 * Get structured people data for a team.
	 *
	 * Requires base helper:
	 * inlife_get_person_team_memberships()
	 * from inc/helpers/people-relations.php
	 *
	 * Returns:
	 * - leader: WP_Post|null
	 * - additional_leaders: WP_Post[]
	 * - members: WP_Post[]
	 * - all: WP_Post[]
	 *
	 * @param int $team_id Team post ID.
	 * @return array{
	 *   leader:?WP_Post,
	 *   additional_leaders:WP_Post[],
	 *   members:WP_Post[],
	 *   all:WP_Post[]
	 * }
	 */
	function inlife_get_team_people( int $team_id ): array {
		$data = array(
			'leader'             => null,
			'additional_leaders' => array(),
			'members'            => array(),
			'all'                => array(),
		);

		if ( $team_id <= 0 ) {
			return $data;
		}

		if ( ! function_exists( 'inlife_get_person_team_memberships' ) ) {
			return $data;
		}

		$person_ids = inlife_get_people_ids_by_team( $team_id );

		if ( empty( $person_ids ) ) {
			return $data;
		}

		$leaders = array();
		$members = array();
		$all     = array();

		foreach ( $person_ids as $person_id ) {
			$person_post = get_post( $person_id );

			if ( ! $person_post instanceof WP_Post || 'publish' !== $person_post->post_status ) {
				continue;
			}

			$all[] = $person_post;

			$memberships = inlife_get_person_team_memberships( $person_id );
			$is_leader   = false;

			foreach ( $memberships as $membership ) {
				$membership_team_id = isset( $membership['team_id'] ) ? (int) $membership['team_id'] : 0;

				if ( $membership_team_id !== $team_id ) {
					continue;
				}

				$is_leader = ! empty( $membership['is_team_leader'] );
				break;
			}

			if ( $is_leader ) {
				$leaders[] = $person_post;
			} else {
				$members[] = $person_post;
			}
		}

		if ( ! empty( $leaders ) ) {
			$data['leader'] = array_shift( $leaders );
		}

		$data['additional_leaders'] = $leaders;
		$data['members']            = $members;
		$data['all']                = $all;

		return $data;
	}
}

if ( ! function_exists( 'inlife_get_teams_for_person' ) ) {
	/**
	 * Get teams assigned to a given person from ACF repeater.
	 *
	 * Requires base helper:
	 * inlife_get_person_team_memberships()
	 * from inc/helpers/people-relations.php
	 *
	 * @param int $person_id People post ID.
	 * @return WP_Post[]
	 */
	function inlife_get_teams_for_person( int $person_id ): array {
		if ( $person_id <= 0 ) {
			return array();
		}

		if ( ! function_exists( 'inlife_get_person_team_memberships' ) ) {
			return array();
		}

		$memberships = inlife_get_person_team_memberships( $person_id );

		if ( empty( $memberships ) ) {
			return array();
		}

		$team_ids = array();

		foreach ( $memberships as $membership ) {
			$team_id = isset( $membership['team_id'] ) ? (int) $membership['team_id'] : 0;

			if ( $team_id > 0 ) {
				$team_ids[] = $team_id;
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