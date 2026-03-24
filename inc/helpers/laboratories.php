<?php
/**
 * Laboratory helpers.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_people_ids_by_laboratory' ) ) {
	/**
	 * Get people IDs assigned to a laboratory via ACF repeater.
	 *
	 * @param int $lab_id
	 * @return int[]
	 */
	function inlife_get_people_ids_by_laboratory( int $lab_id ): array {
		global $wpdb;

		if ( $lab_id <= 0 ) {
			return array();
		}

		$meta_key_like = $wpdb->esc_like( 'laboratory_memberships_' ) . '%_laboratory';

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
			$lab_id
		);

		$results = $wpdb->get_col( $sql ); // phpcs:ignore

		if ( empty( $results ) ) {
			return array();
		}

		return array_map( 'intval', $results );
	}
}

if ( ! function_exists( 'inlife_get_laboratory_people' ) ) {
	/**
	 * Get structured people for laboratory.
	 *
	 * @param int $lab_id
	 * @return array{
	 *   manager:?WP_Post,
	 *   members:WP_Post[],
	 *   all:WP_Post[]
	 * }
	 */
	function inlife_get_laboratory_people( int $lab_id ): array {

		$data = array(
			'manager' => null,
			'members' => array(),
			'all'     => array(),
		);

		if ( $lab_id <= 0 ) {
			return $data;
		}

		if ( ! function_exists( 'inlife_get_person_laboratory_memberships' ) ) {
			return $data;
		}

		$person_ids = inlife_get_people_ids_by_laboratory( $lab_id );

		if ( empty( $person_ids ) ) {
			return $data;
		}

		$managers = array();
		$members  = array();
		$all      = array();

		foreach ( $person_ids as $person_id ) {

			$post = get_post( $person_id );

			if ( ! $post instanceof WP_Post ) {
				continue;
			}

			$all[] = $post;

			$memberships = inlife_get_person_laboratory_memberships( $person_id );
			$is_manager  = false;

			foreach ( $memberships as $m ) {

				if ( (int) $m['laboratory_id'] !== $lab_id ) {
					continue;
				}

				$is_manager = ! empty( $m['is_manager'] );
				break;
			}

			if ( $is_manager ) {
				$managers[] = $post;
			} else {
				$members[] = $post;
			}
		}

		if ( ! empty( $managers ) ) {
			$data['manager'] = $managers[0]; // pierwszy
		}

		$data['members'] = $members;
		$data['all']     = $all;

		return $data;
	}
}

if ( ! function_exists( 'inlife_get_laboratories_for_person' ) ) {
	function inlife_get_laboratories_for_person( int $person_id ): array {

		if ( ! function_exists( 'inlife_get_person_laboratory_memberships' ) ) {
			return array();
		}

		$memberships = inlife_get_person_laboratory_memberships( $person_id );

		if ( empty( $memberships ) ) {
			return array();
		}

		$ids = array();

		foreach ( $memberships as $m ) {
			if ( ! empty( $m['laboratory_id'] ) ) {
				$ids[] = (int) $m['laboratory_id'];
			}
		}

		$ids = array_unique( $ids );

		if ( empty( $ids ) ) {
			return array();
		}

		return get_posts([
			'post_type' => 'laboratories',
			'post__in'  => $ids,
			'orderby'   => 'post__in',
			'posts_per_page' => -1,
		]);
	}
}