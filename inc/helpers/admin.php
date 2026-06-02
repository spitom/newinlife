<?php
defined( 'ABSPATH' ) || exit;

function inlife_admin_disabled_block_editor_post_types(): array {
	return [
		'people',
		'teams',
		'laboratories',
		'projects',
		'partners',
		'career_entry',
	];
}

function inlife_admin_controlled_page_templates(): array {
	return [
		'page-templates/template-about-overview.php',
		'page-templates/template-about-structure.php',
		'page-templates/template-about-history.php',
		'page-templates/template-research-overview.php',
		'page-templates/template-business-landing.php',
		'page-templates/template-career-landing.php',
		'page-templates/template-network.php',
		'page-templates/template-society-landing.php',
	];
}

function inlife_admin_is_controlled_page_template( $post ): bool {
	$post = get_post( $post );

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}

	return in_array(
		get_page_template_slug( $post ),
		inlife_admin_controlled_page_templates(),
		true
	);
}

add_filter(
	'use_block_editor_for_post_type',
	function( $use_block_editor, $post_type ) {
		return in_array( $post_type, inlife_admin_disabled_block_editor_post_types(), true )
			? false
			: $use_block_editor;
	},
	10,
	2
);

add_filter(
	'use_block_editor_for_post',
	function( $use_block_editor, $post ) {
		return inlife_admin_is_controlled_page_template( $post )
			? false
			: $use_block_editor;
	},
	10,
	2
);

add_action(
	'admin_init',
	function() {
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $post_id && inlife_admin_is_controlled_page_template( $post_id ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);