<?php
defined('ABSPATH') || exit;

$type_label = function_exists('inlife_get_career_entry_type_label')
	? inlife_get_career_entry_type_label(get_the_ID())
	: '';

$type_key = '';
$type_url = '';

$terms = get_the_terms(get_the_ID(), 'career_entry_type');

if (!empty($terms) && !is_wp_error($terms) && function_exists('inlife_get_career_type_key_from_slug')) {
	$type_key = inlife_get_career_type_key_from_slug($terms[0]->slug);
}

if ($type_key && function_exists('inlife_get_career_term_archive_url')) {
	$type_url = inlife_get_career_term_archive_url($type_key);
}

$career_page_url = function_exists('inlife_get_career_landing_url')
	? inlife_get_career_landing_url()
	: home_url('/');

$opportunities_url = function_exists('inlife_get_career_opportunities_url')
	? inlife_get_career_opportunities_url()
	: home_url('/');
?>

<nav class="career-breadcrumbs" aria-label="Okruszki">
	<ol class="career-breadcrumbs__list">
		<li class="career-breadcrumbs__item">
			<a href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo function_exists('pll__') ? esc_html(pll__('Strona główna')) : 'Strona główna'; ?>
			</a>
		</li>

		<li class="career-breadcrumbs__item">
			<a href="<?php echo esc_url($career_page_url); ?>">
				<?php echo function_exists('pll__') ? esc_html(pll__('Kariera')) : 'Kariera'; ?>
			</a>
		</li>

		<li class="career-breadcrumbs__item">
			<a href="<?php echo esc_url($opportunities_url); ?>">
				<?php echo function_exists('pll__') ? esc_html(pll__('Oferty i konkursy')) : 'Oferty i konkursy'; ?>
			</a>
		</li>

		<?php if ($type_label && $type_url) : ?>
			<li class="career-breadcrumbs__item">
				<a href="<?php echo esc_url($type_url); ?>">
					<?php echo esc_html($type_label); ?>
				</a>
			</li>
		<?php endif; ?>

		<li class="career-breadcrumbs__item" aria-current="page">
			<?php the_title(); ?>
		</li>
	</ol>
</nav>