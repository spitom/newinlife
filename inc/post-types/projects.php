<?php
defined('ABSPATH') || exit;

/**
 * Register Projects CPT
 */
add_action('init', 'inlife_register_projects_cpt');
function inlife_register_projects_cpt(): void {

	$labels = [
		'name'                  => __('Projekty', 'newinlife-child'),
		'singular_name'         => __('Projekt', 'newinlife-child'),
		'menu_name'             => __('Projekty', 'newinlife-child'),
		'name_admin_bar'        => __('Projekt', 'newinlife-child'),
		'add_new'               => __('Dodaj nowy', 'newinlife-child'),
		'add_new_item'          => __('Dodaj nowy projekt', 'newinlife-child'),
		'new_item'              => __('Nowy projekt', 'newinlife-child'),
		'edit_item'             => __('Edytuj projekt', 'newinlife-child'),
		'view_item'             => __('Zobacz projekt', 'newinlife-child'),
		'view_items'            => __('Zobacz projekty', 'newinlife-child'),
		'search_items'          => __('Szukaj projektów', 'newinlife-child'),
		'not_found'             => __('Nie znaleziono projektów.', 'newinlife-child'),
		'not_found_in_trash'    => __('Nie znaleziono projektów w koszu.', 'newinlife-child'),
		'all_items'             => __('Wszystkie projekty', 'newinlife-child'),
		'archives'              => __('Archiwum projektów', 'newinlife-child'),
		'attributes'            => __('Atrybuty projektu', 'newinlife-child'),
		'insert_into_item'      => __('Wstaw do projektu', 'newinlife-child'),
		'uploaded_to_this_item' => __('Przesłane do tego projektu', 'newinlife-child'),
		'filter_items_list'     => __('Filtruj listę projektów', 'newinlife-child'),
		'items_list_navigation' => __('Nawigacja listy projektów', 'newinlife-child'),
		'items_list'            => __('Lista projektów', 'newinlife-child'),
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
		'name'                       => __('Typy projektów', 'newinlife-child'),
		'singular_name'              => __('Typ projektu', 'newinlife-child'),
		'menu_name'                  => __('Typy projektów', 'newinlife-child'),
		'all_items'                  => __('Wszystkie typy projektów', 'newinlife-child'),
		'edit_item'                  => __('Edytuj typ projektu', 'newinlife-child'),
		'view_item'                  => __('Zobacz typ projektu', 'newinlife-child'),
		'update_item'                => __('Zaktualizuj typ projektu', 'newinlife-child'),
		'add_new_item'               => __('Dodaj nowy typ projektu', 'newinlife-child'),
		'new_item_name'              => __('Nazwa nowego typu projektu', 'newinlife-child'),
		'parent_item'                => __('Typ nadrzędny', 'newinlife-child'),
		'parent_item_colon'          => __('Typ nadrzędny:', 'newinlife-child'),
		'search_items'               => __('Szukaj typów projektów', 'newinlife-child'),
		'popular_items'              => __('Popularne typy projektów', 'newinlife-child'),
		'separate_items_with_commas' => __('Oddziel typy przecinkami', 'newinlife-child'),
		'add_or_remove_items'        => __('Dodaj lub usuń typy projektów', 'newinlife-child'),
		'choose_from_most_used'      => __('Wybierz z najczęściej używanych typów', 'newinlife-child'),
		'not_found'                  => __('Nie znaleziono typów projektów.', 'newinlife-child'),
		'no_terms'                   => __('Brak typów projektów', 'newinlife-child'),
		'items_list_navigation'      => __('Nawigacja listy typów projektów', 'newinlife-child'),
		'items_list'                 => __('Lista typów projektów', 'newinlife-child'),
		'back_to_items'              => __('← Wróć do typów projektów', 'newinlife-child'),
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
