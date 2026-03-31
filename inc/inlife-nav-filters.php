<?php
defined( 'ABSPATH' ) || exit;

/**
 * Add aria-label for primary menu network icon item.
 *
 * @param array    $atts Menu link attributes.
 * @param WP_Post  $item Menu item.
 * @param stdClass $args Menu args.
 * @param int      $depth Depth.
 * @return array
 */
function inlife_filter_network_menu_link_atts( $atts, $item, $args, $depth ) {
	if ( empty( $item->classes ) || ! is_array( $item->classes ) ) {
		return $atts;
	}

	if ( in_array( 'menu-item-network-icon', $item->classes, true ) ) {
		$atts['aria-label'] = __( 'Sieć', 'newinlife-child' );
		$atts['title']      = __( 'Sieć', 'newinlife-child' );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'inlife_filter_network_menu_link_atts', 10, 4 );