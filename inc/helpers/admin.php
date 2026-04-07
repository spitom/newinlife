<?php
defined( 'ABSPATH' ) || exit;

add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
	$disabled_post_types = [ 'people', 'teams', 'laboratories', 'projects', 'partners' ];

	if ( in_array( $post_type, $disabled_post_types, true ) ) {
		return false;
	}

	return $use_block_editor;
}, 10, 2 );