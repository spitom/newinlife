<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$name    = inlife_get_acf_field( 'contact_name', $post_id, inlife_t( 'InLife Instytut Rozrodu Zwierząt i Badań Żywności Polskiej Akademii Nauk' ) );
$address = inlife_get_acf_field( 'contact_address', $post_id, 'ul. Trylińskiego 18' );
$city    = inlife_get_acf_field( 'contact_city', $post_id, '10-683 Olsztyn' );
$phones_raw = inlife_get_acf_field(
	'contact_phones',
	$post_id,
	[]
);

$emails_raw = inlife_get_acf_field(
	'contact_emails',
	$post_id,
	[]
);

$phones = [];

if ( is_array( $phones_raw ) ) {
	foreach ( $phones_raw as $phone_item ) {
		$label = isset( $phone_item['phone_label'] )
			? trim( (string) $phone_item['phone_label'] )
			: '';

		$number = isset( $phone_item['phone_number'] )
			? trim( (string) $phone_item['phone_number'] )
			: '';

		if ( '' === $number ) {
			continue;
		}

		$phone_href = preg_replace(
			'/[^0-9+]/',
			'',
			$number
		);

		if ( '' === $phone_href ) {
			continue;
		}

		$phones[] = [
			'label'  => $label,
			'number' => $number,
			'href'   => $phone_href,
		];
	}
}

$emails = [];

if ( is_array( $emails_raw ) ) {
	foreach ( $emails_raw as $email_item ) {
		$label = isset( $email_item['email_label'] )
			? trim( (string) $email_item['email_label'] )
			: '';

		$email_address = isset( $email_item['email_address'] )
			? sanitize_email( $email_item['email_address'] )
			: '';

		if ( '' === $email_address ) {
			continue;
		}

		$emails[] = [
			'label'   => $label,
			'address' => $email_address,
		];
	}
}

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

			<?php if ( $phones || $emails ) : ?>
				<div class="contact-main__links">

					<?php foreach ( $phones as $phone_item ) : ?>
						<p class="contact-main__link">

							<span
								class="contact-main__icon"
								aria-hidden="true"
							>
								<i class="bi bi-telephone"></i>
							</span>

							<span class="contact-main__link-content">
								<?php if ( '' !== $phone_item['label'] ) : ?>
									<span class="contact-main__link-label">
										<?php echo esc_html( $phone_item['label'] ); ?>:
									</span>
								<?php endif; ?>

								<a href="<?php echo esc_url( 'tel:' . $phone_item['href'] ); ?>">
									<?php echo esc_html( $phone_item['number'] ); ?>
								</a>
							</span>

						</p>
					<?php endforeach; ?>

					<?php foreach ( $emails as $email_item ) : ?>
						<p class="contact-main__link">

							<span
								class="contact-main__icon"
								aria-hidden="true"
							>
								<i class="bi bi-envelope"></i>
							</span>

							<span class="contact-main__link-content">
								<?php if ( '' !== $email_item['label'] ) : ?>
									<span class="contact-main__link-label">
										<?php echo esc_html( $email_item['label'] ); ?>:
									</span>
								<?php endif; ?>

								<?php
								if ( function_exists( 'inlife_render_obfuscated_email_link' ) ) {
									echo inlife_render_obfuscated_email_link(
										$email_item['address'],
										'contact-main__email'
									); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									$obfuscated_email = antispambot(
										$email_item['address']
									);

									echo '<a class="contact-main__email" href="' .
										esc_url( 'mailto:' . $obfuscated_email ) .
										'">' .
										esc_html( $obfuscated_email ) .
										'</a>';
								}
								?>
							</span>

						</p>
					<?php endforeach; ?>

				</div>
			<?php endif; ?>
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
				data-zoom-in-label="<?php echo esc_attr( inlife_t( 'Powiększ mapę' ) ); ?>"
				data-zoom-out-label="<?php echo esc_attr( inlife_t( 'Pomniejsz mapę' ) ); ?>"
				data-marker-label="<?php echo esc_attr( inlife_t( 'Pokaż lokalizację Instytutu na mapie' ) ); ?>"
				role="region"
				aria-label="<?php echo esc_attr( inlife_t( 'Mapa lokalizacji Instytutu' ) ); ?>"
			></div>
		<?php else : ?>
			<div class="contact-map contact-map--placeholder">
				<p><?php echo esc_html( inlife_t( 'Mapa zostanie uzupełniona po dodaniu współrzędnych.' ) ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>