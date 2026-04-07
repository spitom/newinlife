<?php
defined( 'ABSPATH' ) || exit;

/**
 * Register Partners custom post type.
 */
add_action( 'init', 'inlife_register_partners_post_type' );

function inlife_register_partners_post_type() {
	$labels = [
		'name'                  => inlife_t( 'Partnerzy' ),
		'singular_name'         => inlife_t( 'Partner' ),
		'menu_name'             => inlife_t( 'Partnerzy' ),
		'name_admin_bar'        => inlife_t( 'Partner' ),
		'add_new'               => inlife_t( 'Dodaj nowego' ),
		'add_new_item'          => inlife_t( 'Dodaj partnera' ),
		'new_item'              => inlife_t( 'Nowy partner' ),
		'edit_item'             => inlife_t( 'Edytuj partnera' ),
		'view_item'             => inlife_t( 'Zobacz partnera' ),
		'all_items'             => inlife_t( 'Wszyscy partnerzy' ),
		'search_items'          => inlife_t( 'Szukaj partnerów' ),
		'not_found'             => inlife_t( 'Nie znaleziono partnerów.' ),
		'not_found_in_trash'    => inlife_t( 'Nie znaleziono partnerów w koszu.' ),
		'archives'              => inlife_t( 'Archiwum partnerów' ),
		'attributes'            => inlife_t( 'Atrybuty partnera' ),
		'insert_into_item'      => inlife_t( 'Wstaw do partnera' ),
		'uploaded_to_this_item' => inlife_t( 'Przesłano do tego partnera' ),
		'featured_image'        => inlife_t( 'Obraz wyróżniający' ),
		'set_featured_image'    => inlife_t( 'Ustaw obraz wyróżniający' ),
		'remove_featured_image' => inlife_t( 'Usuń obraz wyróżniający' ),
		'use_featured_image'    => inlife_t( 'Użyj jako obrazu wyróżniającego' ),
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 24,
		'menu_icon'           => 'dashicons-networking',
		'capability_type'     => 'post',
		'has_archive'         => true,
		'rewrite' => [
		'slug'       => 'partnerzy',
		'with_front' => false,
	],
		'query_var'           => true,
		'exclude_from_search' => false,
		'hierarchical'        => false,
		'supports'            => [
			'title',
			'thumbnail',
			'revisions',
			'page-attributes',
		],
		'menu_order'          => 0,
	];

	register_post_type( 'partners', $args );
}