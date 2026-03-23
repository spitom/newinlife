<?php
/**
 * Career job offers teaser
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
	'career_job_offers_kicker',
	$post_id,
	'Praca'
);

$section_title = inlife_get_acf_field(
	'career_job_offers_title',
	$post_id,
	'Oferty pracy i konkursy'
);

$section_text = inlife_get_acf_field(
	'career_job_offers_text',
	$post_id,
	'W jednym miejscu zebraliśmy aktualne oferty pracy, konkursy na stanowiska, wyniki naborów, ogłoszenia archiwalne oraz materiały wspierające kandydatów. Przejdź do dedykowanej podstrony, aby zobaczyć wszystkie kategorie i aktualne informacje.'
);

$cta_label = inlife_get_acf_field(
	'career_job_offers_cta_label',
	$post_id,
	'Przejdź do ofert'
);

$cta_url = inlife_get_acf_field(
	'career_job_offers_cta_url',
	$post_id,
	home_url('/kariera/konkursy-i-oferty-pracy/')
);
?>

<div class="career-job-offers">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-job-offers-heading" class="section-title">
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
</div>