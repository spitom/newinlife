<?php
/**
 * Laboratory archive card.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

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

<article class="laboratory-card">
	<div class="laboratory-card__inner">

		<div class="laboratory-card__media">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'medium_large',
					array(
						'class'   => 'laboratory-card__image',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<div class="laboratory-card__placeholder" aria-hidden="true">
					<span><?php echo esc_html( inlife_t( 'Laboratorium' ) ); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<div class="laboratory-card__body">
			<h3 class="laboratory-card__title">
				<a href="<?php the_permalink(); ?>" class="laboratory-card__title-link">
					<?php the_title(); ?>
				</a>
			</h3>

			<?php if ( $excerpt ) : ?>
				<p class="laboratory-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="laboratory-card__link">
				<?php echo esc_html( inlife_t( 'Zobacz laboratorium' ) ); ?> →
			</a>
		</div>

	</div>
</article>