<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'container' => 'container',
		'partner'   => [],
	]
);

$container = $args['container'];
$partner   = is_array( $args['partner'] ) ? $args['partner'] : [];

$title        = $partner['title'] ?? '';
$city         = $partner['city'] ?? '';
$country      = $partner['country'] ?? '';
$location     = trim( implode( ', ', array_filter( [ $city, $country ] ) ) );
$logo         = $partner['logo'] ?? null;
$hero_image   = $partner['hero_image'] ?? null;
$region_names = $partner['region_names'] ?? [];
?>

<section class="network-partner-header section-spacing">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="network-partner-header__top">
			<div class="network-partner-header__content">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Partner sieci' ) ); ?>
				</p>

				<h1 class="network-partner-header__title">
					<?php echo esc_html( $title ); ?>
				</h1>

				<?php if ( $location ) : ?>
					<p class="network-partner-header__location">
						<?php echo esc_html( $location ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $region_names ) ) : ?>
					<ul class="network-partner-header__regions" aria-label="<?php echo esc_attr( inlife_t( 'Regiony partnera' ) ); ?>">
						<?php foreach ( $region_names as $region_name ) : ?>
							<li><?php echo esc_html( $region_name ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="network-partner-header__media">
				<?php if ( ! empty( $hero_image['ID'] ) ) : ?>
					<div class="network-partner-header__hero">
						<?php
						echo wp_get_attachment_image(
							$hero_image['ID'],
							'large',
							false,
							[
								'class' => 'img-fluid',
								'alt'   => '',
							]
						);
						?>
					</div>
				<?php elseif ( ! empty( $logo['ID'] ) ) : ?>
					<div class="network-partner-header__logo-card">
						<?php
						echo wp_get_attachment_image(
							$logo['ID'],
							'medium_large',
							false,
							[
								'class' => 'img-fluid',
								'alt'   => '',
							]
						);
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>