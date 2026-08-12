<?php
/**
 * Laboratory units / pracownie.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$units = isset( $args['units'] ) && is_array( $args['units'] )
	? $args['units']
	: array();

if ( empty( $units ) ) {
	return;
}

$prepared_units = array();

foreach ( $units as $unit ) {
	if ( ! is_array( $unit ) ) {
		continue;
	}

	$title = isset( $unit['unit_title'] )
		? trim( (string) $unit['unit_title'] )
		: '';

	if ( '' === $title ) {
		continue;
	}

	$tab_label = isset( $unit['unit_tab_label'] )
		? trim( (string) $unit['unit_tab_label'] )
		: '';

	$prepared_units[] = array(
		'title'     => $title,
		'tab_label' => '' !== $tab_label ? $tab_label : $title,
		'intro'     => isset( $unit['unit_intro'] ) ? (string) $unit['unit_intro'] : '',
		'sections'  => isset( $unit['unit_sections'] ) && is_array( $unit['unit_sections'] )
			? $unit['unit_sections']
			: array(),
	);
}

if ( empty( $prepared_units ) ) {
	return;
}