<?php
/**
 * Register research-related post types and taxonomies.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Teams and Laboratories post types.
 */
function inlife_register_research_post_types() {
	$team_labels = array(
		'name'                  => __( 'Zespoły', 'newinlife' ),
		'singular_name'         => __( 'Zespół', 'newinlife' ),
		'menu_name'             => __( 'Zespoły', 'newinlife' ),
		'name_admin_bar'        => __( 'Zespół', 'newinlife' ),
		'add_new'               => __( 'Dodaj nowy', 'newinlife' ),
		'add_new_item'          => __( 'Dodaj nowy zespół', 'newinlife' ),
		'new_item'              => __( 'Nowy zespół', 'newinlife' ),
		'edit_item'             => __( 'Edytuj zespół', 'newinlife' ),
		'view_item'             => __( 'Zobacz zespół', 'newinlife' ),
		'all_items'             => __( 'Wszystkie zespoły', 'newinlife' ),
		'search_items'          => __( 'Szukaj zespołów', 'newinlife' ),
		'parent_item_colon'     => __( 'Nadrzędny zespół:', 'newinlife' ),
		'not_found'             => __( 'Nie znaleziono zespołów.', 'newinlife' ),
		'not_found_in_trash'    => __( 'Nie znaleziono zespołów w koszu.', 'newinlife' ),
		'archives'              => __( 'Archiwum zespołów', 'newinlife' ),
		'attributes'            => __( 'Atrybuty zespołu', 'newinlife' ),
		'insert_into_item'      => __( 'Wstaw do zespołu', 'newinlife' ),
		'uploaded_to_this_item' => __( 'Przesłano do tego zespołu', 'newinlife' ),
	);

	register_post_type(
		'teams',
		array(
			'labels'              => $team_labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-groups',
			'has_archive'         => 'zespoly',
			'rewrite'             => array(
				'slug'       => 'zespoly',
				'with_front' => false,
			),
			'supports'            => array(
				'title',
				'thumbnail',
				'revisions',
				'page-attributes',
			),
			'menu_position'       => 22,
			'exclude_from_search' => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
		)
	);

	$laboratory_labels = array(
		'name'                  => __( 'Laboratoria', 'newinlife' ),
		'singular_name'         => __( 'Laboratorium', 'newinlife' ),
		'menu_name'             => __( 'Laboratoria', 'newinlife' ),
		'name_admin_bar'        => __( 'Laboratorium', 'newinlife' ),
		'add_new'               => __( 'Dodaj nowe', 'newinlife' ),
		'add_new_item'          => __( 'Dodaj nowe laboratorium', 'newinlife' ),
		'new_item'              => __( 'Nowe laboratorium', 'newinlife' ),
		'edit_item'             => __( 'Edytuj laboratorium', 'newinlife' ),
		'view_item'             => __( 'Zobacz laboratorium', 'newinlife' ),
		'all_items'             => __( 'Wszystkie laboratoria', 'newinlife' ),
		'search_items'          => __( 'Szukaj laboratoriów', 'newinlife' ),
		'parent_item_colon'     => __( 'Nadrzędne laboratorium:', 'newinlife' ),
		'not_found'             => __( 'Nie znaleziono laboratoriów.', 'newinlife' ),
		'not_found_in_trash'    => __( 'Nie znaleziono laboratoriów w koszu.', 'newinlife' ),
		'archives'              => __( 'Archiwum laboratoriów', 'newinlife' ),
		'attributes'            => __( 'Atrybuty laboratorium', 'newinlife' ),
		'insert_into_item'      => __( 'Wstaw do laboratorium', 'newinlife' ),
		'uploaded_to_this_item' => __( 'Przesłano do tego laboratorium', 'newinlife' ),
	);

	register_post_type(
		'laboratories',
		array(
			'labels'              => $laboratory_labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-building',
			'has_archive'         => 'laboratoria',
			'rewrite'             => array(
				'slug'       => 'laboratoria',
				'with_front' => false,
			),
			'supports'            => array(
				'title',
				'thumbnail',
				'revisions',
				'page-attributes',
			),
			'menu_position'       => 23,
			'exclude_from_search' => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'inlife_register_research_post_types' );

/**
 * Register team areas taxonomy.
 */
function inlife_register_team_area_taxonomy() {
	$labels = array(
		'name'              => __( 'Obszary działalności zespołów', 'newinlife' ),
		'singular_name'     => __( 'Obszar działalności', 'newinlife' ),
		'search_items'      => __( 'Szukaj obszarów', 'newinlife' ),
		'all_items'         => __( 'Wszystkie obszary', 'newinlife' ),
		'parent_item'       => __( 'Obszar nadrzędny', 'newinlife' ),
		'parent_item_colon' => __( 'Obszar nadrzędny:', 'newinlife' ),
		'edit_item'         => __( 'Edytuj obszar', 'newinlife' ),
		'update_item'       => __( 'Zaktualizuj obszar', 'newinlife' ),
		'add_new_item'      => __( 'Dodaj nowy obszar', 'newinlife' ),
		'new_item_name'     => __( 'Nazwa nowego obszaru', 'newinlife' ),
		'menu_name'         => __( 'Obszary zespołów', 'newinlife' ),
	);

	register_taxonomy(
		'team_area',
		array( 'teams' ),
		array(
			'labels'            => $labels,
			'public'            => true,
			'publicly_queryable'=> true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array(
				'slug'         => 'obszary-zespolow',
				'with_front'   => false,
				'hierarchical' => false,
			),
		)
	);
}
add_action( 'init', 'inlife_register_team_area_taxonomy' );

/**
 * Seed default team area terms if they do not exist.
 */
function inlife_maybe_create_default_team_area_terms() {
	$terms = array(
        'zywnosc'  => __( 'Żywność', 'newinlife' ),
        'zwierzeta'=> __( 'Zwierzęta', 'newinlife' ),
        'zdrowie'  => __( 'Zdrowie', 'newinlife' ),
    );

	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, 'team_area' ) ) {
			wp_insert_term(
				$name,
				'team_area',
				array(
					'slug' => $slug,
				)
			);
		}
	}
}
add_action( 'init', 'inlife_maybe_create_default_team_area_terms', 20 );