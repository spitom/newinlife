<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_people_by_laboratory' ) ) {
	function inlife_get_people_by_laboratory( int $laboratory_id ): array {
		global $wpdb;

		$meta_key_like = $wpdb->esc_like( 'laboratory_memberships' ) . '\_%\_laboratory';

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
			(string) $laboratory_id
		);

		return array_map( 'intval', $wpdb->get_col( $sql ) );
	}
}

if ( ! function_exists( 'inlife_get_laboratory_manager' ) ) {
	function inlife_get_laboratory_manager( int $laboratory_id ): ?int {
		$people_ids = inlife_get_people_by_laboratory( $laboratory_id );

		foreach ( $people_ids as $person_id ) {
			if ( have_rows( 'laboratory_memberships', $person_id ) ) {
				while ( have_rows( 'laboratory_memberships', $person_id ) ) : the_row();

					if (
						(int) get_sub_field( 'laboratory' ) === $laboratory_id &&
						get_sub_field( 'is_laboratory_manager' )
					) {
						return $person_id;
					}

				endwhile;
			}
		}

		return null;
	}
}

if ( ! function_exists( 'inlife_get_laboratory_members' ) ) {
	function inlife_get_laboratory_members( int $laboratory_id ): array {
		$manager = inlife_get_laboratory_manager( $laboratory_id );
		$all     = inlife_get_people_by_laboratory( $laboratory_id );

		return array_values(
			array_filter(
				$all,
				static fn( $id ) => (int) $id !== (int) $manager
			)
		);
	}
}