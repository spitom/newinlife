<?php
$label = $args['label'] ?? '';
$slug  = $args['slug'] ?? '';
$query = $args['query'] ?? null;

if ( ! $query ) {
	return;
}
?>

<section id="<?php echo esc_attr( $slug ); ?>" class="teams-section">

	<header class="teams-section__header">
		<h2 class="teams-section__title">
			<?php echo esc_html( $label ); ?>
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