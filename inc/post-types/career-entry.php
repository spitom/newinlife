<?php
/**
 * Career Entry CPT and taxonomy
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

if (!function_exists('inlife_register_career_entry_cpt')) {
	function inlife_register_career_entry_cpt() {
		$labels = [
			'name'                  => __('Kariera', 'newinlife'),
			'singular_name'         => __('Wpis kariery', 'newinlife'),
			'menu_name'             => __('Kariera', 'newinlife'),
			'name_admin_bar'        => __('Wpis kariery', 'newinlife'),
			'add_new'               => __('Dodaj nowy', 'newinlife'),
			'add_new_item'          => __('Dodaj nowy wpis kariery', 'newinlife'),
			'new_item'              => __('Nowy wpis kariery', 'newinlife'),
			'edit_item'             => __('Edytuj wpis kariery', 'newinlife'),
			'view_item'             => __('Zobacz wpis kariery', 'newinlife'),
			'all_items'             => __('Wszystkie wpisy kariery', 'newinlife'),
			'search_items'          => __('Szukaj wpisów kariery', 'newinlife'),
			'not_found'             => __('Nie znaleziono wpisów.', 'newinlife'),
			'not_found_in_trash'    => __('Nie znaleziono wpisów w koszu.', 'newinlife'),
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_position'      => 21,
			'menu_icon'          => 'dashicons-id-alt',
			'has_archive'        => 'recruitment',
			'rewrite'            => [
				'slug'       => 'recruitment/entry',
				'with_front' => false,
			],
			'supports'           => [
				'title',
				'editor',
				'excerpt',
				'revisions',
			],
			'taxonomies'         => ['career_entry_type'],
			'publicly_queryable' => true,
			'exclude_from_search'=> false,
		];

		register_post_type('career_entry', $args);
	}
	add_action('init', 'inlife_register_career_entry_cpt');
}

if (!function_exists('inlife_register_career_entry_type_taxonomy')) {
	function inlife_register_career_entry_type_taxonomy() {
		$labels = [
			'name'              => __('Typy wpisów kariery', 'newinlife'),
			'singular_name'     => __('Typ wpisu kariery', 'newinlife'),
			'search_items'      => __('Szukaj typów', 'newinlife'),
			'all_items'         => __('Wszystkie typy', 'newinlife'),
			'edit_item'         => __('Edytuj typ', 'newinlife'),
			'update_item'       => __('Aktualizuj typ', 'newinlife'),
			'add_new_item'      => __('Dodaj nowy typ', 'newinlife'),
			'new_item_name'     => __('Nazwa nowego typu', 'newinlife'),
			'menu_name'         => __('Typ wpisu', 'newinlife'),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'rewrite'           => [
				'slug'         => 'recruitment',
				'with_front'   => false,
				'hierarchical' => false,
			],
		];

		register_taxonomy('career_entry_type', ['career_entry'], $args);
	}
	add_action('init', 'inlife_register_career_entry_type_taxonomy');
}