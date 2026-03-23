<?php
/**
 * Career opportunities - results
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$query = new WP_Query([
	'post_type'           => 'career_entry',
	'post_status'         => 'publish',
	'posts_per_page'      => 20,
	'ignore_sticky_posts' => true,
	'tax_query'           => [
		[
			'taxonomy' => 'career_entry_type',
			'field'    => 'slug',
			'terms'    => ['results'],
		],
	],
	'orderby'             => 'date',
	'order'               => 'DESC',
]);
?>

<div class="career-op-section">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker">Informacje</p>
				<h2 id="career-results-heading" class="section-title">Wyniki konkursów</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				Zestawienie wyników zakończonych postępowań i rozstrzygnięć konkursowych.
			</p>
		</div>
	</div>

	<?php if ($query->have_posts()) : ?>
		<div class="career-op-list">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php
				$post_id = get_the_ID();

				$result_date_raw = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_publish_result_date', $post_id, '')
					: '';

				$result_date = function_exists('inlife_format_career_date')
					? inlife_format_career_date($result_date_raw)
					: '';

				$unit = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_unit', $post_id, '')
					: '';

				$position = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_position_label', $post_id, '')
					: '';
				?>

				<article class="career-op-card career-op-card--result">
					<a class="career-op-card__link" href="<?php the_permalink(); ?>">

						<?php if ($position) : ?>
							<p class="career-op-card__label career-op-card__label--result">
								<?php echo esc_html($position); ?>
							</p>
						<?php endif; ?>

						<h3 class="career-op-card__title"><?php the_title(); ?></h3>

						<div class="career-op-card__meta-wrap">
							<?php if ($unit) : ?>
								<p class="career-op-card__meta">
									<?php echo esc_html($unit); ?>
								</p>
							<?php endif; ?>

							<?php if ($result_date) : ?>
								<p class="career-op-card__meta career-op-card__meta--result-date">
									Data publikacji wyniku: <?php echo esc_html($result_date); ?>
								</p>
							<?php endif; ?>
						</div>

						<span class="career-op-card__cta">Zobacz wynik</span>
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="career-op-empty">
			<p class="career-op-empty__text">
				Obecnie brak opublikowanych wyników konkursów.
			</p>
		</div>
	<?php endif; ?>
</div>