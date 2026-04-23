<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$term      = get_queried_object();

if ( ! $term || empty( $term->term_id ) ) {
	echo '<main id="main-content" class="site-main"><div class="container py-5"><p>Brak termu.</p></div></main>';
	get_footer();
	exit;
}

$term_id = (int) $term->term_id;

$children = get_terms(
	[
		'taxonomy'   => 'project_type',
		'hide_empty' => true,
		'parent'     => $term_id,
		'orderby'    => 'name',
		'order'      => 'ASC',
	]
);

$display_mode = 'cards';
$term_intro   = '';

if ( function_exists( 'get_field' ) ) {
	$acf_display_mode = get_field( 'project_term_display_mode', 'project_type_' . $term_id );
	$acf_term_intro   = get_field( 'project_type_intro', 'project_type_' . $term_id );

	if ( ! empty( $acf_display_mode ) ) {
		$display_mode = $acf_display_mode;
	}

	if ( ! empty( $acf_term_intro ) ) {
		$term_intro = $acf_term_intro;
	}
}

$projects_query = null;

if ( empty( $children ) || is_wp_error( $children ) ) {
	$projects_query = new WP_Query(
		[
			'post_type'      => 'projects',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'tax_query'      => [
				[
					'taxonomy'         => 'project_type',
					'field'            => 'term_id',
					'terms'            => $term_id,
					'include_children' => false,
				],
			],
		]
	);

	if (
		$projects_query->have_posts()
		&& 1 === (int) $projects_query->found_posts
		&& 'list' !== $display_mode
	) {
		$projects_query->the_post();

		$single_project_url = function_exists( 'inlife_get_project_url' )
			? inlife_get_project_url( get_the_ID() )
			: get_permalink();

		wp_reset_postdata();

		if ( ! empty( $single_project_url ) ) {
			wp_safe_redirect( $single_project_url, 302 );
			exit;
		}
	}
}

$hero_lead = '';

if ( ! empty( $term_intro ) ) {
	$hero_lead = $term_intro;
} elseif ( ! empty( $term->description ) ) {
	$hero_lead = wp_strip_all_tags( $term->description );
} else {
	$hero_lead = inlife_t( 'Wybierz odpowiedni obszar lub przejdź do listy projektów przypisanych do tej kategorii.' );
}
?>

<main id="main-content" class="site-main site-main--projects-taxonomy">

	<section class="page-section page-section--projects-taxonomy-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Projekty' ),
				'title'       => single_term_title( '', false ),
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--projects-taxonomy-content" aria-labelledby="projects-taxonomy-heading">
		<div class="<?php echo esc_attr( $container ); ?>">

			<?php if ( ! empty( $children ) && ! is_wp_error( $children ) ) : ?>

				<div class="section-heading">
					<p class="section-kicker">
						<?php echo esc_html( inlife_t( 'Podkategorie' ) ); ?>
					</p>
					<h2 id="projects-taxonomy-heading" class="section-title">
						<?php echo esc_html( inlife_t( 'Wybierz program' ) ); ?>
					</h2>
				</div>

				<div class="row g-4 projects-types-grid">
					<?php foreach ( $children as $child ) : ?>
						<div class="col-12 col-md-6 col-xl-4">
							<a href="<?php echo esc_url( get_term_link( $child ) ); ?>" class="project-type-card">
								<div class="project-type-card__inner">
									<div class="project-type-card__meta">
										<span class="project-type-card__count">
											<?php echo intval( function_exists( 'inlife_get_project_type_total_count' ) ? inlife_get_project_type_total_count( (int) $child->term_id ) : $child->count ); ?>
										</span>
									</div>

									<h3 class="project-type-card__title">
										<?php echo esc_html( $child->name ); ?>
									</h3>

									<span class="project-type-card__link">
										<?php echo esc_html( inlife_t( 'Zobacz projekty' ) ); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

			<?php else : ?>

				<div class="section-heading">
					<p class="section-kicker">
						<?php echo esc_html( inlife_t( 'Projekty' ) ); ?>
					</p>
					<h2 id="projects-taxonomy-heading" class="section-title">
						<?php echo esc_html( inlife_t( 'Lista projektów' ) ); ?>
					</h2>
				</div>

				<?php if ( $projects_query && $projects_query->have_posts() ) : ?>

					<?php if ( 'list' === $display_mode ) : ?>

						<div class="projects-list">
							<?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
								<?php get_template_part( 'template-parts/projects/project', 'list-item' ); ?>
							<?php endwhile; ?>
						</div>

					<?php else : ?>

						<div class="row g-4 projects-grid">
							<?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
								<div class="col-12 col-md-6 col-xl-4">
									<?php get_template_part( 'template-parts/projects/project', 'card' ); ?>
								</div>
							<?php endwhile; ?>
						</div>

					<?php endif; ?>

					<?php wp_reset_postdata(); ?>

				<?php else : ?>

					<div class="projects-empty-state">
						<p><?php echo esc_html( inlife_t( 'Brak projektów w tej kategorii.' ) ); ?></p>
					</div>

				<?php endif; ?>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer();