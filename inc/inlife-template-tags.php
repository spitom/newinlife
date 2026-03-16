<?php
defined( 'ABSPATH' ) || exit;

/**
 * Get container class.
 *
 * @return string
 */
function inlife_container_class(): string {
	$container = get_theme_mod( 'understrap_container_type', 'container' );
	return $container ? $container : 'container';
}