<?php
/**
 * Register People CPT and People Type taxonomy
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_register_people_cpt' ) ) {
	function inlife_register_people_cpt() {
		$labels = [
			'name'                  => __( 'Ludzie', 'newinlife' ),
			'singular_name'         => __( 'Osoba', 'newinlife' ),
			'menu_name'             => __( 'Ludzie', 'newinlife' ),
			'name_admin_bar'        => __( 'Osoba', 'newinlife' ),
			'add_new'               => __( 'Dodaj nową', 'newinlife' ),
			'add_new_item'          => __( 'Dodaj nową osobę', 'newinlife' ),
			'new_item'              => __( 'Nowa osoba', 'newinlife' ),
			'edit_item'             => __( 'Edytuj osobę', 'newinlife' ),
			'view_item'             => __( 'Zobacz osobę', 'newinlife' ),
			'all_items'             => __( 'Wszystkie osoby', 'newinlife' ),
			'search_items'          => __( 'Szukaj osób', 'newinlife' ),
			'not_found'             => __( 'Nie znaleziono osób.', 'newinlife' ),
			'not_found_in_trash'    => __( 'Nie znaleziono osób w koszu.', 'newinlife' ),
			'archives'              => __( 'Archiwum osób', 'newinlife' ),
			'attributes'            => __( 'Atrybuty osoby', 'newinlife' ),
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
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-groups',
			'has_archive'         => true,
			'rewrite'             => [
				'slug'       => 'people',
				'with_front' => false,
			],
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'revisions',
			],
			'exclude_from_search' => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
		];

		register_post_type( 'people', $args );
	}
	add_action( 'init', 'inlife_register_people_cpt' );
}

if ( ! function_exists( 'inlife_register_people_type_taxonomy' ) ) {
	function inlife_register_people_type_taxonomy() {
		$labels = [
			'name'              => __( 'Typy osób', 'newinlife' ),
			'singular_name'     => __( 'Typ osoby', 'newinlife' ),
			'search_items'      => __( 'Szukaj typów osób', 'newinlife' ),
			'all_items'         => __( 'Wszystkie typy osób', 'newinlife' ),
			'edit_item'         => __( 'Edytuj typ osoby', 'newinlife' ),
			'update_item'       => __( 'Aktualizuj typ osoby', 'newinlife' ),
			'add_new_item'      => __( 'Dodaj nowy typ osoby', 'newinlife' ),
			'new_item_name'     => __( 'Nazwa nowego typu osoby', 'newinlife' ),
			'menu_name'         => __( 'Typ osoby', 'newinlife' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'rewrite'           => [
				'slug'       => 'people-type',
				'with_front' => false,
			],
		];

		register_taxonomy( 'people_type', [ 'people' ], $args );
	}
	add_action( 'init', 'inlife_register_people_type_taxonomy' );
}

if ( ! function_exists( 'inlife_register_default_people_type_terms' ) ) {
	function inlife_register_default_people_type_terms() {
		$terms = [
			[
				'name' => __( 'Pracownik naukowy', 'newinlife' ),
				'slug' => 'scientific',
			],
			[
				'name' => __( 'Pracownik', 'newinlife' ),
				'slug' => 'staff',
			],
		];

		foreach ( $terms as $term ) {
			if ( ! term_exists( $term['slug'], 'people_type' ) ) {
				wp_insert_term(
					$term['name'],
					'people_type',
					[
						'slug' => $term['slug'],
					]
				);
			}
		}
	}
	add_action( 'init', 'inlife_register_default_people_type_terms', 20 );
}