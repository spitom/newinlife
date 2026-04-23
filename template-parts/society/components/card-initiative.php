<?php
/**
 * Society initiative card
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? 0;

if ( ! $post_id ) {
	return;
}

$permalink = get_permalink( $post_id );
$title     = function_exists( 'get_field' ) ? get_field( 'initiative_title', $post_id ) : '';
$lead      = function_exists( 'get_field' ) ? get_field( 'initiative_card_text', $post_id ) : '';

$title = $title ?: get_the_title( $post_id );

if ( ! $permalink || ! $title ) {
	return;
}
?>

<article class="society-card society-card--initiative c-card c-card--with-media">
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
				<h3 class="society-card__title c-card__title">
					<a href="<?php echo esc_url( $permalink ); ?>">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>

				<?php if ( $lead ) : ?>
					<div class="society-card__text">
						<p><?php echo esc_html( $lead ); ?></p>
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