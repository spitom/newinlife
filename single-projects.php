<?php
defined('ABSPATH') || exit;

get_header();

$container  = inlife_container_class();
$post_id    = get_the_ID();

$lead       = function_exists('get_field') ? get_field('project_lead', $post_id) : '';
$logo       = function_exists('get_field') ? get_field('project_logo', $post_id) : '';
$start_date = function_exists('get_field') ? get_field('project_start_date', $post_id) : '';
$end_date   = function_exists('get_field') ? get_field('project_end_date', $post_id) : '';
$funding    = function_exists('get_field') ? get_field('project_funding_source', $post_id) : '';
$partners   = function_exists('get_field') ? get_field('project_partners', $post_id) : '';
$gallery    = function_exists('get_field') ? get_field('project_gallery', $post_id) : [];
$documents  = function_exists('get_field') ? get_field('project_documents', $post_id) : [];
?>

<main id="main-content" class="site-main site-main--project-single">

	<?php get_template_part('template-parts/page/page', 'hero-inner'); ?>

	<section class="page-section page-section--project-intro">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="project-single-intro">

				<?php if (!empty($logo) && is_array($logo)) : ?>
					<div class="project-single-intro__logo">
						<img
							src="<?php echo esc_url($logo['sizes']['medium'] ?? $logo['url']); ?>"
							alt="<?php echo esc_attr($logo['alt'] ?? get_the_title()); ?>"
						>
					</div>
				<?php endif; ?>

				<?php if ($lead) : ?>
					<p class="project-single-intro__lead">
						<?php echo esc_html($lead); ?>
					</p>
				<?php endif; ?>

				<div class="project-single-meta">
					<?php if ($start_date || $end_date) : ?>
						<div class="project-single-meta__item">
							<strong><?php echo esc_html(inlife_t('Okres realizacji')); ?>:</strong>
							<span>
								<?php echo esc_html($start_date); ?>
								<?php if ($end_date) : ?>
									– <?php echo esc_html($end_date); ?>
								<?php endif; ?>
							</span>
						</div>
					<?php endif; ?>

					<?php if ($funding) : ?>
						<div class="project-single-meta__item">
							<strong><?php echo esc_html(inlife_t('Finansowanie')); ?>:</strong>
							<span><?php echo esc_html($funding); ?></span>
						</div>
					<?php endif; ?>

					<?php if ($partners) : ?>
						<div class="project-single-meta__item">
							<strong><?php echo esc_html(inlife_t('Partnerzy')); ?>:</strong>
							<span><?php echo wp_kses_post($partners); ?></span>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</section>

	<section class="page-section page-section--project-content">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="project-single-content">
				<?php
				while (have_posts()) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
	</section>

	<?php if (!empty($gallery)) : ?>
		<section class="page-section page-section--project-gallery">
			<div class="<?php echo esc_attr($container); ?>">
				<div class="row g-4">
					<?php foreach ($gallery as $image) : ?>
						<div class="col-6 col-md-4 col-xl-3">
							<img
								src="<?php echo esc_url($image['sizes']['medium'] ?? $image['url']); ?>"
								alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
							>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if (!empty($documents)) : ?>
		<section class="page-section page-section--project-documents">
			<div class="<?php echo esc_attr($container); ?>">
				<h2 class="section-title">
					<?php echo esc_html(inlife_t('Dokumenty')); ?>
				</h2>

				<ul class="project-documents">
					<?php foreach ($documents as $doc) : ?>
						<?php if (!empty($doc['document_file']['url'])) : ?>
							<li>
								<a href="<?php echo esc_url($doc['document_file']['url']); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html($doc['document_title'] ?: inlife_t('Pobierz dokument')); ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();