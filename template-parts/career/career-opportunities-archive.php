<?php
/**
 * Career opportunities - archive
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$query = new WP_Query([
	'post_type'           => 'career_entry',
	'post_status'         => 'publish',
	'posts_per_page'      => 20,
	'ignore_sticky_posts' => true,
	'meta_query'          => [
		[
			'key'     => 'career_is_archived',
			'value'   => '1',
			'compare' => '=',
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
				<p class="section-kicker">Archiwum</p>
				<h2 id="career-archive-heading" class="section-title">Ogłoszenia archiwalne</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				Wcześniejsze ogłoszenia, konkursy i wpisy rekrutacyjne przechowywane do celów informacyjnych.
			</p>
		</div>
	</div>

	<?php if ($query->have_posts()) : ?>
		<div class="career-op-list">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php
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

				<article class="career-op-card career-op-card--archive">
					<a class="career-op-card__link" href="<?php the_permalink(); ?>">

						<?php if ($type_label) : ?>
							<p class="career-op-card__label career-op-card__label--archive">
								<?php echo esc_html($type_label); ?>
							</p>
						<?php endif; ?>

						<h3 class="career-op-card__title"><?php the_title(); ?></h3>

						<div class="career-op-card__meta-wrap">
							<?php if ($unit) : ?>
								<p class="career-op-card__meta">
									<?php echo esc_html($unit); ?>
								</p>
							<?php endif; ?>

							<?php if ($deadline) : ?>
								<p class="career-op-card__meta career-op-card__meta--archive-date">
									Termin składania: <?php echo esc_html($deadline); ?>
								</p>
							<?php endif; ?>
						</div>

						<span class="career-op-card__cta">Zobacz archiwum</span>
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="career-op-empty">
			<p class="career-op-empty__text">
				Obecnie brak wpisów archiwalnych.
			</p>
		</div>
	<?php endif; ?>
</div>