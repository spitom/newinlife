<?php
/**
 * Template Name: Network
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container      = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$partners_query = inlife_get_network_partners_query();
$region_terms   = inlife_get_partner_region_terms();
$map_data       = inlife_get_network_map_data( $partners_query );

$title = get_the_title();
$lead  = function_exists( 'get_field' ) ? get_field( 'network_lead' ) : '';

if ( ! $lead ) {
	$lead = inlife_t( 'Rozwijamy międzynarodową sieć współpracy naukowej i instytucjonalnej, łącząc partnerów z różnych regionów świata w obszarach żywności, zdrowia i nauk o zwierzętach.' );
}
?>

<main id="main-content" class="site-main site-main--network">

	<section class="page-section page-section--network-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Sieć współpracy' ),
				'title'       => $title,
				'lead'        => $lead,
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<?php
	get_template_part(
		'template-parts/network/network-filters',
		null,
		[
			'container'    => $container,
			'region_terms' => $region_terms,
		]
	);

	get_template_part(
		'template-parts/network/network-map',
		null,
		[
			'container' => $container,
			'map_data'  => $map_data,
		]
	);

	get_template_part(
		'template-parts/network/network-partners-grid',
		null,
		[
			'container'      => $container,
			'partners_query' => $partners_query,
		]
	);
	?>
</main>

<?php
wp_reset_postdata();
get_footer();