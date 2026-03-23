<?php
/**
 * Career hero
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

$kicker = inlife_get_acf_field(
	'career_hero_kicker',
	$post_id,
	'Kariera'
);

$title = inlife_get_acf_field(
	'career_hero_title',
	$post_id,
	'Twórz naukę, rozwijaj kompetencje, pracuj w środowisku współpracy'
);

$lead = inlife_get_acf_field(
	'career_hero_lead',
	$post_id,
	'Budujemy miejsce pracy oparte na wiedzy, odpowiedzialności i wzajemnym szacunku. Oferujemy możliwości rozwoju zawodowego, udział w ambitnych projektach oraz ścieżki wejścia dla pracowników, doktorantów i osób rozpoczynających współpracę z Instytutem.'
);

$primary_label = inlife_get_acf_field(
	'career_hero_cta_primary_label',
	$post_id,
	'Zobacz oferty pracy'
);

$primary_url = inlife_get_acf_field(
	'career_hero_cta_primary_url',
	$post_id,
	'#career-job-offers-heading'
);

$secondary_label = inlife_get_acf_field(
	'career_hero_cta_secondary_label',
	$post_id,
	'Poznaj onboarding'
);

$secondary_url = inlife_get_acf_field(
	'career_hero_cta_secondary_url',
	$post_id,
	'#career-onboarding-heading'
);

$media_mode = inlife_get_acf_field(
	'career_hero_media_mode',
	$post_id,
	'placeholder'
);

$hero_image = inlife_get_acf_field(
	'career_hero_image',
	$post_id,
	null
);

$hero_image_url = '';
$hero_image_alt = '';

if (is_array($hero_image) && !empty($hero_image['url'])) {
	$hero_image_url = $hero_image['url'];
	$hero_image_alt = !empty($hero_image['alt']) ? $hero_image['alt'] : $title;
}
?>

<div class="career-hero">
	<div class="career-hero__inner">
		<div class="career-hero__content">
			<?php if ($kicker) : ?>
				<p class="career-hero__kicker section-kicker">
					<?php echo esc_html($kicker); ?>
				</p>
			<?php endif; ?>

			<h1 id="career-hero-heading" class="career-hero__title section-title">
				<?php echo esc_html($title); ?>
			</h1>

			<?php if ($lead) : ?>
				<div class="career-hero__lead">
					<p><?php echo esc_html($lead); ?></p>
				</div>
			<?php endif; ?>

			<div class="career-hero__actions">
				<a
					class="career-hero__button career-hero__button--primary btn btn-primary"
					href="<?php echo esc_url($primary_url); ?>"
				>
					<?php echo esc_html($primary_label); ?>
				</a>

				<a
					class="career-hero__button career-hero__button--secondary btn btn-outline-primary"
					href="<?php echo esc_url($secondary_url); ?>"
				>
					<?php echo esc_html($secondary_label); ?>
				</a>
			</div>
		</div>

		<div class="career-hero__media">
			<?php if ('image' === $media_mode && $hero_image_url) : ?>
				<div class="career-hero__media-frame career-hero__media-frame--image">
					<img
						class="career-hero__image"
						src="<?php echo esc_url($hero_image_url); ?>"
						alt="<?php echo esc_attr($hero_image_alt); ?>"
						loading="eager"
						decoding="async"
					>
				</div>
			<?php else : ?>
				<div class="career-hero__media-frame career-hero__media-frame--placeholder" aria-hidden="true">
					<div class="career-hero__placeholder">
						<div class="career-hero__placeholder-badge">Rozwój i możliwości</div>

						<div class="career-hero__placeholder-grid">
							<div class="career-hero__placeholder-card">
								<span class="career-hero__placeholder-label">Oferty pracy</span>
							</div>
							<div class="career-hero__placeholder-card">
								<span class="career-hero__placeholder-label">Szkolenia</span>
							</div>
							<div class="career-hero__placeholder-card">
								<span class="career-hero__placeholder-label">Szkoła Doktorska</span>
							</div>
							<div class="career-hero__placeholder-card">
								<span class="career-hero__placeholder-label">Onboarding</span>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>