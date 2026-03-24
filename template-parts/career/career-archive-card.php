<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();

$type_label = function_exists('inlife_get_career_entry_type_label')
	? inlife_get_career_entry_type_label($post_id)
	: '';

$unit = function_exists('inlife_get_acf_field')
	? inlife_get_acf_field('career_unit', $post_id, '')
	: '';

$deadline_raw = function_exists('inlife_get_acf_field')
	? inlife_get_acf_field('career_deadline', $post_id, '')
	: '';

$deadline = function_exists('inlife_format_career_date')
	? inlife_format_career_date($deadline_raw)
	: '';
?>

<article class="career-archive-card">
	<a class="career-archive-card__link" href="<?php the_permalink(); ?>">

		<?php if ($type_label) : ?>
			<p class="career-archive-card__type">
				<?php echo esc_html($type_label); ?>
			</p>
		<?php endif; ?>

		<h2 class="career-archive-card__title">
			<?php the_title(); ?>
		</h2>

		<?php if (has_excerpt()) : ?>
			<p class="career-archive-card__excerpt">
				<?php echo esc_html(get_the_excerpt()); ?>
			</p>
		<?php endif; ?>

		<?php if ($unit || $deadline) : ?>
			<div class="career-archive-card__meta">
				<?php if ($unit) : ?>
					<p class="career-archive-card__meta-item">
						<?php echo esc_html($unit); ?>
					</p>
				<?php endif; ?>

				<?php if ($deadline) : ?>
					<p class="career-archive-card__meta-item career-archive-card__meta-item--deadline">
						<?php echo function_exists('pll__') ? esc_html(pll__('Termin składania')) : 'Termin składania'; ?>:
						<?php echo esc_html($deadline); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<span class="career-archive-card__cta">
			<?php echo function_exists('pll__') ? esc_html(pll__('Przejdź do wpisu')) : 'Przejdź do wpisu'; ?>
		</span>
	</a>
</article>