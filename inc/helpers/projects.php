<?php
defined('ABSPATH') || exit;

if (!function_exists('inlife_get_project_url')) {
	function inlife_get_project_url($post_id): string {
		if (!function_exists('get_field')) {
			return get_permalink($post_id);
		}

		$mode = get_field('project_template_mode', $post_id);
		$url  = get_field('project_custom_url', $post_id);

		if (in_array($mode, ['hub_page', 'external_url'], true) && !empty($url)) {
			return esc_url($url);
		}

		return get_permalink($post_id);
	}
}

if (!function_exists('inlife_is_project_external')) {
	function inlife_is_project_external($post_id): bool {
		if (!function_exists('get_field')) {
			return false;
		}

		return 'external_url' === get_field('project_template_mode', $post_id);
	}
}

add_action('template_redirect', 'inlife_redirect_project_to_custom_url');

function inlife_redirect_project_to_custom_url() {
	if (!is_singular('projects') || is_admin()) {
		return;
	}

	if (!function_exists('get_field')) {
		return;
	}

	$post_id = get_queried_object_id();
	if (!$post_id) {
		return;
	}

	$mode = get_field('project_template_mode', $post_id);
	$url  = get_field('project_custom_url', $post_id);

	if (!in_array($mode, ['hub_page', 'external_url'], true)) {
		return;
	}

	if (empty($url)) {
		return;
	}

	wp_safe_redirect($url, 301);
	exit;
}

if (!function_exists('inlife_get_projects_for_term')) {
	function inlife_get_projects_for_term(int $term_id): WP_Query {
		return new WP_Query([
			'post_type'      => 'projects',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'tax_query'      => [
				[
					'taxonomy' => 'project_type',
					'field'    => 'term_id',
					'terms'    => $term_id,
				],
			],
		]);
	}
}

if (!function_exists('inlife_get_project_type_total_count')) {
	function inlife_get_project_type_total_count(int $term_id): int {
		$term_ids = [$term_id];

		$descendants = get_terms([
			'taxonomy'   => 'project_type',
			'hide_empty' => false,
			'fields'     => 'ids',
			'child_of'   => $term_id,
		]);

		if (!is_wp_error($descendants) && !empty($descendants)) {
			$term_ids = array_merge($term_ids, $descendants);
		}

		$query = new WP_Query([
			'post_type'      => 'projects',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'tax_query'      => [
				[
					'taxonomy'         => 'project_type',
					'field'            => 'term_id',
					'terms'            => $term_ids,
					'include_children' => false,
				],
			],
		]);

		return (int) $query->found_posts;
	}
}