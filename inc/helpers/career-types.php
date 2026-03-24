<?php
defined('ABSPATH') || exit;

if (!function_exists('inlife_get_career_types_map')) {
	function inlife_get_career_types_map() {
		return [
			'scientific' => [
				'pl' => 'konkursy-naukowe',
				'en' => 'scientific-positions',
				'labels' => [
					'pl' => 'Konkursy na stanowiska naukowe',
					'en' => 'Scientific positions',
				],
			],
			'jobs' => [
				'pl' => 'ogloszenia-o-prace',
				'en' => 'job-vacancies',
				'labels' => [
					'pl' => 'Ogłoszenia o pracę',
					'en' => 'Job vacancies',
				],
			],
			'results' => [
				'pl' => 'wyniki-konkursow',
				'en' => 'competition-results',
				'labels' => [
					'pl' => 'Wyniki konkursów',
					'en' => 'Competition results',
				],
			],
			'archive' => [
				'pl' => 'archiwum',
				'en' => 'archive',
				'labels' => [
					'pl' => 'Archiwum',
					'en' => 'Archive',
				],
			],
		];
	}
}

if (!function_exists('inlife_get_lang')) {
	function inlife_get_lang() {
		return function_exists('pll_current_language')
			? pll_current_language('slug')
			: 'pl';
	}
}

if (!function_exists('inlife_get_career_type_slug')) {
	function inlife_get_career_type_slug($type_key) {
		$map = inlife_get_career_types_map();
		$lang = inlife_get_lang();

		return $map[$type_key][$lang] ?? '';
	}
}

if (!function_exists('inlife_get_career_type_label')) {
	function inlife_get_career_type_label($type_key) {
		$map = inlife_get_career_types_map();
		$lang = inlife_get_lang();

		return $map[$type_key]['labels'][$lang] ?? ucfirst($type_key);
	}
}

if (!function_exists('inlife_get_career_type_key_from_slug')) {
	function inlife_get_career_type_key_from_slug($slug) {
		$map = inlife_get_career_types_map();

		foreach ($map as $key => $data) {
			if (in_array($slug, [$data['pl'], $data['en']], true)) {
				return $key;
			}
		}

		return null;
	}
}

if (!function_exists('inlife_get_announcements_base_slug')) {
	function inlife_get_announcements_base_slug() {
		return function_exists('pll_current_language') && pll_current_language('slug') === 'en'
			? 'announcements'
			: 'komunikaty';
	}
}

if (!function_exists('inlife_get_announcements_type_base_slug')) {
	function inlife_get_announcements_type_base_slug() {
		return function_exists('pll_current_language') && pll_current_language('slug') === 'en'
			? 'type'
			: 'typ';
	}
}

if (!function_exists('inlife_get_announcements_entry_base_slug')) {
	function inlife_get_announcements_entry_base_slug() {
		return function_exists('pll_current_language') && pll_current_language('slug') === 'en'
			? 'entry'
			: 'wpis';
	}
}

if (!function_exists('inlife_get_career_term_archive_url')) {
	function inlife_get_career_term_archive_url($type_key) {
		$term_slug = inlife_get_career_type_slug($type_key);
		$base = inlife_get_announcements_base_slug();
		$type = inlife_get_announcements_type_base_slug();

		return home_url(user_trailingslashit($base . '/' . $type . '/' . $term_slug));
	}
}