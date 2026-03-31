<?php
defined('ABSPATH') || exit;

$post_id      = get_the_ID();
$project_url  = function_exists('inlife_get_project_url') ? inlife_get_project_url($post_id) : get_permalink($post_id);
$project_lead = function_exists('get_field') ? get_field('project_lead', $post_id) : '';
$is_external  = function_exists('inlife_is_project_external') ? inlife_is_project_external($post_id) : false;
$link_target  = $is_external ? ' target="_blank" rel="noopener noreferrer"' : '';
?>

<article class="project-list-item">
	<div class="project-list-item__inner">

		<h3 class="project-list-item__title">
			<a href="<?php echo esc_url($project_url); ?>"<?php echo $link_target; ?>>
				<?php the_title(); ?>
			</a>
		</h3>

		<?php if (!empty($project_lead)) : ?>
			<p class="project-list-item__lead">
				<?php echo esc_html($project_lead); ?>
			</p>
		<?php endif; ?>

		<a class="project-list-item__link" href="<?php echo esc_url($project_url); ?>"<?php echo $link_target; ?>>
			<?php echo esc_html(inlife_t('Przejdź do projektu')); ?>
		</a>

	</div>
</article>