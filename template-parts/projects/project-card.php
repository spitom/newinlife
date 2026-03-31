<?php
defined('ABSPATH') || exit;

$post_id      = get_the_ID();
$project_url  = function_exists('inlife_get_project_url') ? inlife_get_project_url($post_id) : get_permalink($post_id);
$project_lead = function_exists('get_field') ? get_field('project_lead', $post_id) : '';
$project_logo = function_exists('get_field') ? get_field('project_logo', $post_id) : '';
$is_external  = function_exists('inlife_is_project_external') ? inlife_is_project_external($post_id) : false;
$link_target  = $is_external ? ' target="_blank" rel="noopener noreferrer"' : '';
?>

<article class="project-card h-100">
	<div class="project-card__inner">

		<div class="project-card__media">
			<?php if (!empty($project_logo) && is_array($project_logo)) : ?>
				<a class="project-card__media-link" href="<?php echo esc_url($project_url); ?>"<?php echo $link_target; ?>>
					<img
						class="project-card__image"
						src="<?php echo esc_url($project_logo['sizes']['medium'] ?? $project_logo['url']); ?>"
						alt="<?php echo esc_attr($project_logo['alt'] ?? get_the_title()); ?>"
					>
				</a>
			<?php else : ?>
				<div class="project-card__placeholder" aria-hidden="true">
					<span><?php echo esc_html(inlife_t('Logo projektu')); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<div class="project-card__body">
			<h3 class="project-card__title">
				<a class="project-card__title-link" href="<?php echo esc_url($project_url); ?>"<?php echo $link_target; ?>>
					<?php the_title(); ?>
				</a>
			</h3>

			<?php if (!empty($project_lead)) : ?>
				<p class="project-card__lead">
					<?php echo esc_html($project_lead); ?>
				</p>
			<?php endif; ?>

			<a class="project-card__link" href="<?php echo esc_url($project_url); ?>"<?php echo $link_target; ?>>
				<?php echo esc_html(inlife_t('Przejdź do projektu')); ?>
			</a>
		</div>

	</div>
</article>