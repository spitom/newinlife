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
	$primary_type = function_exists( 'inlife_get_career_entry_primary_type' )
		? inlife_get_career_entry_primary_type( (int) get_the_ID() )
		: null;

	$type_behavior = array(
		'show_share' => true,
	);

	if (
		$primary_type instanceof WP_Term &&
		function_exists( 'inlife_get_career_type_behavior' )
	) {
		$type_behavior = array_merge(
			$type_behavior,
			inlife_get_career_type_behavior( $primary_type )
		);
	}

	$show_share = ! empty( $type_behavior['show_share'] );
	?>

	<?php if ( $show_share ) : ?>
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
							aria-label="<?php echo esc_attr( inlife_t( 'Kopiuj link do ogłoszenia' ) ); ?>"
						>
							<span class="bi bi-link-45deg" aria-hidden="true"></span>
						</button>

						<a
							class="post-share__item"
							href="<?php echo esc_url( $share['facebook'] ); ?>"
							target="_blank"
							rel="noopener"
							aria-label="<?php echo esc_attr( inlife_t( 'Udostępnij ogłoszenie na Facebooku' ) ); ?>"
						>
							<span class="bi bi-facebook" aria-hidden="true"></span>
						</a>

						<a
							class="post-share__item"
							href="<?php echo esc_url( $share['linkedin'] ); ?>"
							target="_blank"
							rel="noopener"
							aria-label="<?php echo esc_attr( inlife_t( 'Udostępnij ogłoszenie na LinkedIn' ) ); ?>"
						>
							<span class="bi bi-linkedin" aria-hidden="true"></span>
						</a>

						<a
							class="post-share__item"
							href="<?php echo esc_url( $share['mail'] ); ?>"
							aria-label="<?php echo esc_attr( inlife_t( 'Wyślij ogłoszenie e-mailem' ) ); ?>"
						>
							<span class="bi bi-envelope" aria-hidden="true"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</footer>
	<?php endif; ?>
</article>