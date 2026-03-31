<?php
defined('ABSPATH') || exit;

$current_id = get_the_ID();
$parent_id  = wp_get_post_parent_id($current_id);
$hub_id     = $parent_id ? $parent_id : $current_id;

$hub_children = get_pages([
	'child_of'    => $hub_id,
	'parent'      => $hub_id,
	'sort_column' => 'menu_order,post_title',
	'sort_order'  => 'ASC',
]);

$hub_title = get_the_title($hub_id);
$hub_url   = get_permalink($hub_id);
?>

<nav class="project-hub-nav" aria-label="<?php echo esc_attr(inlife_t('Menu projektu')); ?>">
	<div class="project-hub-nav__inner">
		<p class="project-hub-nav__eyebrow">
			<?php echo esc_html(inlife_t('Projekt')); ?>
		</p>

		<h2 class="project-hub-nav__title">
			<a href="<?php echo esc_url($hub_url); ?>">
				<?php echo esc_html($hub_title); ?>
			</a>
		</h2>

		<?php if (!empty($hub_children)) : ?>
			<ul class="project-hub-nav__list">
				<?php foreach ($hub_children as $child) : ?>
					<li class="project-hub-nav__item">
						<a
							class="project-hub-nav__link <?php echo ((int) $child->ID === (int) $current_id) ? 'is-active' : ''; ?>"
							href="<?php echo esc_url(get_permalink($child->ID)); ?>"
							<?php echo ((int) $child->ID === (int) $current_id) ? 'aria-current="page"' : ''; ?>
						>
							<?php echo esc_html(get_the_title($child->ID)); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</nav>