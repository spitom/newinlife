<?php
defined('ABSPATH') || exit;

if (!function_exists('inlife_get_page_id_by_template')) {
	function inlife_get_page_id_by_template($template) {
		$args = [
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $template,
		];

		if (function_exists('pll_current_language')) {
			$args['lang'] = pll_current_language('slug');
		}

		$pages = get_posts($args);

		if (!empty($pages)) {
			return (int) $pages[0]->ID;
		}

		return 0;
	}
}

if (!function_exists('inlife_get_career_landing_url')) {
	function inlife_get_career_landing_url() {
		$page_id = inlife_get_page_id_by_template('page-templates/template-career-landing.php');
		return $page_id ? get_permalink($page_id) : home_url('/');
	}
}

if (!function_exists('inlife_get_career_opportunities_url')) {
	function inlife_get_career_opportunities_url() {
		$page_id = inlife_get_page_id_by_template('page-templates/template-career-opportunities.php');
		return $page_id ? get_permalink($page_id) : home_url('/');
	}
}