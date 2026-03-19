<?php
defined( 'ABSPATH' ) || exit;

/**
 * Footer Social icons
 */

add_filter( 'walker_nav_menu_start_el', 'inlife_footer_social_menu_icons', 10, 4 );

function inlife_footer_social_menu_icons( $item_output, $item, $depth, $args ) {
	if ( empty( $args->theme_location ) || 'footer_social' !== $args->theme_location ) {
		return $item_output;
	}

	$icon_class = '';

	if ( ! empty( $item->classes ) && is_array( $item->classes ) ) {
		foreach ( $item->classes as $class ) {
			if ( strpos( $class, 'icon-bi-' ) === 0 ) {
				$icon_class = substr( $class, 5 ); // z "icon-bi-facebook" robi "bi-facebook"
				break;
			}
		}
	}

	if ( ! $icon_class ) {
		return $item_output;
	}

	$url         = ! empty( $item->url ) ? $item->url : '#';
	$title       = ! empty( $item->title ) ? $item->title : '';
	$is_external = 0 === strpos( $url, 'http' );

	$attributes  = ' href="' . esc_url( $url ) . '"';
	$attributes .= ' class="inlife-footer__social-link"';
	$attributes .= ' aria-label="' . esc_attr( $title ) . '"';

	if ( $is_external ) {
		$attributes .= ' target="_blank" rel="noopener noreferrer"';
	}

	$item_output  = '<a' . $attributes . '>';
	$item_output .= '<i class="bi ' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
	$item_output .= '<span class="visually-hidden">' . esc_html( $title ) . '</span>';
	$item_output .= '</a>';

	return $item_output;
}