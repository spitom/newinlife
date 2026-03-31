<?php
defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();

$terms = get_terms([
	'taxonomy'   => 'project_type',
	'hide_empty' => true,
	'parent'     => 0,
	'orderby'    => 'name',
	'order'      => 'ASC',
]);
?>

<main id="main-content" class="site-main site-main--projects-archive">

	<?php get_template_part('template-parts/page/page', 'hero-inner'); ?>

	<section class="page-section page-section--projects-intro">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="projects-intro">
				<div class="row">
					<div class="col-xl-10">
						<p class="projects-intro__lead">
							<?php echo esc_html(inlife_t('Projekty badawcze realizowane w Instytucie obejmują szeroki zakres działań finansowanych ze źródeł krajowych i międzynarodowych.')); ?>
						</p>

						<p class="projects-intro__text">
							<?php echo esc_html(inlife_t('Wybierz obszar finansowania, aby przejść do listy projektów i szczegółowych informacji.')); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="page-section page-section--projects-types" aria-labelledby="projects-types-heading">
		<div class="<?php echo esc_attr($container); ?>">

			<div class="section-heading">
				<p class="section-kicker">
					<?php echo esc_html(inlife_t('Źródła finansowania')); ?>
				</p>
				<h2 id="projects-types-heading" class="section-title">
					<?php echo esc_html(inlife_t('Wybierz typ projektu')); ?>
				</h2>
			</div>

			<div class="row g-4 projects-types-grid">

				<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
					<?php foreach ($terms as $term) : ?>
						<div class="col-12 col-md-6 col-xl-4">
							<a href="<?php echo esc_url(get_term_link($term)); ?>" class="project-type-card">
								<div class="project-type-card__inner">
									<div class="project-type-card__meta">
										<span class="project-type-card__count">
											<?php echo intval(function_exists('inlife_get_project_type_total_count') ? inlife_get_project_type_total_count((int) $term->term_id) : $term->count); ?>
										</span>
									</div>

									<h3 class="project-type-card__title">
										<?php echo esc_html($term->name); ?>
									</h3>

									<span class="project-type-card__link">
										<?php echo esc_html(inlife_t('Zobacz projekty')); ?>
									</span>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="col-12">
						<div class="projects-empty-state">
							<p><?php echo esc_html(inlife_t('Brak typów projektów.')); ?></p>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();