<?php
defined('ABSPATH') || exit;

$current_id = get_the_ID();
$parent_id  = wp_get_post_parent_id($current_id);
$hub_id     = $parent_id ? $parent_id : $current_id;

$projects_archive_url = get_post_type_archive_link('projects');
?>

<nav class="project-breadcrumbs" aria-label="<?php echo esc_attr(inlife_t('Okruszki')); ?>">
	<ol class="project-breadcrumbs__list">
		<li class="project-breadcrumbs__item">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo esc_html(inlife_t('Strona główna')); ?>
			</a>
		</li>

		<?php if ($projects_archive_url) : ?>
			<li class="project-breadcrumbs__item">
				<a href="<?php echo esc_url($projects_archive_url); ?>">
					<?php echo esc_html(inlife_t('Projekty')); ?>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($hub_id && (int) $hub_id !== (int) $current_id) : ?>
			<li class="project-breadcrumbs__item">
				<a href="<?php echo esc_url(get_permalink($hub_id)); ?>">
					<?php echo esc_html(get_the_title($hub_id)); ?>
				</a>
			</li>
		<?php endif; ?>

		<li class="project-breadcrumbs__item" aria-current="page">
			<span><?php echo esc_html(get_the_title($current_id)); ?></span>
		</li>
	</ol>
</nav>