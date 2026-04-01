<?php
/**
 * Publications admin enhancements.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add custom admin columns for publications.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function inlife_publications_admin_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $label ) {
		$new_columns[ $key ] = $label;

		if ( 'title' === $key ) {
			$new_columns['publication_year']   = __( 'Rok', 'newinlife-child' );
			$new_columns['publication_status'] = __( 'Status importu', 'newinlife-child' );
			$new_columns['publication_teams']  = __( 'Zespoły', 'newinlife-child' );
		}
	}

	return $new_columns;
}
add_filter( 'manage_publications_posts_columns', 'inlife_publications_admin_columns' );

/**
 * Render custom admin columns for publications.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 * @return void
 */
function inlife_publications_admin_column_content( $column, $post_id ) {
	if ( 'publication_year' === $column ) {
		$year = get_field( 'publication_year', $post_id );
		echo esc_html( $year ? $year : '—' );
		return;
	}

	if ( 'publication_status' === $column ) {
		$status = get_field( 'publication_import_status', $post_id );
		echo esc_html( $status ? $status : '—' );
		return;
	}

	if ( 'publication_teams' === $column ) {
		$team_ids = get_field( 'publication_teams', $post_id );

		if ( empty( $team_ids ) || ! is_array( $team_ids ) ) {
			echo '—';
			return;
		}

		$names = array();

		foreach ( $team_ids as $team_id ) {
			$title = get_the_title( $team_id );

			if ( $title ) {
				$names[] = $title;
			}
		}

		echo ! empty( $names ) ? esc_html( implode( ', ', $names ) ) : '—';
	}
}
add_action( 'manage_publications_posts_custom_column', 'inlife_publications_admin_column_content', 10, 2 );

/**
 * Make custom columns sortable.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function inlife_publications_sortable_columns( $columns ) {
	$columns['publication_year']   = 'publication_year';
	$columns['publication_status'] = 'publication_status';

	return $columns;
}
add_filter( 'manage_edit-publications_sortable_columns', 'inlife_publications_sortable_columns' );

/**
 * Handle sorting for custom publications columns.
 *
 * @param WP_Query $query Query instance.
 * @return void
 */
function inlife_publications_admin_orderby( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'publications' !== $query->get( 'post_type' ) ) {
		return;
	}

	$orderby = $query->get( 'orderby' );

	if ( 'publication_year' === $orderby ) {
		$query->set( 'meta_key', 'publication_year' );
		$query->set( 'orderby', 'meta_value_num' );
		return;
	}

	if ( 'publication_status' === $orderby ) {
		$query->set( 'meta_key', 'publication_import_status' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'inlife_publications_admin_orderby' );

/**
 * Add admin filters above publications list table.
 *
 * @param string $post_type Current post type.
 * @return void
 */
function inlife_publications_admin_filters( $post_type ) {
	if ( 'publications' !== $post_type ) {
		return;
	}

	$selected_year   = isset( $_GET['publication_year_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['publication_year_filter'] ) ) : '';
	$selected_status = isset( $_GET['publication_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['publication_status_filter'] ) ) : '';

	$years = get_posts(
		array(
			'post_type'      => 'publications',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'lang'           => '',
		)
	);

	$year_values = array();

	if ( ! empty( $years ) ) {
		foreach ( $years as $post_id ) {
			$year = get_field( 'publication_year', $post_id );

			if ( $year ) {
				$year_values[] = (string) $year;
			}
		}
	}

	$year_values = array_unique( $year_values );
	rsort( $year_values, SORT_NATURAL );

	$status_choices = array(
		'ok'                     => 'ok',
		'updated'                => 'updated',
		'missing_in_latest_import' => 'missing_in_latest_import',
		'error'                  => 'error',
	);

	echo '<select name="publication_year_filter">';
	echo '<option value="">' . esc_html__( 'Wszystkie lata', 'newinlife-child' ) . '</option>';

	foreach ( $year_values as $year ) {
		printf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $year ),
			selected( $selected_year, $year, false ),
			esc_html( $year )
		);
	}

	echo '</select>';

	echo '<select name="publication_status_filter">';
	echo '<option value="">' . esc_html__( 'Wszystkie statusy', 'newinlife-child' ) . '</option>';

	foreach ( $status_choices as $value => $label ) {
		printf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $value ),
			selected( $selected_status, $value, false ),
			esc_html( $label )
		);
	}

	echo '</select>';
}
add_action( 'restrict_manage_posts', 'inlife_publications_admin_filters' );

/**
 * Apply admin filters to publications query.
 *
 * @param WP_Query $query Query instance.
 * @return void
 */
function inlife_publications_apply_admin_filters( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'publications' !== $query->get( 'post_type' ) ) {
		return;
	}

	$meta_query = (array) $query->get( 'meta_query' );

	if ( ! empty( $_GET['publication_year_filter'] ) ) {
		$meta_query[] = array(
			'key'   => 'publication_year',
			'value' => sanitize_text_field( wp_unslash( $_GET['publication_year_filter'] ) ),
		);
	}

	if ( ! empty( $_GET['publication_status_filter'] ) ) {
		$meta_query[] = array(
			'key'   => 'publication_import_status',
			'value' => sanitize_text_field( wp_unslash( $_GET['publication_status_filter'] ) ),
		);
	}

	if ( ! empty( $meta_query ) ) {
		$query->set( 'meta_query', $meta_query );
	}
}
add_action( 'pre_get_posts', 'inlife_publications_apply_admin_filters' );

/**
 * Set better default ordering for publications admin list.
 *
 * @param WP_Query $query Query instance.
 * @return void
 */
function inlife_publications_default_admin_order( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'publications' !== $query->get( 'post_type' ) ) {
		return;
	}

	if ( isset( $_GET['orderby'] ) ) {
		return;
	}

	$query->set( 'meta_key', 'publication_year' );
	$query->set( 'orderby', 'meta_value_num' );
	$query->set( 'order', 'DESC' );
}
add_action( 'pre_get_posts', 'inlife_publications_default_admin_order', 20 );