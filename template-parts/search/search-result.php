<?php
/**
 * Search result item.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

if ( ! $post_id ) {
	return;
}

$post_type = get_post_type( $post_id );

if (
	! $post_type ||
	'publish' !== get_post_status( $post_id ) ||
	( function_exists( 'inlife_get_search_post_types' ) && ! in_array( $post_type, inlife_get_search_post_types(), true ) )
) {
	return;
}

$title   = get_the_title( $post_id );
$url     = get_permalink( $post_id );
$type    = function_exists( 'inlife_get_search_type_label' ) ? inlife_get_search_type_label( $post_id ) : get_post_type( $post_id );
$summary = function_exists( 'inlife_get_search_result_summary' ) ? inlife_get_search_result_summary( $post_id ) : get_the_excerpt( $post_id );
$meta    = function_exists( 'inlife_get_search_result_meta' ) ? inlife_get_search_result_meta( $post_id ) : '';
?>

<article <?php post_class( 'search-result c-surface c-surface--record c-surface--interactive', $post_id ); ?>>
	<a class="search-result__link" href="<?php echo esc_url( $url ); ?>">
		<div class="search-result__body">
			<div class="search-result__meta">
				<span class="search-result__type c-badge c-badge--soft c-badge--compact">
					<?php echo esc_html( $type ); ?>
				</span>

				<?php if ( $meta ) : ?>
					<span class="search-result__date">
						<?php echo esc_html( $meta ); ?>
					</span>
				<?php endif; ?>
			</div>

			<h2 class="search-result__title">
				<?php echo esc_html( $title ); ?>
			</h2>

			<?php if ( $summary ) : ?>
				<p class="search-result__summary">
					<?php echo esc_html( wp_trim_words( $summary, 32 ) ); ?>
				</p>
			<?php endif; ?>
		</div>

		<span class="search-result__arrow" aria-hidden="true">→</span>
	</a>
</article>