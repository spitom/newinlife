<?php
/**
 * Business contact
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
	'business_contact_kicker',
	$post_id,
	'Kontakt'
);

$section_title = inlife_get_acf_field(
	'business_contact_title',
	$post_id,
	'Porozmawiajmy o współpracy'
);

$section_text = inlife_get_acf_field(
	'business_contact_text',
	$post_id,
	'Jeśli chcesz omówić możliwy zakres współpracy, usługi laboratoryjne, rozwój technologii albo projekt wdrożeniowy, skontaktuj się z nami. Wspólnie dobierzemy najlepszy model działania.'
);

$person_name = inlife_get_acf_field(
	'business_contact_person_name',
	$post_id,
	'Imię i nazwisko'
);

$person_role = inlife_get_acf_field(
	'business_contact_person_role',
	$post_id,
	'Koordynacja współpracy z biznesem'
);

$person_email = inlife_get_acf_field(
	'business_contact_email',
	$post_id,
	'instytut@pan.olsztyn.pl'
);

$person_phone = inlife_get_acf_field(
	'business_contact_phone',
	$post_id,
	'+48 89 500 32 00'
);

$form_shortcode = inlife_get_acf_field(
	'business_contact_form_shortcode',
	$post_id,
	''
);

$cta_label = inlife_get_acf_field(
	'business_contact_cta_label',
	$post_id,
	'Napisz do nas'
);

$cta_url = inlife_get_acf_field(
	'business_contact_cta_url',
	$post_id,
	'mailto:' . $person_email
);
?>

<div class="business-contact">
	<div class="row g-4 align-items-end business-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="business-contact-heading" class="section-title">
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

	<div class="business-contact__layout">
		<div class="business-contact__info">
			<div class="business-contact__card">
				<h3 class="business-contact__card-title">
					Dane kontaktowe
				</h3>

				<div class="business-contact__person">
					<p class="business-contact__person-name">
						<?php echo esc_html($person_name); ?>
					</p>

					<?php if (!empty($person_role)) : ?>
						<p class="business-contact__person-role">
							<?php echo esc_html($person_role); ?>
						</p>
					<?php endif; ?>
				</div>

				<div class="business-contact__details">
					<?php if (!empty($person_email)) : ?>
						<p class="business-contact__detail">
							<span class="business-contact__detail-label">E-mail</span>
							<a href="mailto:<?php echo esc_attr(antispambot($person_email)); ?>">
								<?php echo esc_html(antispambot($person_email)); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if (!empty($person_phone)) : ?>
						<p class="business-contact__detail">
							<span class="business-contact__detail-label">Telefon</span>
							<a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $person_phone)); ?>">
								<?php echo esc_html($person_phone); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>

				<div class="business-contact__actions">
					<a class="business-contact__button btn btn-primary" href="<?php echo esc_url($cta_url); ?>">
						<?php echo esc_html($cta_label); ?>
					</a>
				</div>
			</div>
		</div>

		<div class="business-contact__form">
			<div class="business-contact__form-card">
				<h3 class="business-contact__form-title">Formularz kontaktowy</h3>

				<?php if (!empty($form_shortcode)) : ?>
					<div class="business-contact__form-shortcode">
						<?php echo do_shortcode($form_shortcode); ?>
					</div>
				<?php else : ?>
					<div class="business-contact__form-placeholder">
						<p>Tu pojawi się formularz kontaktowy.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>