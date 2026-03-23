<?php
defined( 'ABSPATH' ) || exit;

/**
 * Return InLife container classes depending on layout context.
 *
 * Available types:
 * - page    => wide page shell
 * - content => wide shell + content width
 * - text    => wide shell + narrow reading width
 *
 * @param string $type Container context.
 * @return string
 */
function inlife_container_class( string $type = 'content' ): string {
	switch ( $type ) {
		case 'page':
			return 'inlife-container';

		case 'content':
			return 'inlife-container inlife-content';

		case 'text':
			return 'inlife-container inlife-text';

		default:
			return 'inlife-container inlife-content';
	}
}