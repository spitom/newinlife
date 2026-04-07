<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'container'    => 'container',
		'region_terms' => [],
	]
);

$container    = $args['container'];
$region_terms = is_array( $args['region_terms'] ) ? $args['region_terms'] : [];
?>

<section class="network-filters section-spacing-sm" aria-labelledby="network-filters-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="network-filters__inner">
			<h2 id="network-filters-heading" class="visually-hidden">
				<?php echo esc_html( inlife_t( 'Filtry partnerów' ) ); ?>
			</h2>

			<div class="network-filters__list" role="toolbar" aria-label="<?php echo esc_attr( inlife_t( 'Filtruj partnerów według regionu' ) ); ?>">
				<button
					type="button"
					class="network-filter is-active"
					data-network-filter="all"
					aria-pressed="true"
				>
					<?php echo esc_html( inlife_t( 'Wszyscy partnerzy' ) ); ?>
				</button>

				<?php foreach ( $region_terms as $term ) : ?>
					<button
						type="button"
						class="network-filter"
						data-network-filter="<?php echo esc_attr( $term->slug ); ?>"
						aria-pressed="false"
					>
						<?php echo esc_html( $term->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>