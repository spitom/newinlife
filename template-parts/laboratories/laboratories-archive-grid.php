<?php
/**
 * Laboratories archive grid.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="laboratories-grid section">
	<div class="<?php echo esc_attr( inlife_container_class() ); ?>">

		<?php if ( have_posts() ) : ?>
			<div class="laboratories-grid__listing c-card-grid c-card-grid--3">

				<?php while ( have_posts() ) : the_post(); ?>
					<div class="laboratories-grid__item">
						<?php get_template_part( 'template-parts/laboratories/laboratories', 'card' ); ?>
					</div>
				<?php endwhile; ?>

			</div>
		<?php else : ?>
			<div class="team-empty-state">
				<p><?php echo esc_html( inlife_t( 'Lista laboratoriów zostanie uzupełniona wkrótce.' ) ); ?></p>
			</div>
		<?php endif; ?>

	</div>
</section>