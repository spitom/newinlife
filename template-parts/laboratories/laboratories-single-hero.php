<?php
defined( 'ABSPATH' ) || exit;

$laboratory_id = get_the_ID();

/**
 * LEAD
 */
$acf_lead = function_exists( 'get_field' ) ? get_field( 'laboratory_lead', $laboratory_id ) : '';
$lead     = $acf_lead ? $acf_lead : get_the_excerpt();

if ( ! $lead ) {
	$lead = wp_trim_words(
		wp_strip_all_tags(
			shortcode_unautop(
				strip_shortcodes( get_the_content() )
			)
		),
		28
	);
}

/**
 * HERO IMAGE
 */
$hero_image_id = 0;

if ( function_exists( 'get_field' ) ) {
	$laboratory_hero_image = get_field( 'laboratory_hero_image', $laboratory_id );

	if ( is_array( $laboratory_hero_image ) && ! empty( $laboratory_hero_image['ID'] ) ) {
		$hero_image_id = (int) $laboratory_hero_image['ID'];
	} elseif ( is_numeric( $laboratory_hero_image ) ) {
		$hero_image_id = (int) $laboratory_hero_image;
	}
}

if ( ! $hero_image_id && has_post_thumbnail( $laboratory_id ) ) {
	$hero_image_id = (int) get_post_thumbnail_id( $laboratory_id );
}

/**
 * RENDER SHARED PATTERN
 */
get_template_part(
	'template-parts/patterns/pattern-media-hero',
	null,
	[
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => get_the_title( $laboratory_id ),
		'lead'        => $lead,
		'image_id'    => $hero_image_id,
		'breadcrumbs' => true,
		'media_shape' => 'cut-tl',
	]
);