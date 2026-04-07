<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'partner' => [],
	]
);

$partner = is_array( $args['partner'] ) ? $args['partner'] : [];
$is_light = ! empty( $partner['is_light'] );

if ( $is_light ) {
	get_template_part(
		'template-parts/network/network-partner-light',
		null,
		[
			'partner' => $partner,
		]
	);

	return;
}

get_template_part(
	'template-parts/network/network-partner-full',
	null,
	[
		'partner' => $partner,
	]
);