<?php
/**
 * Teams archive card.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$team_id = get_the_ID();
$terms   = get_the_terms( $team_id, 'team_area' );

/**
 * Obraz karty:
 * 1. ACF team_hero_image (jeśli istnieje)
 * 2. featured image
 */
$card_image_id = 0;

if ( function_exists( 'get_field' ) ) {
	$team_hero_image = get_field( 'team_hero_image', $team_id );

	if ( is_array( $team_hero_image ) && ! empty( $team_hero_image['ID'] ) ) {
		$card_image_id = (int) $team_hero_image['ID'];
	} elseif ( is_numeric( $team_hero_image ) ) {
		$card_image_id = (int) $team_hero_image;
	}
}

if ( ! $card_image_id && has_post_thumbnail( $team_id ) ) {
	$card_image_id = get_post_thumbnail_id( $team_id );
}
?>

<article <?php post_class( 'team-card c-card c-card--unit c-card--with-media' ); ?>>
	<div class="team-card__frame c-card__frame c-card__frame--cut-tl">
		<div class="team-card__inner c-card__inner">

			<div class="team-card__media c-card__media">
				<a class="team-card__media-link c-card__media-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php if ( $card_image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$card_image_id,
							'large',
							false,
							array(
								'class' => 'team-card__image c-card__image',
								'alt'   => '',
							)
						);
						?>
					<?php else : ?>
						<div class="team-card__placeholder c-card__placeholder">
							<span><?php echo esc_html( inlife_t( 'Zespół badawczy' ) ); ?></span>
						</div>
					<?php endif; ?>
				</a>
			</div>

			<div class="team-card__body c-card__body">

				<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="team-card__areas" aria-label="<?php echo esc_attr( inlife_t( 'Obszary badawcze' ) ); ?>">
						<?php foreach ( $terms as $term ) : ?>
							<span class="team-card__area">
								<?php echo esc_html( $term->name ); ?>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<h2 class="team-card__title c-card__title">
					<a class="team-card__title-link c-card__title-link" href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>

				<a class="team-card__link c-readmore" href="<?php the_permalink(); ?>">
					<?php echo esc_html( inlife_t( 'Zobacz zespół' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>

			</div>
		
		</div>
	</div>
</article>