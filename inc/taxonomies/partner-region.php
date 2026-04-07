<?php
defined( 'ABSPATH' ) || exit;

/**
 * Register Partner Region taxonomy.
 */
add_action( 'init', 'inlife_register_partner_region_taxonomy' );

function inlife_register_partner_region_taxonomy() {
	$labels = [
		'name'                       => inlife_t( 'Regiony partnerów' ),
		'singular_name'              => inlife_t( 'Region partnera' ),
		'search_items'               => inlife_t( 'Szukaj regionów' ),
		'all_items'                  => inlife_t( 'Wszystkie regiony' ),
		'parent_item'                => inlife_t( 'Region nadrzędny' ),
		'parent_item_colon'          => inlife_t( 'Region nadrzędny:' ),
		'edit_item'                  => inlife_t( 'Edytuj region' ),
		'view_item'                  => inlife_t( 'Zobacz region' ),
		'update_item'                => inlife_t( 'Zaktualizuj region' ),
		'add_new_item'               => inlife_t( 'Dodaj nowy region' ),
		'new_item_name'              => inlife_t( 'Nazwa nowego regionu' ),
		'menu_name'                  => inlife_t( 'Regiony' ),
		'not_found'                  => inlife_t( 'Nie znaleziono regionów.' ),
		'back_to_items'              => inlife_t( '← Wróć do regionów' ),
	];

	$args = [
		'labels'            => $labels,
		'public'            => true,
		'publicly_queryable'=> true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'show_in_rest'      => true,
		'rewrite'           => [
			'slug'       => 'partner-region',
			'with_front' => false,
		],
	];

	register_taxonomy( 'partner_region', [ 'partners' ], $args );
}