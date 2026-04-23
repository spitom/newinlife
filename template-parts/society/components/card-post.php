<?php
/**
 * Society post card
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? 0;

if ( ! $post_id ) {
	return;
}

$permalink = get_permalink( $post_id );
$title     = get_the_title( $post_id );
$excerpt   = get_the_excerpt( $post_id );
$badge     = function_exists( 'inlife_get_society_format_label' )
	? inlife_get_society_format_label( $post_id )
	: '';

if ( ! $permalink || ! $title ) {
	return;
}
?>

<article class="society-card society-card--post c-card c-card--with-media">
	<div class="society-card__frame c-card__frame c-card__frame--cut-tl">
		<div class="society-card__inner c-card__inner">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<div class="society-card__media c-card__media">
					<a
						class="society-card__media-link c-card__media-link"
						href="<?php echo esc_url( $permalink ); ?>"
						aria-hidden="true"
						tabindex="-1"
					>
						<?php
						echo get_the_post_thumbnail(
							$post_id,
							'medium_large',
							false,
							[
								'class' => 'society-card__image c-card__image',
								'alt'   => '',
							]
						);
						?>
					</a>
				</div>
			<?php endif; ?>

			<div class="society-card__body c-card__body">
				<?php if ( $badge ) : ?>
					<p class="society-card__badge"><?php echo esc_html( $badge ); ?></p>
				<?php endif; ?>

				<h3 class="society-card__title c-card__title">
					<a href="<?php echo esc_url( $permalink ); ?>">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<div class="society-card__text">
						<p><?php echo esc_html( $excerpt ); ?></p>
					</div>
				<?php endif; ?>

				<a class="c-readmore" href="<?php echo esc_url( $permalink ); ?>">
					<?php echo esc_html( inlife_t( 'Zobacz więcej' ) ); ?>
					<span class="visually-hidden"><?php echo esc_html( $title ); ?></span>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</div>
</article>