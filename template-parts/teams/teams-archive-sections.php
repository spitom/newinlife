<?php
/**
 * Teams archive list/grid with frontend filtering.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$query = new WP_Query(
	array(
		'post_type'      => 'teams',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'rand',
	)
);
?>

<section class="teams-listing section">
	<div class="<?php echo esc_attr( $container ); ?>">
		<?php if ( $query->have_posts() ) : ?>
			<div class="teams-listing__grid c-card-grid" data-team-grid>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					$terms = get_the_terms( get_the_ID(), 'team_area' );
					$slugs = array();

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						$slugs = wp_list_pluck( $terms, 'slug' );
					}
					?>
					<div
						class="teams-listing__item team-filter-item"
						data-team-item
						data-team-area="<?php echo esc_attr( implode( ' ', $slugs ) ); ?>"
					>
						<?php get_template_part( 'template-parts/teams/teams', 'card' ); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php wp_reset_postdata(); ?>

			<div class="teams-listing__empty" data-team-empty hidden>
				<p><?php echo esc_html( inlife_t( 'Brak zespołów w wybranej kategorii.' ) ); ?></p>
			</div>

		<?php else : ?>

			<div class="team-empty-state">
				<p><?php echo esc_html( inlife_t( 'Lista zespołów zostanie uzupełniona wkrótce.' ) ); ?></p>
			</div>

		<?php endif; ?>
	</div>
</section>