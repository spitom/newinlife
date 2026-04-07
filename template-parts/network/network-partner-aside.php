<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'partner' => [],
	]
);

$partner = is_array( $args['partner'] ) ? $args['partner'] : [];

$city              = $partner['city'] ?? '';
$country           = $partner['country'] ?? '';
$address           = $partner['address'] ?? '';
$email             = $partner['email'] ?? '';
$phone             = $partner['phone'] ?? '';
$website           = $partner['website'] ?? '';
$cooperation_link  = $partner['cooperation_link'] ?? '';
$cooperation_label = $partner['cooperation_label'] ?? '';
?>

<aside class="network-partner-aside">
	<div class="network-partner-aside__card">
		<h2 class="network-partner-aside__title">
			<?php echo esc_html( inlife_t( 'Dane partnera' ) ); ?>
		</h2>

		<dl class="network-partner-aside__list">
			<?php if ( $country ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'Kraj' ) ); ?></dt>
					<dd><?php echo esc_html( $country ); ?></dd>
				</div>
			<?php endif; ?>

			<?php if ( $city ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'Miasto' ) ); ?></dt>
					<dd><?php echo esc_html( $city ); ?></dd>
				</div>
			<?php endif; ?>

			<?php if ( $address ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'Adres' ) ); ?></dt>
					<dd><?php echo nl2br( esc_html( $address ) ); ?></dd>
				</div>
			<?php endif; ?>

			<?php if ( $email ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'E-mail' ) ); ?></dt>
					<dd><a href="mailto:<?php echo antispambot( esc_attr( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></dd>
				</div>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'Telefon' ) ); ?></dt>
					<dd><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></dd>
				</div>
			<?php endif; ?>

			<?php if ( $website ) : ?>
				<div class="network-partner-aside__row">
					<dt><?php echo esc_html( inlife_t( 'Strona www' ) ); ?></dt>
					<dd>
						<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( preg_replace( '#^https?://#', '', $website ) ); ?>
						</a>
					</dd>
				</div>
			<?php endif; ?>
		</dl>

		<?php if ( $cooperation_link ) : ?>
			<div class="network-partner-aside__actions">
				<a
					class="btn btn-outline-primary w-100"
					href="<?php echo esc_url( $cooperation_link ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<?php echo esc_html( $cooperation_label ?: inlife_t( 'Zobacz współpracę' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</aside>