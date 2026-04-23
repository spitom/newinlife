<?php
/**
 * InLife breadcrumbs helpers
 *
 * Global breadcrumb system with normalized output for:
 * - pages
 * - singular CPT
 * - post type archives
 * - taxonomies
 * - search
 * - 404
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_breadcrumb_items' ) ) {
	/**
	 * Returns normalized breadcrumb items.
	 *
	 * Each item structure:
	 * [
	 *   'url'     => '',
	 *   'label'   => '',
	 *   'current' => false,
	 * ]
	 *
	 * Priority:
	 * 1. Custom items passed directly
	 * 2. Rank Math integration hook point
	 * 3. Yoast integration hook point
	 * 4. InLife custom fallback
	 *
	 * @param array $args Optional arguments.
	 * @return array
	 */
	function inlife_get_breadcrumb_items( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'items'     => [],
				'show_home' => true,
			]
		);

		if ( ! empty( $args['items'] ) && is_array( $args['items'] ) ) {
			return inlife_normalize_breadcrumb_items( $args['items'] );
		}

		$rank_math_items = inlife_get_rank_math_breadcrumb_items();
		if ( ! empty( $rank_math_items ) ) {
			return $rank_math_items;
		}

		$yoast_items = inlife_get_yoast_breadcrumb_items();
		if ( ! empty( $yoast_items ) ) {
			return $yoast_items;
		}

		return inlife_get_custom_breadcrumb_items(
			[
				'show_home' => (bool) $args['show_home'],
			]
		);
	}
}

if ( ! function_exists( 'inlife_normalize_breadcrumb_items' ) ) {
	/**
	 * Normalizes breadcrumb items to a consistent structure.
	 *
	 * @param array $items Raw items.
	 * @return array
	 */
	function inlife_normalize_breadcrumb_items( $items ) {
		$normalized = [];

		foreach ( $items as $item ) {
			$label   = isset( $item['label'] ) ? trim( wp_strip_all_tags( (string) $item['label'] ) ) : '';
			$url     = isset( $item['url'] ) ? (string) $item['url'] : '';
			$current = ! empty( $item['current'] );

			if ( '' === $label ) {
				continue;
			}

			$normalized[] = [
				'label'   => $label,
				'url'     => $url,
				'current' => $current,
			];
		}

		$count = count( $normalized );

		if ( $count > 0 ) {
			foreach ( $normalized as $index => $item ) {
				$normalized[ $index ]['current'] = ( $index === $count - 1 );

				if ( $normalized[ $index ]['current'] ) {
					$normalized[ $index ]['url'] = '';
				}
			}
		}

		return $normalized;
	}
}

if ( ! function_exists( 'inlife_get_rank_math_breadcrumb_items' ) ) {
	/**
	 * Placeholder for Rank Math integration.
	 *
	 * We intentionally do not scrape plugin-generated HTML.
	 * If needed later, this function can be expanded with a controlled integration.
	 *
	 * @return array
	 */
	function inlife_get_rank_math_breadcrumb_items() {
		if ( ! function_exists( 'rank_math_the_breadcrumbs' ) ) {
			return [];
		}

		return [];
	}
}

if ( ! function_exists( 'inlife_get_yoast_breadcrumb_items' ) ) {
	/**
	 * Placeholder for Yoast integration.
	 *
	 * We intentionally do not scrape plugin-generated HTML.
	 * If needed later, this function can be expanded with a controlled integration.
	 *
	 * @return array
	 */
	function inlife_get_yoast_breadcrumb_items() {
		if ( ! function_exists( 'yoast_breadcrumb' ) ) {
			return [];
		}

		return [];
	}
}

if ( ! function_exists( 'inlife_get_custom_breadcrumb_items' ) ) {
	/**
	 * Builds custom breadcrumb trail.
	 *
	 * @param array $args Optional arguments.
	 * @return array
	 */
	function inlife_get_custom_breadcrumb_items( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'show_home' => true,
			]
		);

		$items = [];

		if ( $args['show_home'] ) {
			$items[] = [
				'label'   => inlife_t( 'Strona główna' ),
				'url'     => home_url( '/' ),
				'current' => false,
			];
		}

		if ( is_front_page() ) {
			if ( ! empty( $items ) ) {
				$last_index = count( $items ) - 1;

				$items[ $last_index ]['url']     = '';
				$items[ $last_index ]['current'] = true;
			}

			return $items;
		}

		if ( is_home() ) {
			$posts_page_id = (int) get_option( 'page_for_posts' );

			$items[] = [
				'label'   => $posts_page_id ? get_the_title( $posts_page_id ) : inlife_t( 'Aktualności' ),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_singular() ) {
			$items = array_merge( $items, inlife_get_singular_breadcrumb_items() );
			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_post_type_archive() ) {
			$items[] = [
				'label'   => post_type_archive_title( '', false ),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_tax() || is_category() || is_tag() ) {
			$items = array_merge( $items, inlife_get_taxonomy_breadcrumb_items() );
			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_search() ) {
			$items[] = [
				'label'   => sprintf(
					/* translators: %s: search query */
					inlife_t( 'Wyniki wyszukiwania: %s' ),
					get_search_query()
				),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_404() ) {
			$items[] = [
				'label'   => inlife_t( 'Nie znaleziono strony' ),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_author() ) {
			$author = get_queried_object();

			$items[] = [
				'label'   => ! empty( $author->display_name ) ? $author->display_name : inlife_t( 'Autor' ),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		if ( is_date() ) {
			$items[] = [
				'label'   => get_the_archive_title(),
				'url'     => '',
				'current' => true,
			];

			return inlife_normalize_breadcrumb_items( $items );
		}

		$items[] = [
			'label'   => wp_get_document_title(),
			'url'     => '',
			'current' => true,
		];

		return inlife_normalize_breadcrumb_items( $items );
	}
}

if ( ! function_exists( 'inlife_get_singular_breadcrumb_items' ) ) {
	/**
	 * Returns breadcrumb items for singular views.
	 *
	 * @return array
	 */
	function inlife_get_singular_breadcrumb_items() {
		$post_id   = get_queried_object_id();
		$post_type = get_post_type( $post_id );
		$items     = [];

		if ( ! $post_id || ! $post_type ) {
			return $items;
		}

		if ( 'page' === $post_type ) {
			$ancestors = array_reverse( get_post_ancestors( $post_id ) );

			foreach ( $ancestors as $ancestor_id ) {
				$items[] = [
					'label'   => get_the_title( $ancestor_id ),
					'url'     => get_permalink( $ancestor_id ),
					'current' => false,
				];
			}

			$items[] = [
				'label'   => get_the_title( $post_id ),
				'url'     => '',
				'current' => true,
			];

			return $items;
		}

		if ( 'post' === $post_type ) {
			$context             = function_exists( 'inlife_get_entry_context' ) ? inlife_get_entry_context() : '';
			$default_category_id = (int) get_option( 'default_category' );

			/* =========================================
			   CONTEXT: SOCIETY
			========================================= */
			if ( 'society' === $context ) {
				$society_page = function_exists( 'inlife_get_society_archive_page' )
					? inlife_get_society_archive_page()
					: null;

				if ( $society_page ) {
					$items[] = [
						'label'   => get_the_title( $society_page->ID ),
						'url'     => get_permalink( $society_page->ID ),
						'current' => false,
					];
				} else {
					$items[] = [
						'label'   => inlife_t( 'Społeczeństwo' ),
						'url'     => '',
						'current' => false,
					];
				}

				$items[] = [
					'label'   => get_the_title( $post_id ),
					'url'     => '',
					'current' => true,
				];

				return $items;
			}

			/* =========================================
			   DEFAULT: NEWS / POSTS PAGE
			========================================= */

			$posts_page_id = (int) get_option( 'page_for_posts' );

			$items[] = [
				'label'   => $posts_page_id ? get_the_title( $posts_page_id ) : inlife_t( 'Aktualności' ),
				'url'     => $posts_page_id ? get_permalink( $posts_page_id ) : '',
				'current' => false,
			];

			$categories = get_the_category( $post_id );

			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				$primary_category = null;

				foreach ( $categories as $category ) {
					if ( ! $category instanceof WP_Term ) {
						continue;
					}

					if ( (int) $category->term_id === $default_category_id ) {
						continue;
					}

					$primary_category = $category;
					break;
				}

				if ( $primary_category ) {
					$items = array_merge(
						$items,
						inlife_get_term_ancestor_items( $primary_category )
					);

					$items[] = [
						'label'   => $primary_category->name,
						'url'     => get_term_link( $primary_category ),
						'current' => false,
					];
				}
			}

			$items[] = [
				'label'   => get_the_title( $post_id ),
				'url'     => '',
				'current' => true,
			];

			return $items;
		}

		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type_object && $post_type_object->has_archive ) {
			$items[] = [
				'label'   => $post_type_object->labels->name,
				'url'     => get_post_type_archive_link( $post_type ),
				'current' => false,
			];
		}

		$taxonomy_items = inlife_get_primary_taxonomy_breadcrumb_items( $post_id, $post_type );
		if ( ! empty( $taxonomy_items ) ) {
			$items = array_merge( $items, $taxonomy_items );
		}

		$items[] = [
			'label'   => get_the_title( $post_id ),
			'url'     => '',
			'current' => true,
		];

		return $items;
	}
}

if ( ! function_exists( 'inlife_get_primary_taxonomy_breadcrumb_items' ) ) {
	/**
	 * Returns a taxonomy branch for selected CPTs.
	 *
	 * @param int    $post_id   Post ID.
	 * @param string $post_type Post type.
	 * @return array
	 */
	function inlife_get_primary_taxonomy_breadcrumb_items( $post_id, $post_type ) {
		$taxonomy_map = [
			'projects'     => 'project_type',
			'teams'        => '',
			'people'       => 'people_type',
			'laboratories' => '',
			'publications' => '',
		];

		$taxonomy = isset( $taxonomy_map[ $post_type ] ) ? $taxonomy_map[ $post_type ] : '';

		if ( ! $taxonomy || ! taxonomy_exists( $taxonomy ) ) {
			return [];
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return [];
		}

		$term = array_shift( $terms );

		if ( ! $term || is_wp_error( $term ) ) {
			return [];
		}

		$items = inlife_get_term_ancestor_items( $term );

		$items[] = [
			'label'   => $term->name,
			'url'     => get_term_link( $term ),
			'current' => false,
		];

		return $items;
	}
}

if ( ! function_exists( 'inlife_get_taxonomy_breadcrumb_items' ) ) {
	/**
	 * Returns breadcrumb items for taxonomy archives.
	 *
	 * @return array
	 */
	function inlife_get_taxonomy_breadcrumb_items() {
		$items = [];
		$term  = get_queried_object();

		if ( ! $term || empty( $term->term_id ) || empty( $term->taxonomy ) ) {
			return $items;
		}

		$taxonomy_object = get_taxonomy( $term->taxonomy );

		if ( $taxonomy_object && ! empty( $taxonomy_object->object_type[0] ) ) {
			$post_type        = $taxonomy_object->object_type[0];
			$post_type_object = get_post_type_object( $post_type );

			if ( $post_type_object && $post_type_object->has_archive ) {
				$items[] = [
					'label'   => $post_type_object->labels->name,
					'url'     => get_post_type_archive_link( $post_type ),
					'current' => false,
				];
			}
		}

		$items = array_merge( $items, inlife_get_term_ancestor_items( $term ) );

		$items[] = [
			'label'   => single_term_title( '', false ),
			'url'     => '',
			'current' => true,
		];

		return $items;
	}
}

if ( ! function_exists( 'inlife_get_term_ancestor_items' ) ) {
	/**
	 * Returns breadcrumb items for ancestor terms.
	 *
	 * @param WP_Term $term Current term.
	 * @return array
	 */
	function inlife_get_term_ancestor_items( $term ) {
		$items = [];

		if ( ! $term || empty( $term->term_id ) || empty( $term->taxonomy ) ) {
			return $items;
		}

		$ancestor_ids = array_reverse(
			get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' )
		);

		foreach ( $ancestor_ids as $ancestor_id ) {
			$ancestor = get_term( $ancestor_id, $term->taxonomy );

			if ( ! $ancestor || is_wp_error( $ancestor ) ) {
				continue;
			}

			$items[] = [
				'label'   => $ancestor->name,
				'url'     => get_term_link( $ancestor ),
				'current' => false,
			];
		}

		return $items;
	}
}

if ( ! function_exists( 'inlife_get_entry_context' ) ) {
	/**
	 * Returns entry context from URL query arg.
	 *
	 * Supported examples:
	 * ?from=society
	 *
	 * @return string
	 */
	function inlife_get_entry_context() {
		if ( isset( $_GET['from'] ) ) {
			return sanitize_key( wp_unslash( $_GET['from'] ) );
		}

		return '';
	}
}

if ( ! function_exists( 'inlife_get_society_archive_page' ) ) {
	/**
	 * Returns the page assigned to the Society archive template.
	 *
	 * @return WP_Post|null
	 */
	function inlife_get_society_archive_page() {
		$pages = get_posts(
			[
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/template-society-archive.php',
				'posts_per_page' => 1,
				'no_found_rows'  => true,
			]
		);

		if ( empty( $pages ) ) {
			return null;
		}

		return $pages[0];
	}
}

if ( ! function_exists( 'inlife_get_posts_listing_url_for_context' ) ) {
	function inlife_get_posts_listing_url_for_context() {

		$context = function_exists( 'inlife_get_entry_context' )
			? inlife_get_entry_context()
			: '';

		// SOCIETY
		if ( 'society' === $context ) {

			// jeśli masz konkretną stronę
			$page = get_page_by_path( 'spoleczenstwo/artykuly' );

			if ( $page ) {
				return get_permalink( $page );
			}

			// fallback (ważne)
			return home_url( '/spoleczenstwo/artykuly/' );
		}

		// DEFAULT: Aktualności
		$posts_page_id = (int) get_option( 'page_for_posts' );

		if ( $posts_page_id ) {
			return get_permalink( $posts_page_id );
		}

		return home_url( '/' );
	}
}