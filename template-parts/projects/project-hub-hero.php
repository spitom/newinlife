<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();
$lead    = has_excerpt($post_id) ? get_the_excerpt($post_id) : '';
$logo    = function_exists('get_field') ? get_field('project_hub_logo', $post_id) : '';

if (function_exists('get_field')) {
	$acf_lead = get_field('project_hub_lead', $post_id);
	if (!empty($acf_lead)) {
		$lead = $acf_lead;
	}
}
?>

<section class="project-hub-hero" aria-labelledby="project-hub-heading">
	<div class="container-xxl">
		<div class="project-hub-hero__inner">

			<?php get_template_part('template-parts/projects/project-hub', 'breadcrumbs'); ?>

			<p class="project-hub-hero__eyebrow">
				<?php echo esc_html(inlife_t('Projekt')); ?>
			</p>

			<div class="row g-4 align-items-center project-hub-hero__row">
				<div class="col-lg-8">
					<div class="project-hub-hero__content">
						<h1 id="project-hub-heading" class="project-hub-hero__title">
							<?php the_title(); ?>
						</h1>

						<?php if (!empty($lead)) : ?>
							<p class="project-hub-hero__lead">
								<?php echo esc_html($lead); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if (!empty($logo) && is_array($logo)) : ?>
					<div class="col-lg-4">
						<div class="project-hub-hero__logo">
							<img
								src="<?php echo esc_url($logo['sizes']['medium_large'] ?? $logo['url']); ?>"
								alt="<?php echo esc_attr($logo['alt'] ?? get_the_title($post_id)); ?>"
							>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>