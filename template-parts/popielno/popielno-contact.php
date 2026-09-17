<?php
/**
 * Popielno — Contact.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$kicker = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_kicker', $post_id, '' ) )
	: '';

$title = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_title', $post_id, '' ) )
	: '';

$name = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_name', $post_id, '' ) )
	: '';

$address = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_address', $post_id, '' ) )
	: '';

$city = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_city', $post_id, '' ) )
	: '';

$phone = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_phone', $post_id, '' ) )
	: '';

$email = function_exists( 'inlife_get_acf_field' )
	? sanitize_email( inlife_get_acf_field( 'popielno_contact_email', $post_id, '' ) )
	: '';

$lat = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_latitude', $post_id, '' ) )
	: '';

$lng = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_longitude', $post_id, '' ) )
	: '';

if ( '' === $kicker ) {
	$kicker = inlife_t( 'Kontakt' );
}

if ( '' === $title ) {
	$title = inlife_t( 'Skontaktuj się ze Stacją' );
}

if ( '' === $name ) {
	$name = inlife_t( 'Stacja Badawcza w Popielnie' );
}

$phone_href = preg_replace( '/[^0-9+]/', '', $phone );

$form_shortcode = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_contact_form_shortcode', $post_id, '' ) )
	: '';
?>

<section
	id="kontakt"
	class="page-section popielno-contact"
	aria-labelledby="popielno-contact-heading"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $kicker,
				'title'    => $title,
				'title_id' => 'popielno-contact-heading',
			]
		);
		?>

		<div class="popielno-contact__layout">

			<div class="popielno-contact__details">

				<h3 class="popielno-contact__name">
					<?php echo esc_html( $name ); ?>
				</h3>

				<?php if ( $address || $city ) : ?>
					<address class="popielno-contact__address">
						<?php if ( $address ) : ?>
							<?php echo esc_html( $address ); ?>
						<?php endif; ?>

						<?php if ( $address && $city ) : ?>
							<br>
						<?php endif; ?>

						<?php if ( $city ) : ?>
							<?php echo esc_html( $city ); ?>
						<?php endif; ?>
					</address>
				<?php endif; ?>

				<?php if ( $phone || $email ) : ?>
					<div class="popielno-contact__links">

						<?php if ( $phone && $phone_href ) : ?>
							<p class="popielno-contact__link">
								<span class="popielno-contact__icon" aria-hidden="true">
									<i class="bi bi-telephone"></i>
								</span>

								<a href="<?php echo esc_url( 'tel:' . $phone_href ); ?>">
									<?php echo esc_html( $phone ); ?>
								</a>
							</p>
						<?php endif; ?>

						<?php if ( $email ) : ?>
							<p class="popielno-contact__link">
								<span class="popielno-contact__icon" aria-hidden="true">
									<i class="bi bi-envelope"></i>
								</span>

								<?php
								if ( function_exists( 'inlife_render_obfuscated_email_link' ) ) {
									echo inlife_render_obfuscated_email_link(
										$email,
										'popielno-contact__email'
									); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									echo '<a class="popielno-contact__email" href="' .
										esc_url( 'mailto:' . $email ) .
										'">' .
										esc_html( $email ) .
										'</a>';
								}
								?>
							</p>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			</div>

			<div class="popielno-contact__map-wrap">
				<?php if ( $lat && $lng ) : ?>
					<div
						class="contact-map popielno-contact__map"
						data-contact-map
						data-lat="<?php echo esc_attr( $lat ); ?>"
						data-lng="<?php echo esc_attr( $lng ); ?>"
                        data-zoom="13"
						data-title="<?php echo esc_attr( $name ); ?>"
						data-zoom-in-label="<?php echo esc_attr( inlife_t( 'Powiększ mapę' ) ); ?>"
						data-zoom-out-label="<?php echo esc_attr( inlife_t( 'Pomniejsz mapę' ) ); ?>"
						data-marker-label="<?php echo esc_attr( inlife_t( 'Pokaż lokalizację Stacji na mapie' ) ); ?>"
						role="region"
						aria-label="<?php echo esc_attr( inlife_t( 'Mapa lokalizacji Stacji Badawczej w Popielnie' ) ); ?>"
					></div>
				<?php else : ?>
					<div class="contact-map contact-map--placeholder popielno-contact__map">
						<p>
							<?php echo esc_html( inlife_t( 'Mapa zostanie uzupełniona po dodaniu współrzędnych.' ) ); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>

		</div>

        <?php if ( '' !== $form_shortcode ) : ?>
            <div
                class="popielno-contact__form"
                aria-labelledby="popielno-contact-form-heading"
            >
                <div class="popielno-contact__form-header">
                    <h3
                        id="popielno-contact-form-heading"
                        class="popielno-contact__form-title"
                    >
                        <?php echo esc_html( inlife_t( 'Napisz do nas' ) ); ?>
                    </h3>

                    <p class="popielno-contact__form-lead">
                        <?php
                        echo esc_html(
                            inlife_t(
                                'Masz pytanie dotyczące Stacji Badawczej? Skontaktuj się z nami za pomocą formularza.'
                            )
                        );
                        ?>
                    </p>
                </div>

                <div class="popielno-contact__form-body inlife-form inlife-form--line">
                    <?php
                    echo do_shortcode( $form_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?>
                </div>
            </div>
        <?php endif; ?>

	</div>
</section>
