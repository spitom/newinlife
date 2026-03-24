<?php
$areas = [
	'zywnosc'   => 'Żywność',
	'zwierzeta' => 'Zwierzęta',
	'zdrowie'   => 'Zdrowie',
];
?>

<section id="all" class="teams-sections section">
	<div class="container">

		<?php foreach ( $areas as $slug => $label ) : ?>

			<?php
			$query = new WP_Query([
				'post_type'      => 'teams',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'tax_query'      => [
					[
						'taxonomy' => 'team_area',
						'field'    => 'slug',
						'terms'    => $slug,
					],
				],
			]);

			if ( $query->have_posts() ) :
				?>

				<?php
				get_template_part(
					'template-parts/teams/teams-archive',
					'section',
					[
						'label' => $label,
						'slug'  => $slug,
						'query' => $query,
					]
				);
				?>

			<?php
			endif;
			wp_reset_postdata();
			?>

		<?php endforeach; ?>

	</div>
</section>