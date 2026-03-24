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
			'name'               => __('Komunikaty', 'newinlife'),
			'singular_name'      => __('Komunikat', 'newinlife'),
			'menu_name'          => __('Komunikaty', 'newinlife'),
			'add_new_item'       => __('Dodaj nowy komunikat', 'newinlife'),
			'edit_item'          => __('Edytuj komunikat', 'newinlife'),
			'new_item'           => __('Nowy komunikat', 'newinlife'),
			'view_item'          => __('Zobacz komunikat', 'newinlife'),
			'all_items'          => __('Wszystkie komunikaty', 'newinlife'),
			'search_items'       => __('Szukaj komunikatów', 'newinlife'),
			'not_found'          => __('Nie znaleziono komunikatów.', 'newinlife'),
			'not_found_in_trash' => __('Nie znaleziono komunikatów w koszu.', 'newinlife'),
		];

		register_post_type(
			'career_entry',
			[
				'labels'             => $labels,
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => true,
				'menu_position'      => 21,
				'menu_icon'          => 'dashicons-id-alt',
				'has_archive'        => 'komunikaty',
				'rewrite'            => [
					'slug'       => 'komunikaty/wpis',
					'with_front' => false,
				],
				'supports'           => ['title', 'editor', 'excerpt', 'revisions'],
				'taxonomies'         => ['career_entry_type'],
				'publicly_queryable' => true,
				'exclude_from_search'=> false,
			]
		);
	}
	add_action('init', 'inlife_register_career_entry_cpt', 5);
}

if (!function_exists('inlife_register_career_entry_type_taxonomy')) {
	function inlife_register_career_entry_type_taxonomy() {
		$labels = [
			'name'              => __('Typ komunikatu', 'newinlife'),
			'singular_name'     => __('Typ komunikatu', 'newinlife'),
			'search_items'      => __('Szukaj typów', 'newinlife'),
			'all_items'         => __('Wszystkie typy', 'newinlife'),
			'edit_item'         => __('Edytuj typ', 'newinlife'),
			'update_item'       => __('Aktualizuj typ', 'newinlife'),
			'add_new_item'      => __('Dodaj nowy typ', 'newinlife'),
			'new_item_name'     => __('Nazwa nowego typu', 'newinlife'),
			'menu_name'         => __('Typ komunikatu', 'newinlife'),
		];

		register_taxonomy(
			'career_entry_type',
			['career_entry'],
			[
				'labels'            => $labels,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => 'komunikaty/typ',
					'with_front'   => false,
					'hierarchical' => false,
				],
			]
		);
	}
	add_action('init', 'inlife_register_career_entry_type_taxonomy', 5);
}