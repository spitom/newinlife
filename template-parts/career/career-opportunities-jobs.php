<?php
/**
 * Career opportunities - job offers
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$query = new WP_Query([
	'post_type'           => 'career_entry',
	'post_status'         => 'publish',
	'posts_per_page'      => 10,
	'ignore_sticky_posts' => true,
	'tax_query'           => [
		[
			'taxonomy' => 'career_entry_type',
			'field'    => 'slug',
			'terms'    => ['jobs'],
		],
	],
	'meta_query'          => [
		'relation' => 'OR',
		[
			'key'     => 'career_is_archived',
			'compare' => 'NOT EXISTS',
		],
		[
			'key'     => 'career_is_archived',
			'value'   => '0',
			'compare' => '=',
		],
	],
]);
?>

<div class="career-op-section">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker">Rekrutacja</p>
				<h2 id="career-jobs-heading" class="section-title">
					Ogłoszenia o pracę
				</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				Aktualne oferty pracy w obszarach naukowych, technicznych i administracyjnych.
			</p>
		</div>
	</div>

	<?php if ($query->have_posts()) : ?>
		<div class="career-op-list">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php
				$post_id = get_the_ID();

				$position = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_position_label', $post_id, '')
					: '';

				$unit = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_unit', $post_id, '')
					: '';

				$employment = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_employment_type', $post_id, '')
					: '';

				$deadline_raw = function_exists('inlife_get_acf_field')
					? inlife_get_acf_field('career_deadline', $post_id, '')
					: '';

				$deadline = function_exists('inlife_format_career_date')
					? inlife_format_career_date($deadline_raw)
					: '';
				?>

				<article class="career-op-card career-op-card--job">
					<a class="career-op-card__link" href="<?php the_permalink(); ?>">

						<?php if ($position) : ?>
							<p class="career-op-card__label">
								<?php echo esc_html($position); ?>
							</p>
						<?php endif; ?>

						<h3 class="career-op-card__title"><?php the_title(); ?></h3>

						<?php if ($unit || $employment || $deadline) : ?>
							<div class="career-op-card__meta-wrap">

								<?php if ($unit) : ?>
									<p class="career-op-card__meta">
										<?php echo esc_html($unit); ?>
									</p>
								<?php endif; ?>

								<?php if ($employment) : ?>
									<p class="career-op-card__meta">
										<?php echo esc_html($employment); ?>
									</p>
								<?php endif; ?>

								<?php if ($deadline) : ?>
									<p class="career-op-card__meta career-op-card__meta--deadline">
										Aplikuj do: <?php echo esc_html($deadline); ?>
									</p>
								<?php endif; ?>

							</div>
						<?php endif; ?>

						<span class="career-op-card__cta">Zobacz ofertę</span>
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>
		<div class="career-op-empty">
			<p class="career-op-empty__text">
				Obecnie brak aktywnych ofert pracy.
			</p>
		</div>
	<?php endif; ?>
</div>