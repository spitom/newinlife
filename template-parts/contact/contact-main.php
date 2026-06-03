<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$name    = inlife_get_acf_field( 'contact_name', $post_id, inlife_t( 'InLife Instytut Rozrodu Zwierząt i Badań Żywności Polskiej Akademii Nauk' ) );
$address = inlife_get_acf_field( 'contact_address', $post_id, 'ul. Trylińskiego 18' );
$city    = inlife_get_acf_field( 'contact_city', $post_id, '10-683 Olsztyn' );
$phone   = inlife_get_acf_field( 'contact_phone', $post_id, '+48 89 500 32 00' );
$email   = inlife_get_acf_field( 'contact_email', $post_id, 'instytut@pan.olsztyn.pl' );

$lat = inlife_get_acf_field( 'contact_latitude', $post_id, '' );
$lng = inlife_get_acf_field( 'contact_longitude', $post_id, '' );
?>

<div class="contact-main">
	<div class="contact-main__content">
		<div class="section-heading section-heading--left">
			<h2 id="contact-main-heading" class="section-title">
				<?php echo esc_html( inlife_t( 'Dane kontaktowe' ) ); ?>
			</h2>
		</div>

		<div class="contact-main__details">
			<h3 class="contact-main__name">
				<?php echo esc_html( $name ); ?>
			</h3>

			<address class="contact-main__address">
				<?php echo esc_html( $address ); ?><br>
				<?php echo esc_html( $city ); ?>
			</address>

			<div class="contact-main__links">
				<?php if ( $phone ) : ?>
					<p class="contact-main__link">
						<span class="contact-main__icon" aria-hidden="true">
							<i class="bi bi-telephone"></i>
						</span>

						<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
							<?php echo esc_html( $phone ); ?>
						</a>
					</p>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<p class="contact-main__link">
						<span class="contact-main__icon" aria-hidden="true">
							<i class="bi bi-envelope"></i>
						</span>

						<?php
						if ( function_exists( 'inlife_render_obfuscated_email_link' ) ) {
							echo inlife_render_obfuscated_email_link(
								$email,
								'contact-main__email'
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							echo '<a class="contact-main__email" href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
						}
						?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="contact-main__map-wrap">
		<?php if ( $lat && $lng ) : ?>
			<div
				class="contact-map"
				data-contact-map
				data-lat="<?php echo esc_attr( $lat ); ?>"
				data-lng="<?php echo esc_attr( $lng ); ?>"
				data-title="<?php echo esc_attr( $name ); ?>"
			></div>
		<?php else : ?>
			<div class="contact-map contact-map--placeholder">
				<p><?php echo esc_html( inlife_t( 'Mapa zostanie uzupełniona po dodaniu współrzędnych.' ) ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>