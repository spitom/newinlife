<?php
/**
 * Career opportunities – Jobs
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$archive_url = function_exists('inlife_get_career_term_archive_url')
	? inlife_get_career_term_archive_url('jobs')
	: home_url('/komunikaty/');

$term_slug = function_exists('inlife_get_career_type_slug')
	? inlife_get_career_type_slug('jobs')
	: '';

$args = [
	'post_type'      => 'career_entry',
	'posts_per_page' => 4,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
];

if (!empty($term_slug)) {
	$args['tax_query'] = [
		[
			'taxonomy' => 'career_entry_type',
			'field'    => 'slug',
			'terms'    => [$term_slug],
		],
	];
}

$query = new WP_Query($args);
?>

<div class="career-op-section">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker">
					<?php echo function_exists('pll__') ? esc_html(pll__('Komunikaty')) : 'Komunikaty'; ?>
				</p>
				<h2 id="career-jobs-heading" class="section-title">
					<?php echo esc_html(inlife_get_career_type_label('jobs')); ?>
				</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				<?php echo function_exists('pll__')
					? esc_html(pll__('Aktualne ogłoszenia o pracę i naborach prowadzonych przez Instytut.'))
					: 'Aktualne ogłoszenia o pracę i naborach prowadzonych przez Instytut.'; ?>
			</p>
		</div>

		<div class="col-lg-4 text-lg-end">
			<a href="<?php echo esc_url($archive_url); ?>" class="btn btn-outline-primary">
				<?php echo function_exists('pll__') ? esc_html(pll__('Zobacz wszystkie')) : 'Zobacz wszystkie'; ?>
			</a>
		</div>
	</div>

	<?php if ($query->have_posts()) : ?>
		<div class="career-archive-list mt-4">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php get_template_part('template-parts/career/career-archive', 'card'); ?>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="career-op-empty mt-4">
			<p class="career-op-empty__text">
				<?php echo function_exists('pll__') ? esc_html(pll__('Brak aktualnych ogłoszeń.')) : 'Brak aktualnych ogłoszeń.'; ?>
			</p>
		</div>
	<?php endif; ?>
</div>