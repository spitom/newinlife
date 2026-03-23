<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();

$type_label = function_exists('inlife_get_career_entry_type_label')
	? inlife_get_career_entry_type_label($post_id)
	: '';

$position_label = function_exists('inlife_get_acf_field')
	? inlife_get_acf_field('career_position_label', $post_id, '')
	: '';

$deadline_raw = function_exists('inlife_get_acf_field')
	? inlife_get_acf_field('career_deadline', $post_id, '')
	: '';

$deadline = function_exists('inlife_format_career_date')
	? inlife_format_career_date($deadline_raw)
	: '';
?>

<div class="career-entry-header">
	<?php if ($type_label) : ?>
		<p class="career-entry-header__kicker section-kicker">
			<?php echo esc_html($type_label); ?>
		</p>
	<?php endif; ?>

	<h1 class="career-entry-header__title section-title"><?php the_title(); ?></h1>

	<?php if ($position_label || $deadline) : ?>
		<div class="career-entry-header__meta">
			<?php if ($position_label) : ?>
				<p class="career-entry-header__meta-item">
					<?php echo esc_html($position_label); ?>
				</p>
			<?php endif; ?>

			<?php if ($deadline) : ?>
				<p class="career-entry-header__meta-item career-entry-header__meta-item--deadline">
					Termin składania: <?php echo esc_html($deadline); ?>
				</p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if (has_excerpt()) : ?>
		<p class="career-entry-header__lead section-lead">
			<?php echo esc_html(get_the_excerpt()); ?>
		</p>
	<?php endif; ?>
</div>