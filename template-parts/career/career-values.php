<?php
/**
 * Career values
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
	'career_values_kicker',
	$post_id,
	'Wartości'
);

$section_title = inlife_get_acf_field(
	'career_values_title',
	$post_id,
	'Nasze wartości i kultura pracy'
);

$section_text = inlife_get_acf_field(
	'career_values_text',
	$post_id,
	'Tworzymy środowisko pracy oparte na współpracy, odpowiedzialności i rozwoju. Łączymy wysokie standardy naukowe z codzienną kulturą organizacyjną, w której liczą się relacje, wzajemny szacunek i realne możliwości wzrostu.'
);

$video_url = inlife_get_acf_field(
	'career_values_video_url',
	$post_id,
	''
);

$highlights = [
	[
		'title' => 'Współpraca',
		'text'  => 'Budujemy zespoły, w których wiedza i doświadczenie są wymieniane między obszarami i pokoleniami.',
	],
	[
		'title' => 'Rozwój',
		'text'  => 'Wspieramy rozwój kompetencji, ścieżki naukowe, zawodowe i wejście w nowe role.',
	],
	[
		'title' => 'Odpowiedzialność',
		'text'  => 'Dbamy o jakość pracy, etykę działania i szacunek wobec ludzi, partnerów oraz otoczenia.',
	],
];

if (function_exists('have_rows') && have_rows('career_values_highlights', $post_id)) {
	$highlights = [];

	while (have_rows('career_values_highlights', $post_id)) {
		the_row();

		$item_title = get_sub_field('title');
		$item_text  = get_sub_field('text');

		$highlights[] = [
			'title' => $item_title ?: '',
			'text'  => $item_text ?: '',
		];
	}
}
?>

<div class="career-values">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-values-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>

			<?php if (!empty($section_text)) : ?>
				<p class="section-lead mt-3 mb-0">
					<?php echo esc_html($section_text); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>

	<div class="career-values__layout">
		<div class="career-values__content">
			<?php if (!empty($highlights)) : ?>
				<div class="career-values__highlights">
					<?php foreach ($highlights as $item) : ?>
						<article class="career-values__item">
							<h3 class="career-values__item-title">
								<?php echo esc_html($item['title']); ?>
							</h3>

							<?php if (!empty($item['text'])) : ?>
								<p class="career-values__item-text">
									<?php echo esc_html($item['text']); ?>
								</p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="career-values__media">
			<?php if (!empty($video_url)) : ?>
				<div class="career-values__video">
					<div class="ratio ratio-16x9">
						<iframe
							src="<?php echo esc_url($video_url); ?>"
							title="<?php echo esc_attr($section_title); ?>"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen
						></iframe>
					</div>
				</div>
			<?php else : ?>
				<div class="career-values__video-placeholder" aria-hidden="true">
					<div class="career-values__video-badge">Wideo / kultura organizacyjna</div>

					<div class="career-values__video-card">
						<span class="career-values__video-card-label">Przestrzeń do rozwoju</span>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>