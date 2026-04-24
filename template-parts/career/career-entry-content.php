<?php
/**
 * Career entry content
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;
?>

<article class="career-entry-content">
	<div class="career-entry-content__body entry-content">
		<?php the_content(); ?>
	</div>

	<?php
	$hide_share = false;

	$terms = get_the_terms( get_the_ID(), 'career_entry_type' );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$type_key = function_exists( 'inlife_get_career_type_key_from_slug' )
				? inlife_get_career_type_key_from_slug( $term->slug )
				: $term->slug;

			if ( in_array( $type_key, [ 'archive', 'archiwum' ], true ) || in_array( $term->slug, [ 'archive', 'archiwum' ], true ) ) {
				$hide_share = true;
				break;
			}
		}
	}
	?>

	<?php if ( ! $hide_share ) : ?>
		<footer class="career-entry-content__footer">
			<?php if ( function_exists( 'inlife_get_share_links' ) ) : ?>
				<?php $share = inlife_get_share_links(); ?>

				<div class="post-share career-entry-share">
					<span class="post-share__label"><?php echo esc_html( inlife_t( 'Udostępnij:' ) ); ?></span>

					<div class="post-share__list">
						<button
							class="post-share__item js-copy-link"
							data-url="<?php echo esc_url( $share['copy'] ); ?>"
							type="button"
						>
							<span class="bi bi-link-45deg"></span>
						</button>

						<a class="post-share__item" href="<?php echo esc_url( $share['facebook'] ); ?>" target="_blank" rel="noopener">
							<span class="bi bi-facebook"></span>
						</a>

						<a class="post-share__item" href="<?php echo esc_url( $share['linkedin'] ); ?>" target="_blank" rel="noopener">
							<span class="bi bi-linkedin"></span>
						</a>

						<a class="post-share__item" href="<?php echo esc_url( $share['mail'] ); ?>">
							<span class="bi bi-envelope"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</footer>
	<?php endif; ?>
</article>