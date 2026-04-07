<?php
defined( 'ABSPATH' ) || exit;

$args      = wp_parse_args(
	$args ?? [],
	[
		'container' => 'container',
	]
);
$container = $args['container'];

$title = get_the_title();
$lead  = get_field( 'network_lead' );

if ( ! $lead ) {
	$lead = inlife_t( 'Rozwijamy międzynarodową sieć współpracy naukowej i instytucjonalnej, łącząc partnerów z różnych regionów świata w obszarach żywności, zdrowia i nauk o zwierzętach.' );
}
?>

<section class="network-hero section-spacing">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="network-hero__inner">
			<p class="section-kicker"><?php echo esc_html( inlife_t( 'Sieć współpracy' ) ); ?></p>

			<h1 class="network-hero__title"><?php echo esc_html( $title ); ?></h1>

			<div class="network-hero__lead">
				<p><?php echo esc_html( $lead ); ?></p>
			</div>
		</div>
	</div>
</section>