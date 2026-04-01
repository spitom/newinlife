<?php
/**
 * Register Publications CPT
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register publications custom post type.
 */
function inlife_register_publications_cpt() {
	$labels = array(
		'name'                  => __( 'Publikacje', 'newinlife-child' ),
		'singular_name'         => __( 'Publikacja', 'newinlife-child' ),
		'menu_name'             => __( 'Publikacje', 'newinlife-child' ),
		'name_admin_bar'        => __( 'Publikacja', 'newinlife-child' ),
		'add_new'               => __( 'Dodaj nową', 'newinlife-child' ),
		'add_new_item'          => __( 'Dodaj nową publikację', 'newinlife-child' ),
		'new_item'              => __( 'Nowa publikacja', 'newinlife-child' ),
		'edit_item'             => __( 'Edytuj publikację', 'newinlife-child' ),
		'view_item'             => __( 'Zobacz publikację', 'newinlife-child' ),
		'all_items'             => __( 'Wszystkie publikacje', 'newinlife-child' ),
		'search_items'          => __( 'Szukaj publikacji', 'newinlife-child' ),
		'parent_item_colon'     => __( 'Publikacja nadrzędna:', 'newinlife-child' ),
		'not_found'             => __( 'Nie znaleziono publikacji.', 'newinlife-child' ),
		'not_found_in_trash'    => __( 'Nie znaleziono publikacji w koszu.', 'newinlife-child' ),
		'archives'              => __( 'Archiwum publikacji', 'newinlife-child' ),
		'attributes'            => __( 'Atrybuty publikacji', 'newinlife-child' ),
		'insert_into_item'      => __( 'Wstaw do publikacji', 'newinlife-child' ),
		'uploaded_to_this_item' => __( 'Przesłane do tej publikacji', 'newinlife-child' ),
		'featured_image'        => __( 'Obrazek wyróżniający', 'newinlife-child' ),
		'set_featured_image'    => __( 'Ustaw obrazek wyróżniający', 'newinlife-child' ),
		'remove_featured_image' => __( 'Usuń obrazek wyróżniający', 'newinlife-child' ),
		'use_featured_image'    => __( 'Użyj jako obrazka wyróżniającego', 'newinlife-child' ),
		'filter_items_list'     => __( 'Filtruj listę publikacji', 'newinlife-child' ),
		'items_list_navigation' => __( 'Nawigacja listy publikacji', 'newinlife-child' ),
		'items_list'            => __( 'Lista publikacji', 'newinlife-child' ),
	);

	$args = array(
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'show_in_rest'          => true,
		'menu_position'         => 24,
		'menu_icon'             => 'dashicons-media-document',
		'capability_type'       => 'post',
		'hierarchical'          => false,
		'has_archive'           => true,
		'rewrite'               => array(
			'slug'       => 'publikacje',
			'with_front' => false,
		),
		'query_var'             => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'supports'              => array(
			'title',
		),
		'delete_with_user'      => false,
		'menu_position'         => 25,
	);

	register_post_type( 'publications', $args );
}
add_action( 'init', 'inlife_register_publications_cpt' );