<?php
defined( 'ABSPATH' ) || exit;

/**
 * Get partner region terms for filters.
 *
 * @return array
 */
function inlife_get_partner_region_terms(): array {
	$terms = get_terms(
		[
			'taxonomy'   => 'partner_region',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		]
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return [];
	}

	return $terms;
}

/**
 * Build a partners query for the Network landing page.
 *
 * @return WP_Query
 */
function inlife_get_network_partners_query(): WP_Query {
	$args = [
		'post_type'      => 'partners',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => [
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		],
		'order'          => 'ASC',
	];

	return new WP_Query( $args );
}

/**
 * Get single partner card data.
 *
 * @param int $post_id
 * @return array
 */
function inlife_get_partner_card_data( int $post_id ): array {
	$region_terms = wp_get_post_terms( $post_id, 'partner_region' );
	$region_slugs = [];
	$region_names = [];

	if ( ! is_wp_error( $region_terms ) && ! empty( $region_terms ) ) {
		foreach ( $region_terms as $term ) {
			$region_slugs[] = $term->slug;
			$region_names[] = $term->name;
		}
	}

	$logo    = get_field( 'partner_logo', $post_id );
	$country = (string) get_field( 'partner_country', $post_id );
	$city    = (string) get_field( 'partner_city', $post_id );
	$short   = (string) get_field( 'partner_short_description', $post_id );
	$website = (string) get_field( 'partner_website', $post_id );
	$email   = (string) get_field( 'partner_email', $post_id );
	$phone   = (string) get_field( 'partner_phone', $post_id );

	return [
		'id'           => $post_id,
		'title'        => get_the_title( $post_id ),
		'permalink'    => get_permalink( $post_id ),
		'logo'         => $logo,
		'country'      => $country,
		'city'         => $city,
		'location'     => trim( implode( ', ', array_filter( [ $city, $country ] ) ) ),
		'short'        => $short,
		'website'      => $website,
		'email'        => $email,
		'phone'        => $phone,
		'region_slugs' => $region_slugs,
		'region_names' => $region_names,
	];
}

/**
 * Get data used by Leaflet map and frontend filters.
 *
 * @param WP_Query|null $query Optional preloaded query.
 * @return array
 */
function inlife_get_network_map_data( ?WP_Query $query = null ): array {
	$query = $query instanceof WP_Query ? $query : inlife_get_network_partners_query();

	if ( empty( $query->posts ) ) {
		return [];
	}

	$data = [];

	foreach ( $query->posts as $post ) {
		$post_id = $post->ID;

		$show_on_map = get_field( 'partner_featured_on_map', $post_id );
		$lat         = get_field( 'partner_lat', $post_id );
		$lng         = get_field( 'partner_lng', $post_id );

		if ( '0' === (string) $show_on_map || '' === (string) $lat || '' === (string) $lng ) {
			continue;
		}

		$card_data = inlife_get_partner_card_data( $post_id );

		$data[] = [
			'id'           => $post_id,
			'title'        => $card_data['title'],
			'permalink'    => $card_data['permalink'],
			'lat'          => (float) $lat,
			'lng'          => (float) $lng,
			'country'      => $card_data['country'],
			'city'         => $card_data['city'],
			'location'     => $card_data['location'],
			'short'        => wp_strip_all_tags( $card_data['short'] ),
			'region_slugs' => $card_data['region_slugs'],
			'logo'         => ! empty( $card_data['logo']['url'] ) ? $card_data['logo']['url'] : '',
		];
	}

	return $data;
}

/**
 * Check if partner should use light layout.
 *
 * @param int $post_id
 * @return bool
 */
function inlife_is_partner_light( int $post_id ): bool {
	$forced = get_field( 'partner_is_light', $post_id );

	if ( $forced ) {
		return true;
	}

	$content = get_post_field( 'post_content', $post_id );
	$content = is_string( $content ) ? trim( wp_strip_all_tags( $content ) ) : '';

	return '' === $content;
}

/**
 * Get single partner data.
 *
 * @param int $post_id
 * @return array
 */
function inlife_get_partner_single_data( int $post_id ): array {
	$region_terms = wp_get_post_terms( $post_id, 'partner_region' );
	$region_names = [];

	if ( ! is_wp_error( $region_terms ) && ! empty( $region_terms ) ) {
		foreach ( $region_terms as $term ) {
			$region_names[] = $term->name;
		}
	}

	$logo               = get_field( 'partner_logo', $post_id );
	$hero_image         = get_field( 'partner_hero_image', $post_id );
	$short_description  = (string) get_field( 'partner_short_description', $post_id );
	$country            = (string) get_field( 'partner_country', $post_id );
	$city               = (string) get_field( 'partner_city', $post_id );
	$address            = (string) get_field( 'partner_address', $post_id );
	$email              = (string) get_field( 'partner_email', $post_id );
	$phone              = (string) get_field( 'partner_phone', $post_id );
	$website            = (string) get_field( 'partner_website', $post_id );
	$cooperation_link   = (string) get_field( 'partner_cooperation_link', $post_id );
	$cooperation_label  = (string) get_field( 'partner_cooperation_label', $post_id );

	return [
		'id'                 => $post_id,
		'title'              => get_the_title( $post_id ),
		'permalink'          => get_permalink( $post_id ),
		'logo'               => $logo,
		'hero_image'         => $hero_image,
		'short_description'  => $short_description,
		'country'            => $country,
		'city'               => $city,
		'address'            => $address,
		'email'              => $email,
		'phone'              => $phone,
		'website'            => $website,
		'cooperation_link'   => $cooperation_link,
		'cooperation_label'  => $cooperation_label,
		'region_names'       => $region_names,
		'is_light'           => inlife_is_partner_light( $post_id ),
	];
}