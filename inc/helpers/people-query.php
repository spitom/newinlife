<?php
/**
 * People archive query modifications
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_people_archive_candidate_ids_by_relation' ) ) {
	/**
	 * Returns candidate People IDs by ACF repeater subfield relation.
	 *
	 * @param string $repeater_field Repeater field name.
	 * @param string $subfield       Repeater subfield name.
	 * @param int    $related_id     Related object ID.
	 * @return int[]
	 */
	function inlife_get_people_archive_candidate_ids_by_relation( $repeater_field, $subfield, $related_id ) {
		global $wpdb;

		$related_id = (int) $related_id;

		if ( ! $repeater_field || ! $subfield || ! $related_id ) {
			return [];
		}

		$meta_key_like = $wpdb->esc_like( $repeater_field . '_' ) . '%_' . $wpdb->esc_like( $subfield );

		$sql = $wpdb->prepare(
			"
			SELECT DISTINCT pm.post_id
			FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE p.post_type = %s
				AND p.post_status = %s
				AND pm.meta_key LIKE %s
				AND pm.meta_value = %s
			",
			'people',
			'publish',
			$meta_key_like,
			(string) $related_id
		);

		$results = $wpdb->get_col( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		if ( empty( $results ) ) {
			return [];
		}

		return array_map( 'intval', $results );
	}
}

if ( ! function_exists( 'inlife_modify_people_archive_query' ) ) {
	/**
	 * Modifies People archive main query.
	 *
	 * @param WP_Query $query Query object.
	 * @return void
	 */
	function inlife_modify_people_archive_query( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( ! is_post_type_archive( 'people' ) ) {
			return;
		}

		$query->set( 'post_type', 'people' );
		$query->set( 'posts_per_page', 24 );
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );

		$meta_query = [
			[
				'key'     => 'person_show_in_directory',
				'value'   => '1',
				'compare' => '=',
			],
		];

		$tax_query = [];

		$current_type = isset( $_GET['people_type'] ) ? sanitize_text_field( wp_unslash( $_GET['people_type'] ) ) : '';
		$current_team = isset( $_GET['team'] ) ? (int) $_GET['team'] : 0;
		$current_lab  = isset( $_GET['lab'] ) ? (int) $_GET['lab'] : 0;

		if ( $current_type ) {
			$tax_query[] = [
				'taxonomy' => 'people_type',
				'field'    => 'slug',
				'terms'    => [ $current_type ],
			];
		}

		if ( ! empty( $tax_query ) ) {
			$query->set( 'tax_query', $tax_query );
		}

		/**
		 * Guard for pre-ACF stage:
		 * - archive still works,
		 * - people_type still works,
		 * - team/lab relation filters are skipped until ACF is available.
		 */
		if ( ! function_exists( 'get_field' ) ) {
			$query->set( 'meta_query', $meta_query );
			return;
		}

		$candidate_sets = [];

		if ( $current_team ) {
			$team_ids = inlife_get_people_archive_candidate_ids_by_relation(
				'team_memberships',
				'team',
				$current_team
			);

			$candidate_sets[] = $team_ids;
		}

		if ( $current_lab ) {
			$lab_ids = inlife_get_people_archive_candidate_ids_by_relation(
				'laboratory_memberships',
				'laboratory',
				$current_lab
			);

			$candidate_sets[] = $lab_ids;
		}

		if ( ! empty( $candidate_sets ) ) {
			$filtered_ids = array_shift( $candidate_sets );

			foreach ( $candidate_sets as $set_ids ) {
				$filtered_ids = array_intersect( $filtered_ids, $set_ids );
			}

			$filtered_ids = array_values( array_unique( array_map( 'intval', $filtered_ids ) ) );

			if ( empty( $filtered_ids ) ) {
				$filtered_ids = [ 0 ];
			}

			$query->set( 'post__in', $filtered_ids );
		}

		$query->set( 'meta_query', $meta_query );
	}
	add_action( 'pre_get_posts', 'inlife_modify_people_archive_query' );
}