<?php
/**
 * Events archive content.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$upcoming_events = function_exists( 'inlife_get_upcoming_events' )
	? inlife_get_upcoming_events( 10 )
	: null;
?>

<section
	class="page-section page-section--tight page-section--events-upcoming"
	aria-labelledby="events-upcoming-heading"
>
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="section-heading section-heading--events">
			<h2 id="events-upcoming-heading" class="section-title">
				<?php echo esc_html( inlife_t( 'Kalendarz' ) ); ?>
			</h2>

			<?php get_template_part( 'template-parts/events/events-archive-types' ); ?>
		</div>

		<?php if ( $upcoming_events instanceof WP_Query && $upcoming_events->have_posts() ) : ?>

			<div class="events-list">

				<?php while ( $upcoming_events->have_posts() ) : ?>
					<?php
					$upcoming_events->the_post();

					get_template_part(
						'template-parts/events/events-card',
						null,
						[
							'post_id'       => get_the_ID(),
							'heading_level' => 3,
						]
					);
					?>
				<?php endwhile; ?>

			</div>

		<?php else : ?>

			<div class="events-empty-state">
				<p>
					<?php echo esc_html( inlife_t( 'Obecnie nie ma zaplanowanych nadchodzących wydarzeń.' ) ); ?>
				</p>
			</div>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</div>
</section>
