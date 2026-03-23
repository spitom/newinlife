<?php
/**
 * Business hero
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$post_id = get_the_ID();

/**
 * Fallback bezpieczeństwa:
 * jeśli helper nie jest jeszcze załadowany,
 * zdefiniuj lokalną wersję awaryjną.
 */
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
	'business_hero_kicker',
	$post_id,
	'Biznes'
);

$title = inlife_get_acf_field(
	'business_hero_title',
	$post_id,
	'Rozwiązania dla przemysłu i partnerów zewnętrznych'
);

$lead = inlife_get_acf_field(
	'business_hero_lead',
	$post_id,
	'Wspieramy firmy i instytucje poprzez usługi laboratoryjne, transfer wiedzy, rozwój technologii oraz współpracę badawczo-rozwojową. Łączymy zaplecze naukowe z praktycznym podejściem do potrzeb biznesu.'
);

$primary_label = inlife_get_acf_field(
	'business_hero_cta_primary_label',
	$post_id,
	'Skontaktuj się z nami'
);

$primary_url = inlife_get_acf_field(
	'business_hero_cta_primary_url',
	$post_id,
	'#business-contact-heading'
);

$secondary_label = inlife_get_acf_field(
	'business_hero_cta_secondary_label',
	$post_id,
	'Zobacz usługi'
);

$secondary_url = inlife_get_acf_field(
	'business_hero_cta_secondary_url',
	$post_id,
	'#business-services-industries-heading'
);

$media_mode = inlife_get_acf_field(
	'business_hero_media_mode',
	$post_id,
	'placeholder'
);

$hero_image = inlife_get_acf_field(
	'business_hero_image',
	$post_id,
	null
);

/**
 * Normalizacja obrazu ACF.
 * Zakładam return format = array.
 */
$hero_image_url = '';
$hero_image_alt = '';

if (is_array($hero_image) && !empty($hero_image['url'])) {
	$hero_image_url = $hero_image['url'];
	$hero_image_alt = !empty($hero_image['alt']) ? $hero_image['alt'] : $title;
}
?>

<div class="business-hero">
	<div class="business-hero__inner">
		<div class="business-hero__content">
			<?php if ($kicker) : ?>
				<p class="business-hero__kicker section-kicker">
					<?php echo esc_html($kicker); ?>
				</p>
			<?php endif; ?>

			<h1 id="business-hero-heading" class="business-hero__title section-title">
				<?php echo esc_html($title); ?>
			</h1>

			<?php if ($lead) : ?>
				<div class="business-hero__lead">
					<p><?php echo esc_html($lead); ?></p>
				</div>
			<?php endif; ?>

			<div class="business-hero__actions">
				<a
					class="business-hero__button business-hero__button--primary btn btn-primary"
					href="<?php echo esc_url($primary_url); ?>"
				>
					<?php echo esc_html($primary_label); ?>
				</a>

				<a
					class="business-hero__button business-hero__button--secondary btn btn-outline-primary"
					href="<?php echo esc_url($secondary_url); ?>"
				>
					<?php echo esc_html($secondary_label); ?>
				</a>
			</div>
		</div>

		<div class="business-hero__media">
			<?php if ('image' === $media_mode && $hero_image_url) : ?>
				<div class="business-hero__media-frame business-hero__media-frame--image">
					<img
						class="business-hero__image"
						src="<?php echo esc_url($hero_image_url); ?>"
						alt="<?php echo esc_attr($hero_image_alt); ?>"
						loading="eager"
						decoding="async"
					>
				</div>
			<?php else : ?>
				<div class="business-hero__media-frame business-hero__media-frame--placeholder" aria-hidden="true">
					<div class="business-hero__placeholder">
						<div class="business-hero__placeholder-badge">Współpraca z biznesem</div>

						<div class="business-hero__placeholder-grid">
							<div class="business-hero__placeholder-card">
								<span class="business-hero__placeholder-label">Usługi</span>
							</div>

							<div class="business-hero__placeholder-card">
								<span class="business-hero__placeholder-label">Technologie</span>
							</div>

							<div class="business-hero__placeholder-card">
								<span class="business-hero__placeholder-label">Laboratoria</span>
							</div>

							<div class="business-hero__placeholder-card">
								<span class="business-hero__placeholder-label">Case studies</span>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>