<?php
defined( 'ABSPATH' ) || exit;

// if ( ! function_exists( 'inlife_get_acf_field' ) ) {
// 	function inlife_get_acf_field( $field_name, $post_id = 0, $default = null ) {
// 		if ( function_exists( 'get_field' ) ) {
// 			$value = get_field( $field_name, $post_id );

// 			if ( null !== $value && '' !== $value ) {
// 				return $value;
// 			}
// 		}

// 		return $default;
// 	}
// }

if ( ! function_exists( 'inlife_get_society_format_label' ) ) {
	/**
	 * Returns translated society format label for a post.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function inlife_get_society_format_label( $post_id ) {
		$terms = get_the_terms( $post_id, 'society_format' );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		$term = reset( $terms );

		$map = [
			'zobacz'             => inlife_t( 'Zobacz' ),
			'posluchaj'          => inlife_t( 'Posłuchaj' ),
			'przeczytaj'         => inlife_t( 'Przeczytaj' ),
			'spotkaj-sie-z-nami' => inlife_t( 'Spotkaj się z nami' ),
		];

		return $map[ $term->slug ] ?? $term->name;
	}
}

if ( ! function_exists( 'inlife_get_society_archive_page' ) ) {
	/**
	 * Returns the page assigned to the Society archive template.
	 *
	 * @return WP_Post|null
	 */
	function inlife_get_society_archive_page() {
		$pages = get_posts(
			[
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/template-society-archive.php',
				'posts_per_page' => 1,
				'no_found_rows'  => true,
			]
		);

		if ( empty( $pages ) ) {
			return null;
		}

		return $pages[0];
	}
}