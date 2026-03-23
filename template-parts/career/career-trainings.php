<?php
/**
 * Career trainings teaser
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
	'career_trainings_kicker',
	$post_id,
	'Rozwój'
);

$section_title = inlife_get_acf_field(
	'career_trainings_title',
	$post_id,
	'Szkolenia i rozwój kompetencji'
);

$section_text = inlife_get_acf_field(
	'career_trainings_text',
	$post_id,
	'Wspieramy rozwój kompetencji zawodowych i naukowych poprzez szkolenia, warsztaty oraz inicjatywy rozwojowe. W tej sekcji docelowo może pojawić się harmonogram, kalendarz i możliwość zapisów.'
);

$cta_label = inlife_get_acf_field(
	'career_trainings_cta_label',
	$post_id,
	'Zobacz szkolenia'
);

$cta_url = inlife_get_acf_field(
	'career_trainings_cta_url',
	$post_id,
	'#'
);

$items = [
	[
		'title' => 'Warsztaty i kursy',
		'text'  => 'Rozwój praktycznych kompetencji wspierających pracę naukową, organizacyjną i projektową.',
	],
	[
		'title' => 'Kalendarz szkoleń',
		'text'  => 'Docelowo sekcja może prezentować harmonogram nadchodzących szkoleń i terminów zapisów.',
	],
	[
		'title' => 'Rozwój długofalowy',
		'text'  => 'Szkolenia wpisują się w szerszy model wzmacniania kompetencji oraz planowania ścieżek rozwoju.',
	],
];

if (function_exists('have_rows') && have_rows('career_trainings_items', $post_id)) {
	$items = [];

	while (have_rows('career_trainings_items', $post_id)) {
		the_row();

		$items[] = [
			'title' => get_sub_field('title') ?: '',
			'text'  => get_sub_field('text') ?: '',
		];
	}
}
?>

<div class="career-trainings">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-trainings-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>

			<?php if (!empty($section_text)) : ?>
				<p class="section-lead mt-3 mb-0">
					<?php echo esc_html($section_text); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="col-lg-4 text-lg-end">
			<a href="<?php echo esc_url($cta_url); ?>" class="btn btn-outline-primary">
				<?php echo esc_html($cta_label); ?>
			</a>
		</div>
	</div>

	<?php if (!empty($items)) : ?>
		<div class="career-trainings__grid">
			<?php foreach ($items as $item) : ?>
				<article class="career-trainings__card">
					<h3 class="career-trainings__card-title">
						<?php echo esc_html($item['title']); ?>
					</h3>

					<?php if (!empty($item['text'])) : ?>
						<p class="career-trainings__card-text">
							<?php echo esc_html($item['text']); ?>
						</p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>