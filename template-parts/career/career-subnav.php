<?php
defined('ABSPATH') || exit;

$career_page_url = function_exists('inlife_get_career_landing_url')
	? inlife_get_career_landing_url()
	: home_url('/');

$opportunities_url = function_exists('inlife_get_career_opportunities_url')
	? inlife_get_career_opportunities_url()
	: home_url('/');

$current_type = '';

if (is_tax('career_entry_type')) {
	$current_term = get_queried_object();

	if ($current_term && !empty($current_term->slug) && function_exists('inlife_get_career_type_key_from_slug')) {
		$current_type = inlife_get_career_type_key_from_slug($current_term->slug);
	}
} elseif (is_singular('career_entry')) {
	$terms = get_the_terms(get_the_ID(), 'career_entry_type');

	if (!empty($terms) && !is_wp_error($terms) && function_exists('inlife_get_career_type_key_from_slug')) {
		$current_type = inlife_get_career_type_key_from_slug($terms[0]->slug);
	}
}
?>

<nav class="career-subnav" aria-label="Nawigacja Kariera">
	<div class="<?php echo esc_attr($args['container'] ?? 'container'); ?>">
		<div class="career-subnav__inner">

			<a
				href="<?php echo esc_url($career_page_url); ?>"
				class="career-subnav__link<?php echo is_page_template('page-templates/template-career-landing.php') ? ' is-active' : ''; ?>"
			>
				<?php echo function_exists('pll__') ? esc_html(pll__('Kariera')) : 'Kariera'; ?>
			</a>

			<a
				href="<?php echo esc_url($opportunities_url); ?>"
				class="career-subnav__link<?php echo (is_page_template('page-templates/template-career-opportunities.php') && empty($current_type)) ? ' is-active' : ''; ?>"
			>
				<?php echo function_exists('pll__') ? esc_html(pll__('Oferty i konkursy')) : 'Oferty i konkursy'; ?>
			</a>

			<?php foreach (array_keys(inlife_get_career_types_map()) as $type_key) : ?>
				<a
					href="<?php echo esc_url(inlife_get_career_term_archive_url($type_key)); ?>"
					class="career-subnav__link<?php echo $current_type === $type_key ? ' is-active' : ''; ?>"
				>
					<?php echo esc_html(inlife_get_career_type_label($type_key)); ?>
				</a>
			<?php endforeach; ?>

		</div>
	</div>
</nav>