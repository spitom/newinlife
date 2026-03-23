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

$type_key = '';
$terms = get_the_terms($post_id, 'career_entry_type');

if (!empty($terms) && !is_wp_error($terms) && function_exists('inlife_get_career_type_key_from_slug')) {
	$type_key = inlife_get_career_type_key_from_slug($terms[0]->slug);
}

$back_url = function_exists('inlife_get_career_opportunities_url')
	? inlife_get_career_opportunities_url()
	: home_url('/');

if ($type_key && function_exists('inlife_get_career_term_archive_url')) {
	$back_url = inlife_get_career_term_archive_url($type_key);
}
?>

<div class="career-entry-header">
	<p class="career-entry-header__back">
		<a href="<?php echo esc_url($back_url); ?>" class="career-entry-header__back-link">
			<?php echo function_exists('pll__') ? esc_html(pll__('Wróć do ofert')) : 'Wróć do ofert'; ?>
		</a>
	</p>

	<?php if ($type_label) : ?>
		<p class="career-entry-header__kicker section-kicker">
			<?php echo esc_html($type_label); ?>
		</p>
	<?php endif; ?>

	<h1 class="career-entry-header__title section-title">
		<?php echo esc_html(get_the_title($post_id)); ?>
	</h1>

	<?php if ($position_label || $deadline) : ?>
		<div class="career-entry-header__meta">
			<?php if ($position_label) : ?>
				<p class="career-entry-header__meta-item">
					<?php echo esc_html($position_label); ?>
				</p>
			<?php endif; ?>

			<?php if ($deadline) : ?>
				<p class="career-entry-header__meta-item career-entry-header__meta-item--deadline">
					<?php echo function_exists('pll__') ? esc_html(pll__('Termin składania')) : 'Termin składania'; ?>:
					<?php echo esc_html($deadline); ?>
				</p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if (has_excerpt()) : ?>
		<p class="career-entry-header__lead section-lead">
			<?php echo esc_html(get_the_excerpt($post_id)); ?>
		</p>
	<?php endif; ?>
</div>