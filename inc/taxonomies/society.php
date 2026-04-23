<?php
defined( 'ABSPATH' ) || exit;

/**
 * Register Partner Society taxonomy.
 */
add_action( 'init', 'inlife_register_partner_region_taxonomy' );

add_action( 'init', 'inlife_register_society_format_taxonomy' );

function inlife_register_society_format_taxonomy() {

	register_taxonomy(
		'society_format',
		'post',
		[
			'labels' => [
				'name'              => 'Format materiału',
				'singular_name'     => 'Format materiału',
				'search_items'      => 'Szukaj formatów',
				'all_items'         => 'Wszystkie formaty',
				'edit_item'         => 'Edytuj format',
				'update_item'       => 'Aktualizuj format',
				'add_new_item'      => 'Dodaj format',
				'new_item_name'     => 'Nowy format',
				'menu_name'         => 'Format materiału',
			],
			'public'            => true,
			'hierarchical'      => false, // jak tagi
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'format' ],
		]
	);
}