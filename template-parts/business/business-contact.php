<?php
/**
 * Business contact (merged cooperation + contact)
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

/**
 * Section content
 */
$section_kicker = inlife_get_acf_field(
	'business_contact_kicker',
	$post_id,
	inlife_t( 'Współpraca' )
);

$section_title = inlife_get_acf_field(
	'business_contact_title',
	$post_id,
	inlife_t( 'Porozmawiajmy o współpracy' )
);

$section_text = inlife_get_acf_field(
	'business_contact_text',
	$post_id,
	inlife_t( 'Współpracujemy z firmami, instytucjami i partnerami badawczo-rozwojowymi w zakresie badań, analiz, wdrożeń oraz projektów innowacyjnych. Skontaktuj się z nami, aby omówić potrzeby i możliwe kierunki współpracy.' )
);

/**
 * Contact data
 */
$contact_name  = inlife_get_acf_field( 'business_contact_name', $post_id, '' );
$contact_role  = inlife_get_acf_field( 'business_contact_role', $post_id, '' );
$contact_email = inlife_get_acf_field( 'business_contact_email', $post_id, '' );
$contact_phone = inlife_get_acf_field( 'business_contact_phone', $post_id, '' );

/**
 * Form (shortcode)
 */
$form_shortcode = inlife_get_acf_field( 'business_contact_form', $post_id, '' );

?>

<div class="business-contact">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-contact-heading',
		]
	);
	?>

	<div class="business-contact__layout">

		<!-- LEFT: CONTACT -->
		<div class="business-contact__info">
			<div class="business-contact__card business-contact__card--info c-surface c-surface--panel">

				<p class="business-contact__eyebrow">
					<?php echo esc_html( inlife_t( 'Kontakt dla biznesu' ) ); ?>
				</p>

				<p class="business-contact__name">
					<?php echo esc_html( $contact_name ?: inlife_t( 'Zespół współpracy z biznesem' ) ); ?>
				</p>

				<p class="business-contact__role">
					<?php echo esc_html( $contact_role ?: inlife_t( 'Koordynacja usług, analiz i projektów B+R' ) ); ?>
				</p>

				<div class="business-contact__details">
					<?php if ( $contact_email ) : ?>
						<p class="business-contact__item">
							<span class="business-contact__icon bi bi-envelope" aria-hidden="true"></span>
							<a href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"></a>
						</p>
					<?php endif; ?>

					<?php if ( $contact_phone ) : ?>
						<p class="business-contact__item">
							<span class="business-contact__icon bi bi-telephone" aria-hidden="true"></span>
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $contact_phone ) ); ?>">
								<?php echo esc_html( $contact_phone ); ?>
							</a>
						</p>
					<?php endif; ?>

				</div>

			</div>
		</div>

		<!-- RIGHT: FORM -->
		<div class="business-contact__form">

			<div class="business-contact__card c-surface c-surface--panel">

				<?php if ( $form_shortcode ) : ?>
					<div class="business-contact__form-inner">
						<?php echo do_shortcode( $form_shortcode ); ?>
					</div>
				<?php else : ?>
					<p class="business-contact__placeholder">
						<?php echo esc_html( inlife_t( 'Formularz kontaktowy w przygotowaniu.' ) ); ?>
					</p>
				<?php endif; ?>

			</div>

		</div>

	</div>

</div>