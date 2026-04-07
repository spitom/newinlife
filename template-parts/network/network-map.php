<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'container' => 'container',
		'map_data'  => [],
	]
);

$container = $args['container'];
$map_data  = is_array( $args['map_data'] ) ? $args['map_data'] : [];
$map_id    = 'network-map-canvas';
?>

<section class="network-map section-spacing-sm" aria-labelledby="network-map-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="network-map__header">
			<h2 id="network-map-heading" class="section-title">
				<?php echo esc_html( inlife_t( 'Partnerzy na świecie' ) ); ?>
			</h2>

			<p class="network-map__intro">
				<?php echo esc_html( inlife_t( 'Mapa pokazuje lokalizacje naszych partnerów. Pełna lista partnerów znajduje się poniżej i pozostaje podstawową, w pełni dostępną formą nawigacji.' ) ); ?>
			</p>
		</div>

		<div class="network-map__frame">
			<div
				id="<?php echo esc_attr( $map_id ); ?>"
				class="network-map__canvas"
				data-network-map
				data-network-map-id="<?php echo esc_attr( $map_id ); ?>"
				data-network-map-data="<?php echo esc_attr( wp_json_encode( $map_data ) ); ?>"
				data-network-map-empty-label="<?php echo esc_attr( inlife_t( 'Brak partnerów z przypisanymi współrzędnymi.' ) ); ?>"
				data-network-map-link-label="<?php echo esc_attr( inlife_t( 'Zobacz partnera' ) ); ?>"
				aria-label="<?php echo esc_attr( inlife_t( 'Interaktywna mapa partnerów' ) ); ?>"
			></div>

			<noscript>
				<p class="network-map__noscript">
					<?php echo esc_html( inlife_t( 'Mapa wymaga obsługi JavaScript. Skorzystaj z listy partnerów poniżej.' ) ); ?>
				</p>
			</noscript>
		</div>
	</div>
</section>