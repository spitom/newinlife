<?php
/**
 * Career opportunities – Archive
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$archive_url = function_exists('inlife_get_career_term_archive_url')
	? inlife_get_career_term_archive_url('archive')
	: home_url('/komunikaty/');

$term_slug = function_exists('inlife_get_career_type_slug')
	? inlife_get_career_type_slug('archive')
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
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => inlife_t( 'Komunikaty' ),
			'title'    => inlife_t( 'Archiwum' ),
			'lead'     => inlife_t( 'Wcześniejsze ogłoszenia i komunikaty zachowane do celów informacyjnych.' ),
			'title_id' => 'career-results-heading',
		]
	);
	?>

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
				<?php echo function_exists('pll__') ? esc_html(pll__('Brak wpisów archiwalnych.')) : 'Brak wpisów archiwalnych.'; ?>
			</p>
		</div>
	<?php endif; ?>
</div>