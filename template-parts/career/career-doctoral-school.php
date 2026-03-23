<?php
/**
 * Career doctoral school teaser
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
	'career_doctoral_school_kicker',
	$post_id,
	'Rozwój naukowy'
);

$section_title = inlife_get_acf_field(
	'career_doctoral_school_title',
	$post_id,
	'Szkoła Doktorska'
);

$section_text = inlife_get_acf_field(
	'career_doctoral_school_text',
	$post_id,
	'Osoby zainteresowane rozwojem naukowym mogą kontynuować swoją ścieżkę w Szkole Doktorskiej prowadzonej przy Instytucie. To przestrzeń do pogłębiania kompetencji badawczych, pracy z zespołami naukowymi i realizacji ambitnych projektów.'
);

$cta_label = inlife_get_acf_field(
	'career_doctoral_school_cta_label',
	$post_id,
	'Przejdź do strony Szkoły Doktorskiej'
);

$cta_url = inlife_get_acf_field(
	'career_doctoral_school_cta_url',
	$post_id,
	'https://sd.pan.olsztyn.pl/'
);
?>

<div class="career-doctoral-school">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-doctoral-school-heading" class="section-title">
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
			<a
				href="<?php echo esc_url($cta_url); ?>"
				class="btn btn-outline-primary"
				target="_blank"
				rel="noopener noreferrer"
			>
				<?php echo esc_html($cta_label); ?>
			</a>
		</div>
	</div>
</div>