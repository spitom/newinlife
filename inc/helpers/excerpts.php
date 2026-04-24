<?php
/**
 * Excerpt helpers.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_card_excerpt' ) ) {
	/**
	 * Returns a clean text excerpt for cards, without WP "read more" HTML.
	 *
	 * @param int $post_id Post ID.
	 * @param int $words   Number of words.
	 * @param string $more More indicator.
	 * @return string
	 */
	function inlife_get_card_excerpt( int $post_id = 0, int $words = 24, string $more = '…' ): string {
		$post_id = $post_id ?: get_the_ID();

		if ( ! $post_id ) {
			return '';
		}

		$manual_excerpt = get_post_field( 'post_excerpt', $post_id );

		if ( '' !== trim( (string) $manual_excerpt ) ) {
			$text = $manual_excerpt;
		} else {
			$text = get_post_field( 'post_content', $post_id );
		}

		$text = strip_shortcodes( (string) $text );
		$text = wp_strip_all_tags( $text, true );
		$text = preg_replace( '/\s+/', ' ', $text );
		$text = trim( (string) $text );

		if ( '' === $text ) {
			return '';
		}

		return wp_trim_words( $text, $words, $more );
	}
}