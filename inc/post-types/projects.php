<?php
defined('ABSPATH') || exit;

/**
 * Register Projects CPT
 */
add_action('init', 'inlife_register_projects_cpt');
function inlife_register_projects_cpt(): void {

	$labels = [
		'name'                  => __('Projekty', 'understrap-child'),
		'singular_name'         => __('Projekt', 'understrap-child'),
		'menu_name'             => __('Projekty', 'understrap-child'),
		'name_admin_bar'        => __('Projekt', 'understrap-child'),
		'add_new'               => __('Dodaj nowy', 'understrap-child'),
		'add_new_item'          => __('Dodaj nowy projekt', 'understrap-child'),
		'new_item'              => __('Nowy projekt', 'understrap-child'),
		'edit_item'             => __('Edytuj projekt', 'understrap-child'),
		'view_item'             => __('Zobacz projekt', 'understrap-child'),
		'view_items'            => __('Zobacz projekty', 'understrap-child'),
		'search_items'          => __('Szukaj projektów', 'understrap-child'),
		'not_found'             => __('Nie znaleziono projektów.', 'understrap-child'),
		'not_found_in_trash'    => __('Nie znaleziono projektów w koszu.', 'understrap-child'),
		'all_items'             => __('Wszystkie projekty', 'understrap-child'),
		'archives'              => __('Archiwum projektów', 'understrap-child'),
		'attributes'            => __('Atrybuty projektu', 'understrap-child'),
		'insert_into_item'      => __('Wstaw do projektu', 'understrap-child'),
		'uploaded_to_this_item' => __('Przesłane do tego projektu', 'understrap-child'),
		'filter_items_list'     => __('Filtruj listę projektów', 'understrap-child'),
		'items_list_navigation' => __('Nawigacja listy projektów', 'understrap-child'),
		'items_list'            => __('Lista projektów', 'understrap-child'),
	];

	$args = [
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'show_in_rest'          => true,
		'menu_position'         => 22,
		'menu_icon'             => 'dashicons-portfolio',
		'capability_type'       => 'post',
		'has_archive'           => 'projekty',
		'rewrite'               => [
			'slug'       => 'projekty',
			'with_front' => false,
		],
		'query_var'             => true,
		'exclude_from_search'   => false,
		'hierarchical'          => false,
		'supports'              => [
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
		],
		'delete_with_user'      => false,
	];

	register_post_type('projects', $args);
}

/**
 * Register Project Type taxonomy
 */
add_action('init', 'inlife_register_project_type_taxonomy');
function inlife_register_project_type_taxonomy(): void {

	$labels = [
		'name'                       => __('Typy projektów', 'understrap-child'),
		'singular_name'              => __('Typ projektu', 'understrap-child'),
		'menu_name'                  => __('Typy projektów', 'understrap-child'),
		'all_items'                  => __('Wszystkie typy projektów', 'understrap-child'),
		'edit_item'                  => __('Edytuj typ projektu', 'understrap-child'),
		'view_item'                  => __('Zobacz typ projektu', 'understrap-child'),
		'update_item'                => __('Zaktualizuj typ projektu', 'understrap-child'),
		'add_new_item'               => __('Dodaj nowy typ projektu', 'understrap-child'),
		'new_item_name'              => __('Nazwa nowego typu projektu', 'understrap-child'),
		'parent_item'                => __('Typ nadrzędny', 'understrap-child'),
		'parent_item_colon'          => __('Typ nadrzędny:', 'understrap-child'),
		'search_items'               => __('Szukaj typów projektów', 'understrap-child'),
		'popular_items'              => __('Popularne typy projektów', 'understrap-child'),
		'separate_items_with_commas' => __('Oddziel typy przecinkami', 'understrap-child'),
		'add_or_remove_items'        => __('Dodaj lub usuń typy projektów', 'understrap-child'),
		'choose_from_most_used'      => __('Wybierz z najczęściej używanych typów', 'understrap-child'),
		'not_found'                  => __('Nie znaleziono typów projektów.', 'understrap-child'),
		'no_terms'                   => __('Brak typów projektów', 'understrap-child'),
		'items_list_navigation'      => __('Nawigacja listy typów projektów', 'understrap-child'),
		'items_list'                 => __('Lista typów projektów', 'understrap-child'),
		'back_to_items'              => __('← Wróć do typów projektów', 'understrap-child'),
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
		'show_in_quick_edit'=> true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => [
			'slug'         => 'typ-projektu',
			'with_front'   => false,
			'hierarchical' => true,
		],
	];

	register_taxonomy('project_type', ['projects'], $args);
}