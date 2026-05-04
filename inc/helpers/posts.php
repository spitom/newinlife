<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_card_excerpt' ) ) {
	/**
	 * Returns normalized excerpt for cards.
	 *
	 * Rules:
	 * - manual excerpt is preserved as-is (cleaned, but not trimmed again)
	 * - fallback content is trimmed to requested length
	 *
	 * @param int $post_id Post ID.
	 * @param int $length  Number of words for generated fallback excerpt.
	 * @return string
	 */
	function inlife_get_card_excerpt( $post_id, $length = 14 ) {
		$post = get_post( $post_id );

		if ( ! $post instanceof WP_Post ) {
			return '';
		}

		$raw_excerpt = trim( (string) $post->post_excerpt );

		// 1. Manual excerpt: clean it, but do not trim again.
		if ( '' !== $raw_excerpt ) {
			$excerpt = strip_shortcodes( $raw_excerpt );
			$excerpt = preg_replace( '#<a[^>]*>.*?</a>#is', '', $excerpt );
			$excerpt = preg_replace( '#<button[^>]*>.*?</button>#is', '', $excerpt );
			$excerpt = wp_strip_all_tags( $excerpt );
			$excerpt = html_entity_decode( $excerpt, ENT_QUOTES, 'UTF-8' );
			$excerpt = str_replace( [ '[…]', '[...]' ], '', $excerpt );
			$excerpt = preg_replace( '/\s+/', ' ', $excerpt );
			$excerpt = trim( (string) $excerpt );

			return $excerpt;
		}

		// 2. Fallback from content: generate a trimmed excerpt.
		$content = (string) $post->post_content;
		$content = strip_shortcodes( $content );
		$content = preg_replace( '#<a[^>]*>.*?</a>#is', '', $content );
		$content = preg_replace( '#<button[^>]*>.*?</button>#is', '', $content );
		$content = wp_strip_all_tags( $content );
		$content = html_entity_decode( $content, ENT_QUOTES, 'UTF-8' );
		$content = preg_replace( '/\[[^\]]*\]/', '', $content );
		$content = preg_replace( '/\s+/', ' ', $content );
		$content = trim( (string) $content );

		if ( '' === $content ) {
			return '';
		}

		return wp_trim_words( $content, $length, '…' );
	}
}

if ( ! function_exists( 'inlife_get_society_format_badge' ) ) {
	/**
	 * Returns translated society format badge label for a post.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function inlife_get_society_format_badge( $post_id ) {
		$terms = get_the_terms( $post_id, 'society_format' );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		$term = reset( $terms );

		$map = [
			'zobacz'             => inlife_t( 'Zobacz' ),
			'posluchaj'          => inlife_t( 'Posłuchaj' ),
			'przeczytaj'         => inlife_t( 'Przeczytaj' ),
			'spotkaj-sie-z-nami' => inlife_t( 'Spotkaj się z nami' ),
		];

		return $map[ $term->slug ] ?? $term->name;
	}
}

if ( ! function_exists( 'inlife_get_primary_post_category' ) ) {
	/**
	 * Returns the first valid category for a post, excluding the WP default category.
	 *
	 * @param int $post_id Post ID.
	 * @return WP_Term|null
	 */
	function inlife_get_primary_post_category( $post_id ) {
		$categories          = get_the_category( $post_id );
		$default_category_id = (int) get_option( 'default_category' );

		if ( empty( $categories ) || is_wp_error( $categories ) ) {
			return null;
		}

		foreach ( $categories as $category ) {
			if ( ! $category instanceof WP_Term ) {
				continue;
			}

			if ( (int) $category->term_id === $default_category_id ) {
				continue;
			}

			return $category;
		}

		return null;
	}
}

if ( ! function_exists( 'inlife_filter_main_posts_archive_query' ) ) {
	/**
	 * Filters the main posts archive query for the News page.
	 *
	 * @param WP_Query $query Query instance.
	 * @return void
	 */
	function inlife_filter_main_posts_archive_query( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( ! is_home() ) {
			return;
		}

		$query->set( 'post_type', 'post' );
		$query->set( 'post_status', 'publish' );
		$query->set(
			'meta_query',
			[
				[
					'key'     => 'show_in_main_news_archive',
					'value'   => '1',
					'compare' => '=',
				],
			]
		);
	}
}
add_action( 'pre_get_posts', 'inlife_filter_main_posts_archive_query' );

if ( ! function_exists( 'inlife_get_share_links' ) ) {
	function inlife_get_share_links( $post_id = null ) {
		$post_id = $post_id ?: get_the_ID();

		$url   = urlencode( get_permalink( $post_id ) );
		$title = urlencode( get_the_title( $post_id ) );

		return [
			'copy' => get_permalink( $post_id ),

			'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
			'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
			'mail'     => "mailto:?subject={$title}&body={$url}",
		];
	}
}

if ( ! function_exists( 'inlife_get_society_posts' ) ) {
	function inlife_get_society_posts( $limit = 4 ) {
		return get_posts( [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => 'date',
			'order'          => 'DESC',

			/* tylko posty z formatem society */
			'tax_query' => [
				[
					'taxonomy' => 'society_format',
					'field'    => 'slug',
					'operator' => 'EXISTS',
				],
			],
		] );
	}
}

if ( ! function_exists( 'inlife_get_society_archive_query_args' ) ) {
	/**
	 * Returns query args for Society archive.
	 *
	 * @param string $format_slug Optional society_format slug.
	 * @return array
	 */
	function inlife_get_society_archive_query_args( $format_slug = '' ) {
		$args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 12,
			'paged'          => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
			'orderby'        => 'date',
			'order'          => 'DESC',
			'tax_query'      => [
				[
					'taxonomy' => 'society_format',
					'field'    => 'slug',
					'operator' => 'EXISTS',
				],
			],
		];

		if ( '' !== $format_slug ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'society_format',
					'field'    => 'slug',
					'terms'    => $format_slug,
				],
			];
		}

		return $args;
	}
}

if ( ! function_exists( 'inlife_get_society_format_terms' ) ) {
	/**
	 * Returns public society format terms.
	 *
	 * @return WP_Term[]
	 */
	function inlife_get_society_format_terms() {
		$terms = get_terms(
			[
				'taxonomy'   => 'society_format',
				'hide_empty' => true,
			]
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return [];
		}

		return $terms;
	}
}

if ( ! function_exists( 'inlife_get_post_feature_media_html' ) ) {
	/**
	 * Returns embedded media HTML for a post.
	 *
	 * Supported:
	 * - audio file from media library
	 * - video file from media library
	 * - YouTube URL
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function inlife_get_post_feature_media_html( $post_id ) {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$media_type  = (string) get_field( 'media_type', $post_id );
		$audio_file  = get_field( 'audio_file', $post_id );
		$video_file  = get_field( 'video_file', $post_id );
		$youtube_url = trim( (string) get_field( 'youtube_url', $post_id ) );

		if ( 'audio_file' === $media_type && ! empty( $audio_file ) ) {
			$audio_url = is_array( $audio_file ) && ! empty( $audio_file['url'] )
				? $audio_file['url']
				: (string) $audio_file;

			if ( $audio_url ) {
				return sprintf(
					'<div class="post-feature-media post-feature-media--audio"><audio controls preload="none" src="%s"></audio></div>',
					esc_url( $audio_url )
				);
			}
		}

		if ( 'video_file' === $media_type && ! empty( $video_file ) ) {
			$video_url = is_array( $video_file ) && ! empty( $video_file['url'] )
				? $video_file['url']
				: (string) $video_file;

			if ( $video_url ) {
				return sprintf(
					'<div class="post-feature-media post-feature-media--video"><video controls preload="metadata" src="%s"></video></div>',
					esc_url( $video_url )
				);
			}
		}

		if ( 'youtube' === $media_type && $youtube_url ) {
			$embed = wp_oembed_get(
				$youtube_url,
				[
					'width' => 1280,
				]
			);

			if ( $embed ) {
				return sprintf(
					'<div class="post-feature-media post-feature-media--youtube">%s</div>',
					$embed
				);
			}
		}

		return '';
	}
}

if ( ! function_exists( 'inlife_get_post_card_image_id' ) ) {
	/**
	 * Returns image ID for post cards.
	 *
	 * Priority:
	 * 1. ACF custom card image
	 * 2. Featured image
	 *
	 * @param int $post_id Post ID.
	 * @return int
	 */
	function inlife_get_post_card_image_id( $post_id ) {
		$post_id = (int) $post_id;

		if ( ! $post_id ) {
			return 0;
		}

		$custom_image = function_exists( 'get_field' )
			? get_field( 'post_card_image', $post_id )
			: 0;

		if ( is_array( $custom_image ) && ! empty( $custom_image['ID'] ) ) {
			return (int) $custom_image['ID'];
		}

		if ( is_numeric( $custom_image ) ) {
			return (int) $custom_image;
		}

		return (int) get_post_thumbnail_id( $post_id );
	}
}