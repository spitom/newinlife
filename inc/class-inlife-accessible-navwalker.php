<?php
defined('ABSPATH') || exit;

class Inlife_Accessible_Navwalker extends Walker_Nav_Menu {

	/**
	 * Storage for submenu ids keyed by depth.
	 *
	 * @var array
	 */
	protected $submenu_ids = [];

	/**
	 * Build localized toggle label.
	 */
	protected function get_toggle_label(string $title, bool $expanded = false): string {
		$title = wp_strip_all_tags($title);

		$is_english = function_exists('pll_current_language') && pll_current_language() === 'en';

		if ($is_english) {
			return $expanded
				? sprintf('Collapse submenu: %s', $title)
				: sprintf('Expand submenu: %s', $title);
		}

		return $expanded
			? sprintf('Zwiń podmenu: %s', $title)
			: sprintf('Rozwiń podmenu: %s', $title);
	}

	/**
	 * Start submenu level.
	 */
	public function start_lvl(&$output, $depth = 0, $args = null) {
		$indent = str_repeat("\t", $depth);

		$submenu_id = $this->submenu_ids[$depth] ?? '';

		$classes = [
			'sub-menu',
			'sub-menu-depth-' . (int) $depth,
		];

		$class_names = implode(' ', array_map('sanitize_html_class', $classes));

		$id_attr = $submenu_id ? ' id="' . esc_attr($submenu_id) . '"' : '';

		$output .= "\n{$indent}<ul{$id_attr} class=\"" . esc_attr($class_names) . "\" hidden>\n";
	}

	/**
	 * End submenu level.
	 */
	public function end_lvl(&$output, $depth = 0, $args = null) {
		$indent = str_repeat("\t", $depth);
		$output .= "{$indent}</ul>\n";

		if (isset($this->submenu_ids[$depth])) {
			unset($this->submenu_ids[$depth]);
		}
	}

	/**
	 * Start menu item.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$indent = $depth ? str_repeat("\t", $depth) : '';

		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$classes[] = 'nav-item';
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array('menu-item-has-children', $classes, true);

		if ($has_children) {
			$classes[] = 'nav-item-has-children';
		}

		if ($depth > 0) {
			$classes[] = 'submenu-item';
		}

		$class_names = implode(' ', array_filter(array_map('sanitize_html_class', $classes)));

		$output .= $indent . '<li class="' . esc_attr($class_names) . '">';

		$title = apply_filters('the_title', $item->title, $item->ID);
		$title_plain = wp_strip_all_tags($title);

		$link_classes = $depth === 0 ? 'nav-link' : 'submenu-link dropdown-item';

		$atts = [
			'class' => $link_classes,
			'href'  => ! empty($item->url) ? $item->url : '',
		];

		if (! empty($item->attr_title)) {
			$atts['title'] = $item->attr_title;
		}

		if (! empty($item->target)) {
			$atts['target'] = $item->target;
		}

		if (! empty($item->xfn)) {
			$atts['rel'] = $item->xfn;
		}

		if (
			! empty($item->current) ||
			! empty($item->current_item_ancestor) ||
			! empty($item->current_item_parent)
		) {
			$atts['aria-current'] = 'page';
		}

		$link_attributes = '';
		foreach ($atts as $attr => $value) {
			if ($value !== '') {
				$link_attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
			}
		}

		if ($has_children) {
			$submenu_id = 'submenu-' . (int) $item->ID;
			$this->submenu_ids[$depth] = $submenu_id;

			$toggle_label = $this->get_toggle_label($title_plain, false);

			$output .= '<div class="nav-link-group">';

			$output .= '<a' . $link_attributes . '>';
			$output .= $args->link_before . $title . $args->link_after;
			$output .= '</a>';

			$output .= '<button'
				. ' class="submenu-toggle"'
				. ' type="button"'
				. ' aria-expanded="false"'
				. ' aria-controls="' . esc_attr($submenu_id) . '"'
				. ' aria-label="' . esc_attr($toggle_label) . '"'
				. ' data-submenu-toggle>'
				. '<span class="submenu-toggle-icon" aria-hidden="true"></span>'
				. '<span class="visually-hidden">' . esc_html($toggle_label) . '</span>'
				. '</button>';

			$output .= '</div>';
		} else {
			$output .= '<a' . $link_attributes . '>';
			$output .= $args->link_before . $title . $args->link_after;
			$output .= '</a>';
		}
	}

	/**
	 * End menu item.
	 */
	public function end_el(&$output, $item, $depth = 0, $args = null) {
		$output .= "</li>\n";
	}
}