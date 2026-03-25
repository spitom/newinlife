<?php
/**
 * Teams archive grouped sections.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$area_order = array( 'zywnosc', 'zwierzeta', 'zdrowie' );
?>

<section id="all" class="teams-sections section">
	<div class="container">

		<?php foreach ( $area_order as $slug ) : ?>

			<?php
			$term = get_term_by( 'slug', $slug, 'team_area' );

			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}

			$query = new WP_Query(
				array(
					'post_type'      => 'teams',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'team_area',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						),
					),
				)
			);

			if ( ! $query->have_posts() ) {
				wp_reset_postdata();
				continue;
			}
			?>

			<section id="<?php echo esc_attr( $term->slug ); ?>" class="teams-section">
				<header class="teams-section__header">
					<h2 class="teams-section__title">
						<?php echo esc_html( $term->name ); ?>
					</h2>
				</header>
				<div class="row g-4">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<div class="col-md-6 col-xl-4">
							<?php get_template_part( 'template-parts/teams/teams', 'card' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</section>

			<?php wp_reset_postdata(); ?>

		<?php endforeach; ?>

	</div>
</section>