<?php
/**
 * Career diversity section
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$post_id = get_the_ID();

if (!function_exists('inlife_get_acf_field')) {
	function inlife_get_acf_field($field_name, $post_id = 0, $default = null) {
		if (function_exists('get_field')) {
			$value = get_field($field_name, $post_id);

			if ($value !== null && $value !== '') {
				return $value;
			}
		}

		return $default;
	}
}

$section_kicker = inlife_get_acf_field(
	'career_diversity_kicker',
	$post_id,
	'Różnorodność'
);

$section_title = inlife_get_acf_field(
	'career_diversity_title',
	$post_id,
	'Deklaracja poszanowania różnorodności'
);

$section_text = inlife_get_acf_field(
	'career_diversity_text',
	$post_id,
	'Tworzymy środowisko pracy i rozwoju, w którym szacunek, równe traktowanie i otwartość są podstawą współpracy. Wierzymy, że różnorodność doświadczeń, perspektyw i kompetencji wzmacnia jakość pracy zespołowej oraz wspiera rozwój całej organizacji.'
);

$points = [
	[
		'title' => 'Szacunek',
		'text'  => 'Dbamy o kulturę pracy opartą na wzajemnym szacunku i odpowiedzialnej komunikacji.',
	],
	[
		'title' => 'Równe traktowanie',
		'text'  => 'Wspieramy przejrzyste zasady współpracy, rozwoju i uczestnictwa w życiu organizacji.',
	],
	[
		'title' => 'Otwartość',
		'text'  => 'Tworzymy przestrzeń dla różnych doświadczeń, ścieżek rozwoju i perspektyw.',
	],
];

if (function_exists('have_rows') && have_rows('career_diversity_points', $post_id)) {
	$points = [];

	while (have_rows('career_diversity_points', $post_id)) {
		the_row();

		$points[] = [
			'title' => get_sub_field('title') ?: '',
			'text'  => get_sub_field('text') ?: '',
		];
	}
}
?>

<div class="career-diversity">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-diversity-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>
		</div>
	</div>

	<div class="career-diversity__layout">
		<div class="career-diversity__content">
			<?php if (!empty($section_text)) : ?>
				<p class="career-diversity__text">
					<?php echo esc_html($section_text); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="career-diversity__aside">
			<?php if (!empty($points)) : ?>
				<div class="career-diversity__points">
					<?php foreach ($points as $point) : ?>
						<article class="career-diversity__point">
							<h3 class="career-diversity__point-title">
								<?php echo esc_html($point['title']); ?>
							</h3>

							<?php if (!empty($point['text'])) : ?>
								<p class="career-diversity__point-text">
									<?php echo esc_html($point['text']); ?>
								</p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>