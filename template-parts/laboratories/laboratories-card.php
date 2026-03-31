<?php
/**
 * Laboratories archive card.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$laboratory_id = get_the_ID();

/**
 * Obraz karty:
 * 1. ACF laboratory_hero_image
 * 2. featured image
 */
$card_image_id = 0;

if ( function_exists( 'get_field' ) ) {
	$laboratory_hero_image = get_field( 'laboratory_hero_image', $laboratory_id );

	if ( is_array( $laboratory_hero_image ) && ! empty( $laboratory_hero_image['ID'] ) ) {
		$card_image_id = (int) $laboratory_hero_image['ID'];
	} elseif ( is_numeric( $laboratory_hero_image ) ) {
		$card_image_id = (int) $laboratory_hero_image;
	}
}

if ( ! $card_image_id && has_post_thumbnail( $laboratory_id ) ) {
	$card_image_id = get_post_thumbnail_id( $laboratory_id );
}
?>

<article <?php post_class( 'laboratory-card' ); ?>>
	<div class="laboratory-card__inner">

		<div class="laboratory-card__media">
			<a class="laboratory-card__media-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php if ( $card_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$card_image_id,
						'large',
						false,
						array(
							'class' => 'laboratory-card__image',
							'alt'   => '',
						)
					);
					?>
				<?php else : ?>
					<div class="laboratory-card__placeholder">
						<span><?php echo esc_html( inlife_t( 'Laboratorium' ) ); ?></span>
					</div>
				<?php endif; ?>
			</a>
		</div>

		<div class="laboratory-card__body">
			<h2 class="laboratory-card__title">
				<a class="laboratory-card__title-link" href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>

			<a class="laboratory-card__link" href="<?php the_permalink(); ?>">
				<?php echo esc_html( inlife_t( 'Zobacz laboratorium' ) ); ?> <span aria-hidden="true">→</span>
			</a>
		</div>

	</div>
</article>