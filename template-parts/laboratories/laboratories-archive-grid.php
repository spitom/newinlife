<?php
/**
 * Laboratories archive grid.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$query_args = array(
	'post_type'           => 'laboratories',
	'post_status'         => 'publish',
	'posts_per_page'      => -1,
	'orderby'             => 'rand',
	'ignore_sticky_posts' => true,
	'suppress_filters'    => false,
);

if ( function_exists( 'pll_current_language' ) ) {
	$current_language = (string) pll_current_language( 'slug' );

	if ( '' !== $current_language ) {
		$query_args['lang'] = $current_language;
	}
}

$laboratories_query = new WP_Query( $query_args );
?>

<section class="laboratories-grid section">
	<div class="<?php echo esc_attr( inlife_container_class() ); ?>">

		<?php if ( $laboratories_query->have_posts() ) : ?>
			<div class="laboratories-grid__listing c-card-grid c-card-grid--3">

				<?php while ( $laboratories_query->have_posts() ) : ?>
					<?php $laboratories_query->the_post(); ?>

					<div class="laboratories-grid__item">
						<?php get_template_part( 'template-parts/laboratories/laboratories', 'card' ); ?>
					</div>
				<?php endwhile; ?>

			</div>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<div class="team-empty-state">
				<p><?php echo esc_html( inlife_t( 'Lista laboratoriów zostanie uzupełniona wkrótce.' ) ); ?></p>
			</div>
		<?php endif; ?>

	</div>
</section>