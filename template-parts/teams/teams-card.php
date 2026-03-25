<?php
/**
 * Team archive card.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$terms = get_the_terms( get_the_ID(), 'team_area' );
$area  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

$raw_excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();

$excerpt = wp_trim_words(
	wp_strip_all_tags(
		shortcode_unautop(
			strip_shortcodes( $raw_excerpt )
		)
	),
	18
);
?>

<article class="team-card">
	<div class="team-card__inner">

		<div class="team-card__media">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'medium_large',
					array(
						'class'   => 'team-card__image',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<div class="team-card__placeholder" aria-hidden="true">
					<span>
						<?php echo esc_html( $area ? $area : inlife_t( 'Zespół' ) ); ?>
					</span>
				</div>
			<?php endif; ?>
		</div>

		<div class="team-card__body">

			<?php if ( $area ) : ?>
				<span class="team-card__area"><?php echo esc_html( $area ); ?></span>
			<?php endif; ?>

			<h3 class="team-card__title">
				<a href="<?php the_permalink(); ?>" class="team-card__title-link">
					<?php the_title(); ?>
				</a>
			</h3>

			<?php if ( $excerpt ) : ?>
				<p class="team-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="team-card__link">
				<?php echo esc_html( inlife_t( 'Zobacz zespół' ) ); ?> →
			</a>

		</div>

	</div>
</article>