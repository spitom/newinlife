<?php
/**
 * Career helpers
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

if (!function_exists('inlife_get_career_entry_type_label')) {
	function inlife_get_career_entry_type_label($post_id = 0) {
		$post_id = $post_id ?: get_the_ID();
		$terms = get_the_terms($post_id, 'career_entry_type');

		if (empty($terms) || is_wp_error($terms)) {
			return '';
		}

		return $terms[0]->name;
	}
}

if (!function_exists('inlife_format_career_date')) {
	function inlife_format_career_date($date_value) {
		if (empty($date_value)) {
			return '';
		}

		$timestamp = strtotime($date_value);

		if (!$timestamp) {
			return '';
		}

		return date_i18n('d.m.Y', $timestamp);
	}
}

if (!function_exists('inlife_get_current_request_url')) {
	function inlife_get_current_request_url() {
		$request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
		return home_url($request_uri);
	}
}

if (!function_exists('inlife_is_current_career_subnav_link')) {
	function inlife_is_current_career_subnav_link($type = '') {
		if (!is_singular('career_entry') && !is_post_type_archive('career_entry') && !is_page_template('page-templates/template-career-opportunities.php') && !is_page_template('page-templates/template-career-landing.php')) {
			return false;
		}

		$current_type = isset($_GET['career_type']) ? sanitize_text_field(wp_unslash($_GET['career_type'])) : '';

		if (is_singular('career_entry')) {
			$post_id = get_the_ID();

			if (!$type) {
				return false;
			}

			return has_term($type, 'career_entry_type', $post_id);
		}

		if ('landing' === $type) {
			return is_page_template('page-templates/template-career-landing.php');
		}

		if ('opportunities' === $type) {
			return is_page_template('page-templates/template-career-opportunities.php') || is_post_type_archive('career_entry');
		}

		return $current_type === $type;
	}
}