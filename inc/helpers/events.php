<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_event_start_date' ) ) {
	function inlife_get_event_start_date( int $post_id ): string {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$start_date = get_field( 'event_start_date', $post_id );

		return is_string( $start_date )
			? trim( $start_date )
			: '';
	}
}

if ( ! function_exists( 'inlife_get_event_status' ) ) {
	function inlife_get_event_status( int $post_id ): array {
		$status = function_exists( 'get_field' )
			? (string) get_field( 'event_status', $post_id )
			: '';

		$statuses = [
			'scheduled' => inlife_t( 'Zaplanowane' ),
			'cancelled' => inlife_t( 'Odwołane' ),
			'postponed' => inlife_t( 'Przełożone' ),
		];

		if ( ! isset( $statuses[ $status ] ) ) {
			$status = 'scheduled';
		}

		return [
			'value' => $status,
			'label' => $statuses[ $status ],
		];
	}
}

if ( ! function_exists( 'inlife_get_upcoming_events' ) ) {
	function inlife_get_upcoming_events( int $limit = 6 ): WP_Query {
		$today = current_time( 'Ymd' );

		return new WP_Query(
			[
				'post_type'      => 'events',
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'no_found_rows'  => true,
                'orderby' => [
                    'event_start_date_clause' => 'ASC',
                ],
				'meta_query'     => [
					'relation' => 'AND',

					'event_start_date_clause' => [
                        'key'     => 'event_start_date',
                        'compare' => 'EXISTS',
                        'type'    => 'NUMERIC',
                    ],

					[
						'relation' => 'OR',

						[
							'key'     => 'event_end_date',
							'value'   => $today,
							'compare' => '>=',
							'type'    => 'NUMERIC',
						],

						[
							'relation' => 'AND',
							[
								'key'     => 'event_end_date',
								'value'   => '',
								'compare' => '=',
							],
							[
								'key'     => 'event_start_date',
								'value'   => $today,
								'compare' => '>=',
								'type'    => 'NUMERIC',
							],
						],

						[
							'relation' => 'AND',
							[
								'key'     => 'event_end_date',
								'compare' => 'NOT EXISTS',
							],
							[
								'key'     => 'event_start_date',
								'value'   => $today,
								'compare' => '>=',
								'type'    => 'NUMERIC',
							],
						],
					],
				],
			]
		);
	}
}

if ( ! function_exists( 'inlife_get_events_for_type' ) ) {
	function inlife_get_events_for_type( string $term_slug ): WP_Query {
		return new WP_Query(
			[
				'post_type'      => 'events',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
				'meta_query'     => [
					'event_start_date_clause' => [
						'key'     => 'event_start_date',
						'compare' => 'EXISTS',
						'type'    => 'NUMERIC',
					],
				],
				'orderby'        => [
					'event_start_date_clause' => 'DESC',
				],
				'tax_query'      => [
					[
						'taxonomy' => 'event_type',
						'field'    => 'slug',
						'terms'    => $term_slug,
					],
				],
			]
		);
	}
}

add_action( 'template_redirect', 'inlife_redirect_event_single_to_archive' );

function inlife_redirect_event_single_to_archive(): void {
	if ( ! is_singular( 'events' ) ) {
		return;
	}

	$archive_url = get_post_type_archive_link( 'events' );

	if ( ! $archive_url ) {
		return;
	}

	wp_safe_redirect( $archive_url, 301 );
	exit;
}