<?php
/**
 * Career onboarding
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
	'career_onboarding_kicker',
	$post_id,
	'Start'
);

$section_title = inlife_get_acf_field(
	'career_onboarding_title',
	$post_id,
	'Onboarding i przydatne wejścia'
);

$section_text = inlife_get_acf_field(
	'career_onboarding_text',
	$post_id,
	'Zebraliśmy najważniejsze ścieżki wejścia i zasoby dla osób rozpoczynających pracę, współpracę lub kształcenie w Instytucie.'
);

$items = [
	[
		'title'       => 'Nowi pracownicy',
		'description' => 'Podstawowe informacje, materiały i odnośniki dla osób rozpoczynających pracę w Instytucie.',
		'url'         => '#',
	],
	[
		'title'       => 'Osoby z zagranicy',
		'description' => 'Przydatne informacje organizacyjne i formalne dla pracowników i współpracowników spoza Polski.',
		'url'         => '#',
	],
	[
		'title'       => 'Doktoranci',
		'description' => 'Zasoby i odnośniki wspierające osoby rozpoczynające ścieżkę kształcenia i pracy badawczej.',
		'url'         => '#',
	],
];

if (function_exists('have_rows') && have_rows('career_onboarding_links', $post_id)) {
	$items = [];

	while (have_rows('career_onboarding_links', $post_id)) {
		the_row();

		$link = get_sub_field('link');
		$url  = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$items[] = [
			'title'       => get_sub_field('title') ?: '',
			'description' => get_sub_field('description') ?: '',
			'url'         => $url,
		];
	}
}
?>

<div class="career-onboarding">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-onboarding-heading" class="section-title">
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

	<?php if (!empty($items)) : ?>
		<div class="career-onboarding__grid">
			<?php foreach ($items as $item) : ?>
				<article class="career-onboarding__card">
					<a class="career-onboarding__link" href="<?php echo esc_url($item['url']); ?>">
						<h3 class="career-onboarding__title">
							<?php echo esc_html($item['title']); ?>
						</h3>

						<?php if (!empty($item['description'])) : ?>
							<p class="career-onboarding__text">
								<?php echo esc_html($item['description']); ?>
							</p>
						<?php endif; ?>

						<span class="career-onboarding__cta">
							Przejdź dalej
						</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>